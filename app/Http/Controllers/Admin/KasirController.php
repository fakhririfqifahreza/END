<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Services\WhatsappService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class KasirController extends Controller
{
    public function index(Request $request)
    {
        $query = Barang::query();

        if ($request->filled('search')) {
            $query->where('nama_barang', 'like', '%' . $request->search . '%');
        }

        $produks = $query->orderBy('nama_barang', 'asc')->get();

        return view('admin.kasir.index', compact('produks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:barang,id_barang',
            'items.*.qty' => 'required|numeric|min:0.01',
            'items.*.tukar_wadah' => 'nullable|in:0,1',
            'metode_pembayaran' => 'required|in:tunai,qris,transfer_bank',
            'bayar' => 'nullable|numeric|min:0',
            'no_wa_pelanggan' => 'nullable|string|max:20',
        ]);

        $items = $request->items;
        $totalHarga = 0;
        $metode = $request->input('metode_pembayaran', 'tunai');

        $barangHabis = [];
        $barangMenipis = [];
        $rincianItemStruk = [];

        DB::beginTransaction();
        try {
            // 1. Validasi stok ketersediaan & hitung total belanja
            foreach ($items as $item) {
                $produk = Barang::findOrFail($item['id']);
                preg_match('/^(\d+(?:\.\d+)?)/', (string)$produk->stok_barang, $matches);
                $stokTersedia = isset($matches[1]) ? floatval($matches[1]) : 0;

                if ($stokTersedia < $item['qty']) {
                    return back()->with('error', "Stok produk '{$produk->nama_barang}' tidak mencukupi (Sisa: {$stokTersedia})");
                }

                $isTukar = !isset($item['tukar_wadah']) || $item['tukar_wadah'] == '1';
                $hargaSatuan = $produk->harga_barang ?? 0;

                // Tambahkan harga wadah jika bukan tukar (beli unit baru)
                if ($produk->is_tukar_wadah && !$isTukar) {
                    $hargaSatuan += ($produk->harga_wadah ?? 0);
                }

                $totalHarga += round($hargaSatuan * $item['qty']);
            }

            // 2. Kalkulasi nominal bayar & kembalian
            if ($metode === 'tunai') {
                $bayar = floatval($request->bayar);
                if ($bayar < $totalHarga) {
                    return back()->with('error', 'Uang tunai yang dibayarkan kurang dari total belanja.');
                }
                $kembalian = $bayar - $totalHarga;
            } else {
                $bayar = $totalHarga;
                $kembalian = 0;
            }

            // 3. Simpan Header Transaksi
            $transaksi = Transaksi::create([
                'kode_transaksi' => 'TRX-' . strtoupper(uniqid()),
                'user_id' => Auth::id(),
                'nama_pelanggan' => $request->nama_pelanggan ?: 'Pembeli Langsung (Kasir)',
                'total_harga' => $totalHarga,
                'total_bayar' => $bayar,
                'kembalian' => $kembalian,
                'metode_pembayaran' => $metode,
                'status' => 'selesai',
            ]);

            // 4. Simpan Detail Transaksi, Perbarui Stok Barang & Wadah
            foreach ($items as $item) {
                $produk = Barang::findOrFail($item['id']);
                $isTukar = !isset($item['tukar_wadah']) || $item['tukar_wadah'] == '1';
                $hargaSatuan = $produk->harga_barang ?? 0;

                if ($produk->is_tukar_wadah && !$isTukar) {
                    $hargaSatuan += ($produk->harga_wadah ?? 0);
                }

                $subtotal = round($hargaSatuan * $item['qty']);

                TransaksiDetail::create([
                    'transaksi_id' => $transaksi->id ?? $transaksi->id_transaksi,
                    'barang_id'    => $produk->id_barang,
                    'nama_barang'  => $produk->nama_barang,
                    'harga'        => $hargaSatuan,
                    'qty'          => $item['qty'],
                    'subtotal'     => $subtotal,
                    'tukar_wadah'  => $produk->is_tukar_wadah ? ($isTukar ? 1 : 0) : 1,
                ]);

                // Format rincian untuk pesan WhatsApp
                $displayQty = ($item['qty'] == (int)$item['qty']) ? (int)$item['qty'] : (float)$item['qty'];
                $namaItemStruk = $produk->nama_barang;
                if ($produk->is_tukar_wadah) {
                    $namaItemStruk .= $isTukar ? ' (Tukar Wadah)' : ' (+Beli Tabung/Galon Baru)';
                }

                preg_match('/^(\d+(?:\.\d+)?)\s*(.*)$/', trim($produk->stok_barang), $matches);
                $angkaStok = isset($matches[1]) ? floatval($matches[1]) : 0;
                $satuan = isset($matches[2]) ? strtolower(trim($matches[2])) : 'pcs';

                $rincianItemStruk[] = [
                    'nama'     => $namaItemStruk,
                    'qty'      => "{$displayQty} {$satuan}",
                    'harga'    => number_format($hargaSatuan, 0, ',', '.'),
                    'subtotal' => number_format($subtotal, 0, ',', '.')
                ];

                // Pengurangan stok barang isi
                $isTimbang = in_array($satuan, ['kg', 'liter', 'gram', 'ml']);
                $stokSisa = max(0, $angkaStok - $item['qty']);
                $stokAkhir = $isTimbang ? round($stokSisa, 2) : round($stokSisa);

                // Tambahkan stok wadah kosong jika pelanggan melakukan tukar
                if ($produk->is_tukar_wadah && $isTukar) {
                    $produk->stok_kosong = ($produk->stok_kosong ?? 0) + intval($item['qty']);
                }

                // Cek batas peringatan stok isi
                preg_match('/^(\d+(?:\.\d+)?)/', (string)($produk->stok_awal ?? $produk->stok_barang), $mAwal);
                $stokAwal = isset($mAwal[1]) ? floatval($mAwal[1]) : $angkaStok;
                $batasSeperempat = $stokAwal > 0 ? ($stokAwal * 0.25) : 5;

                if ($angkaStok > 0 && $stokAkhir <= 0) {
                    $barangHabis[] = "{$produk->nama_barang} (Sisa: 0 {$satuan})";
                } elseif ($angkaStok > $batasSeperempat && $stokAkhir <= $batasSeperempat && $stokAkhir > 0) {
                    $barangMenipis[] = "{$produk->nama_barang} (Sisa: {$stokAkhir} {$satuan} / Awal: {$stokAwal} {$satuan})";
                }

                $produk->stok_barang = !empty($satuan) ? $stokAkhir . ' ' . $satuan : (string)$stokAkhir;
                $produk->save();
            }

            DB::commit();

            // 5. Kirim Struk WhatsApp ke Pelanggan
            if ($request->filled('no_wa_pelanggan')) {
                $namaPelanggan = $request->nama_pelanggan ?: 'Pelanggan Setia';
                $metodeTeks = strtoupper(str_replace('_', ' ', $metode));
                $waktuTrx = date('d/m/Y H:i') . ' WIB';

                $pesanStruk = "*🧾 STRUK PEMBELIAN - WAROENG 86*\n";
                $pesanStruk .= "Terima kasih telah berbelanja di Waroeng 86!\n";
                $pesanStruk .= "--------------------------------------------------\n";
                $pesanStruk .= "No. Trx    : {$transaksi->kode_transaksi}\n";
                $pesanStruk .= "Waktu      : {$waktuTrx}\n";
                $pesanStruk .= "Pelanggan  : {$namaPelanggan}\n";
                $pesanStruk .= "Pembayaran : {$metodeTeks}\n";
                $pesanStruk .= "--------------------------------------------------\n";
                $pesanStruk .= "*RINCIAN BELANJA:*\n";

                foreach ($rincianItemStruk as $rincian) {
                    $pesanStruk .= "• {$rincian['nama']} ({$rincian['qty']})\n";
                    $pesanStruk .= "   Rp {$rincian['harga']} = *Rp {$rincian['subtotal']}*\n";
                }

                $pesanStruk .= "--------------------------------------------------\n";
                $pesanStruk .= "*TOTAL TAGIHAN : Rp " . number_format($totalHarga, 0, ',', '.') . "*\n";

                if ($metode === 'tunai') {
                    $pesanStruk .= "Tunai Diterima : Rp " . number_format($bayar, 0, ',', '.') . "\n";
                    $pesanStruk .= "Kembalian      : Rp " . number_format($kembalian, 0, ',', '.') . "\n";
                } else {
                    $pesanStruk .= "Status Bayar   : LUNAS ({$metodeTeks})\n";
                }

                $pesanStruk .= "--------------------------------------------------\n";
                $pesanStruk .= "_Simpan pesan ini sebagai bukti sah pembayaran._\n";
                $pesanStruk .= "_Semoga harimu menyenangkan & kami tunggu kunjungan berikutnya!_";

                WhatsappService::kirimPesan(trim($request->no_wa_pelanggan), $pesanStruk);
            }

            // 6. Kirim Peringatan Stok ke Owner
            if (env('OWNER_WA_NUMBER') && (!empty($barangHabis) || !empty($barangMenipis))) {
                $pesanWA = "*MONITORING STOK - WAROENG 86*\n";
                $pesanWA .= "Waktu: " . date('d/m/Y H:i') . " WIB\n";

                if (!empty($barangHabis)) {
                    $pesanWA .= "\n🚨 *STOK HABIS (KOSONG):*\n";
                    foreach ($barangHabis as $itemHabis) {
                        $pesanWA .= "- " . $itemHabis . "\n";
                    }
                }

                if (!empty($barangMenipis)) {
                    $pesanWA .= "\n⚠️ *STOK MENIPIS (TERSISA <= 1/4):*\n";
                    foreach ($barangMenipis as $itemMenipis) {
                        $pesanWA .= "- " . $itemMenipis . "\n";
                    }
                }

                $pesanWA .= "\nMohon segera persiapkan pengadaan / restock barang.";

                WhatsappService::kirimPesan(env('OWNER_WA_NUMBER'), $pesanWA);
            }

            $pesanSukses = "Transaksi berhasil! [Metode: " . strtoupper(str_replace('_', ' ', $metode)) . "] Total: Rp " . number_format($totalHarga, 0, ',', '.');
            if ($metode === 'tunai' && $kembalian > 0) {
                $pesanSukses .= " | Kembalian: Rp " . number_format($kembalian, 0, ',', '.');
            }

            return redirect()->route('admin.kasir')->with('success', $pesanSukses);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses transaksi: ' . $e->getMessage());
        }
    }
}
