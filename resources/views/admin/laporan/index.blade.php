@extends('layouts.admin')

@section('content')
<div class="container-fluid px-3 px-md-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold" style="color: #550000; margin: 0;">
            <i class="bi bi-file-earmark-bar-graph me-2"></i>Laporan Penjualan & Keuangan
        </h3>
    </div>

    {{-- FILTER PERIODE & TOMBOL DOWNLOAD --}}
    <div class="card shadow-sm border-0 rounded-3 mb-4">
        <div class="card-body p-3">
            <form action="{{ route('admin.laporan') }}" method="GET" class="row g-2 align-items-end">
                <div class="col-md-3 col-sm-6">
                    <label class="form-label small fw-semibold">Tanggal Mulai</label>
                    <input type="date" name="start_date" class="form-control form-control-sm" value="{{ $startDate }}" required>
                </div>
                <div class="col-md-3 col-sm-6">
                    <label class="form-label small fw-semibold">Tanggal Akhir</label>
                    <input type="date" name="end_date" class="form-control form-control-sm" value="{{ $endDate }}" required>
                </div>

                <div class="col-md-3 col-sm-6">
                    <button type="submit" class="btn btn-sm text-white w-100 fw-semibold" style="background-color: #550000;">
                        <i class="bi bi-filter me-1"></i> Filter Data
                    </button>
                </div>
                <div class="col-md-3 col-sm-6">
                    <a href="{{ route('admin.laporan.export', ['start_date' => $startDate, 'end_date' => $endDate]) }}" class="btn btn-sm btn-success w-100 fw-semibold">
                        <i class="bi bi-file-earmark-excel me-1"></i> Download Excel (.xlsx)
                    </a>
                </div>
            </form>
        </div>
    </div>
    {{-- KARTU RINGKASAN METODE PEMBAYARAN (Letakkan di bawah filter tanggal) --}}
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="p-3 bg-white shadow-sm rounded-3 border-start border-4 border-success">
            <small class="text-muted d-block fw-semibold">Pembayaran Tunai</small>
            <h5 class="fw-bold mb-0 text-success">
                Rp {{ number_format($transaksis->where('metode_pembayaran', 'tunai')->sum('total_harga'), 0, ',', '.') }}
            </h5>
            <small class="text-muted">{{ $transaksis->where('metode_pembayaran', 'tunai')->count() }} Transaksi</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="p-3 bg-white shadow-sm rounded-3 border-start border-4 border-primary">
            <small class="text-muted d-block fw-semibold">Pembayaran QRIS</small>
            <h5 class="fw-bold mb-0 text-primary">
                Rp {{ number_format($transaksis->where('metode_pembayaran', 'qris')->sum('total_harga'), 0, ',', '.') }}
            </h5>
            <small class="text-muted">{{ $transaksis->where('metode_pembayaran', 'qris')->count() }} Transaksi</small>
        </div>
    </div>
    {{-- METODE PEMBAYARAN --}}
    <div class="col-md-3">
        <div class="p-3 bg-white shadow-sm rounded-3 border-start border-4 border-info">
            <small class="text-muted d-block fw-semibold">Transfer Bank</small>
            <h5 class="fw-bold mb-0 text-info">
                Rp {{ number_format($transaksis->where('metode_pembayaran', 'transfer_bank')->sum('total_harga'), 0, ',', '.') }}
            </h5>
            <small class="text-muted">{{ $transaksis->where('metode_pembayaran', 'transfer_bank')->count() }} Transaksi</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="p-3 bg-white shadow-sm rounded-3 border-start border-4 border-danger">
            <small class="text-muted d-block fw-semibold">Total Seluruh Omzet</small>
            <h5 class="fw-bold mb-0 text-danger">
                Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
            </h5>
            <small class="text-muted">{{ $transaksis->count() }} Transaksi</small>
        </div>
    </div>
</div>
    {{-- KARTU RINGKASAN --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="p-3 bg-white shadow-sm rounded-3 border-start border-4 border-primary">
                <small class="text-muted d-block fw-semibold">Total Transaksi</small>
                <h4 class="fw-bold mb-0 text-primary">{{ $transaksis->count() }}</h4>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-3 bg-white shadow-sm rounded-3 border-start border-4 border-warning">
                <small class="text-muted d-block fw-semibold">Total Item Terjual</small>
                <h4 class="fw-bold mb-0 text-warning">{{ $totalBarangTerjual }} Item</h4>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-3 bg-white shadow-sm rounded-3 border-start border-4 border-success">
                <small class="text-muted d-block fw-semibold">Total Pemasukan</small>
                <h4 class="fw-bold mb-0 text-success">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h4>
            </div>
        </div>
    </div>

    {{-- TABEL PRATINJAU DATA --}}
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr class="small text-muted">
                            <th class="ps-3">Kode Trx</th>
                            <th>Tanggal</th>
                            <th>Pelanggan</th>
                            <th>Barang Dibeli</th>
                            <th class="text-end pe-3">Total Belanja</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksis as $trx)
                            <tr>
                                <td class="ps-3 fw-bold small text-primary">{{ $trx->kode_transaksi }}</td>
                                <td class="small">{{ date('d M Y H:i', strtotime($trx->created_at)) }}</td>
                                <td class="small">{{ $trx->nama_pelanggan ?? 'Pembeli Langsung' }}</td>
                                <td class="small">
                                    @if($trx->transaksiDetail && $trx->transaksiDetail->count() > 0)
                                        <ul class="list-unstyled mb-0">
                                            @foreach($trx->transaksiDetail as $det)
                                                <li>- {{ $det->barang->nama_barang ?? $det->nama_barang ?? 'Barang' }} ({{ $det->qty }}x)</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <span class="text-muted">Item kasir</span>
                                    @endif
                                </td>
                                <td class="text-end pe-3 fw-bold text-danger">Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">Tidak ada transaksi pada rentang tanggal ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
