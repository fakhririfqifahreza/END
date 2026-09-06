<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::with(['transaksiDetail.barang', 'user'])
            ->orderBy('created_at', 'desc');

        // 1. Filter Pencarian Teks (Kode Trx / Nama Pelanggan)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_transaksi', 'like', "%{$search}%")
                  ->orWhere('nama_pelanggan', 'like', "%{$search}%");
            });
        }

        // 2. Filter Rentang Tanggal
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // withQueryString() menjaga filter tetap aktif saat berpindah halaman paginasi
        $transaksis = $query->paginate(15)->withQueryString();

        return view('admin.transaksi.index', compact('transaksis'));
    }
}
