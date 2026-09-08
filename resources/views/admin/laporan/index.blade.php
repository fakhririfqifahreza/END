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
{{-- KARTU GRAFIK PENJUALAN --}}
<div class="card shadow-sm border-0 rounded-3 mb-4">
    <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
        <div>
            <h6 class="fw-bold mb-0 text-dark">
                <i class="bi bi-graph-up-arrow me-2 text-danger"></i>Grafik Tren Pendapatan
            </h6>
            <small class="text-muted">Periode: {{ \Carbon\Carbon::parse($startDate)->translatedFormat('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d M Y') }}</small>
        </div>
        <span class="badge bg-danger px-3 py-2">
            Total: Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
        </span>
    </div>
    <div class="card-body">
        @if(count($chartValues) > 0)
            <div style="position: relative; height: 320px; width: 100%;">
                <canvas id="salesChart"></canvas>
            </div>
        @else
            <div class="text-center py-5 text-muted">
                <i class="bi bi-bar-chart fs-1 d-block mb-2"></i>
                Tidak ada data penjualan pada rentang tanggal ini.
            </div>
        @endif
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
{{-- PUSTAKA & SKRIP CHART.JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    (function() {
        // 1. Periksa ketersediaan pustaka Chart.js
        if (typeof Chart === 'undefined') {
            console.error('Pustaka Chart.js gagal dimuat dari CDN. Pastikan koneksi internet aktif.');
            return;
        }

        // 2. Ambil elemen canvas
        const canvas = document.getElementById('salesChart');
        if (!canvas) return;

        const labels = @json($chartLabels ?? []);
        const dataValues = @json($chartValues ?? []);

        // 3. Render Chart secara langsung tanpa menunggu DOMContentLoaded
        const ctx = canvas.getContext('2d');
        new Chart(ctx, {
            type: 'bar', // Tipe batang (bar) agar transaksi 1 hari tetap langsung terlihat jelas
            data: {
                labels: labels,
                datasets: [{
                    label: 'Omzet Harian (Rp)',
                    data: dataValues,
                    backgroundColor: 'rgba(85, 0, 0, 0.75)',
                    borderColor: '#550000',
                    borderWidth: 1.5,
                    borderRadius: 6,
                    barPercentage: 0.45,
                    maxBarThickness: 50
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e1e1e',
                        padding: 10,
                        callbacks: {
                            label: function(context) {
                                return 'Omzet: Rp ' + context.parsed.y.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: '#6c757d', font: { size: 12 } }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f0f0f0' },
                        ticks: {
                            color: '#6c757d',
                            font: { size: 11 },
                            callback: function(value) {
                                if (value >= 1000000) return 'Rp ' + (value / 1000000).toFixed(1) + ' jt';
                                if (value >= 1000) return 'Rp ' + (value / 1000).toFixed(0) + ' rb';
                                return 'Rp ' + value;
                            }
                        }
                    }
                }
            }
        });
    })();
</script>
@endsection
