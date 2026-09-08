<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Exports\LaporanExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->toDateString());

        $query = Transaksi::with('transaksiDetail.barang')
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->where('status', 'selesai')
            ->orderBy('created_at', 'desc');

        $transaksis = $query->get();

        $totalPendapatan = $transaksis->sum('total_harga');

        $totalBarangTerjual = 0;
        foreach ($transaksis as $trx) {
            if ($trx->transaksiDetail) {
                $totalBarangTerjual += $trx->transaksiDetail->sum('qty');
            }
        }

        // -------------------------------------------------------------
        // DATA UNTUK DIAGRAM / GRAFIK PENJUALAN HARIAN
        // -------------------------------------------------------------
        $chartData = Transaksi::where('status', 'selesai')
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->selectRaw('DATE(created_at) as tanggal, SUM(total_harga) as total')
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->pluck('total', 'tanggal');

        $chartLabels = [];
        $chartValues = [];

        foreach ($chartData as $tanggal => $total) {
            $chartLabels[] = Carbon::parse($tanggal)->translatedFormat('d M');
            $chartValues[] = (int) $total;
        }

        return view('admin.laporan.index', compact(
            'transaksis',
            'startDate',
            'endDate',
            'totalPendapatan',
            'totalBarangTerjual',
            'chartLabels',
            'chartValues'
        ));
    }

    public function exportExcel(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->toDateString());

        $transaksis = Transaksi::with('transaksiDetail.barang')
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->where('status', 'selesai')
            ->orderBy('created_at', 'asc')
            ->get();

        $totalPendapatan = $transaksis->sum('total_harga');

        $totalBarangTerjual = 0;
        foreach ($transaksis as $trx) {
            if ($trx->transaksiDetail) {
                $totalBarangTerjual += $trx->transaksiDetail->sum('qty');
            }
        }

        $fileName = 'Laporan_Keuangan_Waroeng_86_' . date('d_M_Y', strtotime($startDate)) . '_sd_' . date('d_M_Y', strtotime($endDate)) . '.xlsx';

        return Excel::download(new LaporanExport($transaksis, $startDate, $endDate, $totalPendapatan, $totalBarangTerjual), $fileName);
    }
}
