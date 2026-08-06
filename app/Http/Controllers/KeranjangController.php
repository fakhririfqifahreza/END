<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Transaksi;

class KeranjangController extends Controller
{
    // Tampilkan isi keranjang
    public function index()
    {
        $keranjang = session()->get('keranjang', []);
        $total = 0;

        foreach ($keranjang as $item) {
            $total += $item['harga_barang'] * $item['jumlah'];
        }

        return view('keranjang.index', compact('keranjang', 'total'));
    }

    // Tambahkan barang ke keranjang
    public function tambah($id)
    {
        $barang = Barang::findOrFail($id);
        
        // Ambil nilai stok dan ekstrak angka
        $stokString = trim($barang->stok_barang);
        preg_match('/^(\d+(?:\.\d+)?)/', $stokString, $matches);
        $stokAngka = isset($matches[1]) ? floatval($matches[1]) : 0;
        
        // Cek apakah stok habis
        if ($stokAngka <= 0) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Maaf, stok produk "' . $barang->nama_barang . '" sudah habis!'
                ], 400);
            }
            return redirect()->back()->with('error', 'Maaf, stok produk "' . $barang->nama_barang . '" sudah habis!');
        }
        
        $keranjang = session()->get('keranjang', []);

        // Cek apakah barang sudah ada di keranjang
        if (isset($keranjang[$id])) {
            // Jika sudah ada, tambah jumlahnya dan redirect ke keranjang
            $keranjang[$id]['jumlah'] += 1;
            session()->put('keranjang', $keranjang);
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'redirect' => true,
                    'message' => 'Produk berhasil ditambahkan ke keranjang!',
                    'url' => route('keranjang.index'),
                    'cart_count' => count($keranjang)
                ]);
            }
            
            return redirect()->route('keranjang.index')
                ->with('success', 'Produk berhasil ditambahkan ke keranjang!');
        }

        // Jika belum ada, tambahkan barang baru dengan jumlah 1
        $keranjang[$id] = [
            'nama_barang' => $barang->nama_barang,
            'harga_barang' => $barang->harga_barang,
            'jumlah' => 1
        ];

        session()->put('keranjang', $keranjang);
        
        // Return JSON response untuk AJAX dengan redirect
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'redirect' => true,
                'message' => 'Produk berhasil ditambahkan ke keranjang!',
                'url' => route('keranjang.index'),
                'cart_count' => count($keranjang)
            ]);
        }
        
        // Redirect langsung ke halaman keranjang
        return redirect()->route('keranjang.index')
            ->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    // Hapus barang dari keranjang
    public function hapus($id)
    {
        $keranjang = session()->get('keranjang', []);
        if (isset($keranjang[$id])) {
            unset($keranjang[$id]);
            session()->put('keranjang', $keranjang);
        }
        return redirect()->back()->with('success', 'Produk dihapus dari keranjang!');
    }

    // Update quantity barang di keranjang
    public function updateQuantity(Request $request, $id)
    {
        $keranjang = session()->get('keranjang', []);
        
        if (!isset($keranjang[$id])) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan di keranjang'
            ], 404);
        }
        
        // Ambil data barang dari database untuk cek stok
        $barang = Barang::find($id);
        if (!$barang) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan'
            ], 404);
        }
        
        // Ekstrak angka dari stok
        $stokString = trim($barang->stok_barang);
        preg_match('/^(\d+(?:\.\d+)?)/', $stokString, $matches);
        $stokTersedia = isset($matches[1]) ? floatval($matches[1]) : 0;
        
        // Update jumlah berdasarkan perubahan (+1 atau -1)
        $change = $request->input('change', 0);
        $jumlahBaru = $keranjang[$id]['jumlah'] + $change;
        
        // Validasi: Pastikan jumlah tidak kurang dari 1
        if ($jumlahBaru < 1) {
            return response()->json([
                'success' => false,
                'message' => 'Jumlah minimal adalah 1'
            ], 400);
        }
        
        // Validasi: Cek apakah jumlah baru melebihi stok
        if ($jumlahBaru > $stokTersedia) {
            return response()->json([
                'success' => false,
                'message' => 'Stok tidak mencukupi! Stok tersedia: ' . $stokString,
                'max_stock' => $stokTersedia,
                'current_quantity' => $keranjang[$id]['jumlah']
            ], 400);
        }
        
        // Update jumlah
        $keranjang[$id]['jumlah'] = $jumlahBaru;
        
        // Update session
        session()->put('keranjang', $keranjang);
        
        // Hitung subtotal dan total
        $subtotal = $keranjang[$id]['harga_barang'] * $keranjang[$id]['jumlah'];
        $total = 0;
        foreach ($keranjang as $item) {
            $total += $item['harga_barang'] * $item['jumlah'];
        }
        
        return response()->json([
            'success' => true,
            'quantity' => $keranjang[$id]['jumlah'],
            'subtotal' => $subtotal,
            'total' => $total,
            'cart_count' => count($keranjang),
            'message' => 'Jumlah produk berhasil diupdate'
        ]);
    }

    public function hapusSemua()
    {
        session()->forget('keranjang');

        return redirect()->route('keranjang.index')
            ->with('success', 'Semua produk berhasil dihapus dari keranjang!');
    }

    // Proses checkout
    public function checkout(Request $request)
    {
        $keranjang = session()->get('keranjang', []);
        
        if (empty($keranjang)) {
            return redirect()->route('keranjang.index')
                ->with('error', 'Keranjang masih kosong!');
        }

        // Validasi metode pembayaran
        $request->validate([
            'metode_pembayaran' => 'required|string'
        ]);

        $metodePembayaran = $request->input('metode_pembayaran');

        // Hitung total
        $total_harga = 0;
        foreach ($keranjang as $item) {
            $total_harga += $item['harga_barang'] * $item['jumlah'];
        }

        // Simpan transaksi ke database dengan status PENDING untuk semua metode pembayaran
        $transaksi = Transaksi::create([
            'user_id' => auth()->check() ? auth()->id() : null,
            'total_harga' => $total_harga,
            'metode_pembayaran' => $metodePembayaran,
            'items' => json_encode($keranjang),
            'status' => 'pending', // SEMUA metode pembayaran statusnya PENDING dulu
        ]);

        // Kurangi stok barang setelah transaksi dibuat
        foreach ($keranjang as $id => $item) {
            $barang = Barang::find($id);
            if ($barang) {
                // Ambil nilai stok saat ini
                $stokLama = trim($barang->stok_barang);
                
                // Ekstrak angka dari stok - ambil semua digit di awal string
                preg_match('/^(\d+(?:\.\d+)?)/', $stokLama, $matches);
                $angkaStok = isset($matches[1]) ? floatval($matches[1]) : 0;
                
                // Kurangi stok dengan jumlah yang dibeli
                $stokBaru = $angkaStok - $item['jumlah'];
                
                // Jika stok baru negatif atau sama dengan 0, set ke 0
                if ($stokBaru <= 0) {
                    $barang->stok_barang = '0';
                } else {
                    // Ambil satuan dari stok lama (jika ada)
                    $satuan = '';
                    if (preg_match('/^\d+(?:\.\d+)?\s*(.*)$/', $stokLama, $matchesSatuan)) {
                        $satuanRaw = trim($matchesSatuan[1]);
                        if (!empty($satuanRaw)) {
                            $satuan = ' ' . $satuanRaw;
                        }
                    }
                    
                    // Format stok baru: hilangkan .0 jika bilangan bulat
                    $stokFormatted = (fmod($stokBaru, 1) == 0) ? intval($stokBaru) : $stokBaru;
                    $barang->stok_barang = $stokFormatted . $satuan;
                }
                
                $barang->save();
            }
        }

        // Kosongkan keranjang
        session()->forget('keranjang');

        // Redirect dengan pesan sukses
        $message = 'Pesanan berhasil dibuat!';
            
        return redirect()->route('keranjang.index')
            ->with('success', $message);
    }
}
