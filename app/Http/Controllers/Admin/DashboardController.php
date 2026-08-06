<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung statistik
        $totalProduk = Barang::count();
        
        // Hitung total produk terjual dari transaksi yang sudah selesai
        $totalProdukTerjual = DB::table('transaksi')
            ->where('status', 'selesai')
            ->get()
            ->sum(function($transaksi) {
                $items = json_decode($transaksi->items, true);
                $totalJumlah = 0;
                foreach ($items as $item) {
                    $totalJumlah += $item['jumlah'];
                }
                return $totalJumlah;
            });
        
        $totalTransaksi = DB::table('transaksi')->count() ?? 0;
        $totalPendapatan = DB::table('transaksi')->where('status', 'selesai')->sum('total_harga') ?? 0;

        // Statistik Pelanggan Detail
        $pelangganBaru = User::where('role', 'pelanggan')
            ->where('created_at', '>=', now()->subDays(30))
            ->count();
        
        $pelangganAktif = User::where('role', 'pelanggan')
            ->whereHas('transaksi', function($query) {
                $query->where('created_at', '>=', now()->subDays(30));
            })
            ->count();

        // Statistik Transaksi Detail
        $transaksiPending = DB::table('transaksi')->where('status', 'pending')->count() ?? 0;
        $transaksiSelesai = DB::table('transaksi')->where('status', 'selesai')->count() ?? 0;

        // Transaksi Terbaru (5 transaksi terakhir)
        $transaksiTerbaru = Transaksi::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Produk Terlaris (5 produk dengan penjualan tertinggi)
        $produkTerlaris = DB::table('transaksi')
            ->where('status', 'selesai')
            ->get()
            ->flatMap(function($transaksi) {
                $items = json_decode($transaksi->items, true);
                return collect($items)->map(function($item) {
                    return [
                        'id_barang' => $item['id_barang'] ?? null,
                        'nama_barang' => $item['nama_barang'] ?? 'Unknown',
                        'jumlah' => $item['jumlah'] ?? 0
                    ];
                });
            })
            ->groupBy('id_barang')
            ->map(function($group) {
                return [
                    'id_barang' => $group->first()['id_barang'],
                    'nama_barang' => $group->first()['nama_barang'],
                    'total_terjual' => $group->sum('jumlah')
                ];
            })
            ->sortByDesc('total_terjual')
            ->take(5)
            ->values();

        return view('admin.dashboard', compact(
            'totalProduk',
            'totalProdukTerjual',
            'totalTransaksi',
            'totalPendapatan',
            'pelangganBaru',
            'pelangganAktif',
            'transaksiPending',
            'transaksiSelesai',
            'transaksiTerbaru',
            'produkTerlaris'
        ));
    }
}
