@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="page-header mb-4">
        <h2 class="fw-bold" style="color: #03AC0E;">Mengelola Transaksi</h2>
    </div>

    {{-- TABLE TRANSAKSI --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background: #f8f9fa;">
                        <tr>
                            <th class="px-4 py-3">No</th>
                            <th class="py-3">Nama Pelanggan</th>
                            <th class="py-3">Tanggal</th>
                            <th class="py-3">Metode</th>
                            <th class="py-3 text-center">Status</th>
                            <th class="py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksi as $index => $item)
                            <tr class="transaksi-row" data-nama="{{ $item->user ? strtolower($item->user->name) : 'guest' }}">
                                <td class="px-4 py-3">{{ $index + 1 }}</td>
                                <td class="py-3">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-person-circle me-2" style="font-size: 1.5rem; color: #6b7280;"></i>
                                        <span class="fw-semibold">{{ $item->user ? $item->user->name : 'Guest' }}</span>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <div class="text-nowrap">{{ $item->created_at->format('d M Y') }}</div>
                                    <small class="text-muted">{{ $item->created_at->format('H:i') }}</small>
                                </td>
                                <td class="py-3">
                                    @if($item->metode_pembayaran == 'DANA')
                                        <span class="badge bg-success">
                                            <i class="bi bi-wallet2 me-1"></i>DANA
                                        </span>
                                    @elseif($item->metode_pembayaran == 'QRIS')
                                        <span class="badge bg-success">
                                            <i class="bi bi-qr-code me-1"></i>QRIS
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            <i class="bi bi-cash me-1"></i>Tunai
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 text-center">
                                    @if($item->status == 'selesai')
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle me-1"></i>Selesai
                                        </span>
                                    @elseif($item->status == 'pending')
                                        <span class="badge bg-warning text-dark">
                                            <i class="bi bi-clock me-1"></i>Pending
                                        </span>
                                    @else
                                        <span class="badge bg-danger">
                                            <i class="bi bi-x-circle me-1"></i>Batal
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 text-center">
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#detailModal{{ $item->id }}" title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        @if($item->status == 'pending')
                                            <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#statusModal{{ $item->id }}" title="Update Status">
                                                <i class="bi bi-check-circle"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr id="emptyRow">
                                <td colspan="6" class="text-center py-5">
                                    <div style="padding: 3rem 1rem;">
                                        <i class="bi bi-receipt" style="font-size: 4rem; color: #d1d5db;"></i>
                                        <p class="text-muted mt-3 mb-0">Belum ada transaksi</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        <tr id="noResultRow" style="display: none;">
                            <td colspan="6" class="text-center py-5">
                                <div style="padding: 3rem 1rem;">
                                    <i class="bi bi-search" style="font-size: 4rem; color: #d1d5db;"></i>
                                    <h5 class="mt-3 mb-2 fw-semibold" style="color: #6b7280;">Pelanggan tidak ditemukan</h5>
                                    <p class="text-muted mb-0" style="font-size: 0.9rem;">Coba kata kunci lain</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- MODALS - OUTSIDE TABLE --}}
    @foreach($transaksi as $item)
        {{-- MODAL DETAIL --}}
        <div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header" style="background: linear-gradient(135deg, #03AC0E 0%, #028A0F 100%);">
                        <h5 class="modal-title text-white">
                            <i class="bi bi-receipt me-2"></i>Detail Transaksi
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        {{-- INFO PELANGGAN --}}
                        <div class="detail-card mb-3">
                            <div class="detail-card-header">
                                <i class="bi bi-person-circle me-2"></i>
                                <span>Informasi Pelanggan</span>
                            </div>
                            <div class="detail-card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="info-item">
                                            <label>Nama Pelanggan</label>
                                            <p>{{ $item->user ? $item->user->name : 'Guest' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-item">
                                            <label>Email</label>
                                            <p>{{ $item->user ? $item->user->email : '-' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- INFO TRANSAKSI --}}
                        <div class="detail-card mb-3">
                            <div class="detail-card-header">
                                <i class="bi bi-calendar-check me-2"></i>
                                <span>Informasi Transaksi</span>
                            </div>
                            <div class="detail-card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="info-item">
                                            <label>Tanggal Transaksi</label>
                                            <p>{{ $item->created_at->format('d F Y') }}</p>
                                            <small class="text-muted">{{ $item->created_at->format('H:i') }} WIB</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="info-item">
                                            <label>Metode Pembayaran</label>
                                            <p>
                                                @if($item->metode_pembayaran == 'DANA')
                                                    <span class="badge bg-success">
                                                        <i class="bi bi-wallet2 me-1"></i>DANA
                                                    </span>
                                                @elseif($item->metode_pembayaran == 'QRIS')
                                                    <span class="badge bg-success">
                                                        <i class="bi bi-qr-code me-1"></i>QRIS
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">
                                                        <i class="bi bi-cash me-1"></i>Tunai
                                                    </span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="info-item">
                                            <label>Total Item</label>
                                            <p><span class="badge bg-primary">{{ count($item->getItemsArray()) }} item</span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- DETAIL PRODUK --}}
                        <div class="detail-card mb-3">
                            <div class="detail-card-header">
                                <i class="bi bi-box-seam me-2"></i>
                                <span>Detail Produk</span>
                            </div>
                            <div class="detail-card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead style="background: #f8f9fa;">
                                            <tr>
                                                <th class="px-3 py-3">Produk</th>
                                                <th class="py-3 text-center">Jumlah</th>
                                                <th class="py-3 text-end">Harga</th>
                                                <th class="py-3 text-end pe-3">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($item->getItemsArray() as $product)
                                                <tr>
                                                    <td class="px-3">
                                                        <div class="d-flex align-items-center">
                                                            <i class="bi bi-box text-success me-2"></i>
                                                            <span class="fw-medium">{{ $product['nama_barang'] ?? '-' }}</span>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge bg-light text-dark">{{ $product['jumlah'] ?? 0 }}</span>
                                                    </td>
                                                    <td class="text-end">Rp {{ number_format($product['harga_barang'] ?? 0, 0, ',', '.') }}</td>
                                                    <td class="text-end pe-3 fw-bold text-success">Rp {{ number_format(($product['harga_barang'] ?? 0) * ($product['jumlah'] ?? 0), 0, ',', '.') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        {{-- TOTAL HARGA --}}
                        <div class="total-section">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <i class="bi bi-cash-coin me-2" style="font-size: 1.5rem; color: #03AC0E;"></i>
                                    <strong style="font-size: 1.2rem; color: #1f2937;">Total Pembayaran</strong>
                                </div>
                                <div>
                                    <h3 class="mb-0 fw-bold" style="color: #03AC0E;">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL UPDATE STATUS --}}
        <div class="modal fade" id="statusModal{{ $item->id }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0" style="border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0, 0, 0, 0.12);">
                    <div class="modal-header border-0" style="background: white; padding: 1.5rem 2rem;">
                        <h5 class="modal-title fw-bold mb-0" style="color: #1f2937;">
                            <i class="bi bi-pencil-square me-2" style="color: #03AC0E;"></i>Update Status Transaksi
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('admin.transaksi.updateStatus', $item->id) }}" method="POST">
                        @csrf
                        <div class="modal-body" style="padding: 1.5rem 2rem;">
                            <label class="form-label mb-3" style="font-weight: 600; color: #4b5563; font-size: 0.9rem;">
                                Pilih Status Baru
                            </label>
                            
                            <div class="status-radio-group">
                                <label class="status-radio-option">
                                    <input type="radio" name="status" value="pending" {{ $item->status == 'pending' ? 'checked' : '' }} required>
                                    <div class="status-radio-card">
                                        <div class="status-radio-indicator"></div>
                                        <div class="status-radio-content">
                                            <div class="status-radio-info">
                                                <div class="status-dot" style="background: #f59e0b;"></div>
                                                <strong style="color: #1f2937; font-size: 0.95rem;">Pending</strong>
                                            </div>
                                            <small style="color: #6b7280;">Menunggu pembayaran dari pelanggan</small>
                                        </div>
                                    </div>
                                </label>

                                <label class="status-radio-option">
                                    <input type="radio" name="status" value="selesai" {{ $item->status == 'selesai' ? 'checked' : '' }} required>
                                    <div class="status-radio-card">
                                        <div class="status-radio-indicator"></div>
                                        <div class="status-radio-content">
                                            <div class="status-radio-info">
                                                <div class="status-dot" style="background: #10b981;"></div>
                                                <strong style="color: #1f2937; font-size: 0.95rem;">Selesai</strong>
                                            </div>
                                            <small style="color: #6b7280;">Pembayaran telah diterima</small>
                                        </div>
                                    </div>
                                </label>

                                <label class="status-radio-option">
                                    <input type="radio" name="status" value="batal" {{ $item->status == 'batal' ? 'checked' : '' }} required>
                                    <div class="status-radio-card">
                                        <div class="status-radio-indicator"></div>
                                        <div class="status-radio-content">
                                            <div class="status-radio-info">
                                                <div class="status-dot" style="background: #ef4444;"></div>
                                                <strong style="color: #1f2937; font-size: 0.95rem;">Batal</strong>
                                            </div>
                                            <small style="color: #6b7280;">Transaksi dibatalkan</small>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                        <div class="modal-footer border-0" style="padding: 1rem 2rem 1.5rem 2rem; background: #f9fafb;">
                            <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal" style="border: 1px solid #e5e7eb; font-weight: 500;">
                                Batal
                            </button>
                            <button type="submit" class="btn px-4" style="background: #03AC0E; color: white; border: none; font-weight: 500;">
                                <i class="bi bi-check-lg me-1"></i>Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>

<style>
    .btn-group {
        display: flex;
        gap: 0.25rem;
    }

    .stat-box {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        display: flex;
        align-items: center;
        gap: 1.5rem;
        transition: all 0.3s ease;
    }

    .stat-box:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        color: white;
    }

    .stat-box h3 {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
        color: #1f2937;
    }

    .stat-box p {
        margin: 0;
        color: #6b7280;
        font-size: 0.9rem;
    }

    .modal-content {
        border: none;
        border-radius: 12px;
        overflow: hidden;
    }

    .table th {
        font-weight: 600;
        color: #4b5563;
    }

    body.dark-mode .stat-box {
        background: #16213e;
    }

    body.dark-mode .stat-box h3 {
        color: #e5e7eb;
    }

    body.dark-mode .stat-box p {
        color: #9ca3af;
    }

    body.dark-mode .modal-content {
        background: #16213e;
        color: #e5e7eb;
    }

    body.dark-mode .modal-body {
        background: #16213e;
    }

    body.dark-mode .table {
        color: #e5e7eb;
    }

    body.dark-mode .table thead {
        background: #0f1419 !important;
    }

    body.dark-mode .form-select {
        background: #1a1a2e;
        color: #e5e7eb;
        border-color: rgba(3, 172, 14, 0.3);
    }

    .detail-card {
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
        background: white;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .detail-card-header {
        background: #f8f9fa;
        padding: 0.75rem 1rem;
        font-weight: 600;
        color: #4b5563;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .detail-card-body {
        padding: 1rem;
    }

    .info-item label {
        font-size: 0.85rem;
        color: #6b7280;
        margin-bottom: 0.25rem;
        display: block;
    }

    .info-item p {
        margin: 0;
        font-weight: 500;
        color: #1f2937;
    }

    .total-section {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    body.dark-mode .card {
        background: #16213e;
    }

    body.dark-mode .form-control,
    body.dark-mode .form-select {
        background: #1a1a2e;
        color: #e5e7eb;
        border-color: rgba(3, 172, 14, 0.3);
    }

    body.dark-mode .form-control:focus,
    body.dark-mode .form-select:focus {
        background: #1a1a2e;
        border-color: #03AC0E;
        color: #e5e7eb;
    }

    body.dark-mode .form-label {
        color: #e5e7eb;
    }

    body.dark-mode .form-label {
        color: #e5e7eb;
    }

    /* MODAL UPDATE STATUS - NEW DESIGN */
    .status-radio-group {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .status-radio-option {
        cursor: pointer;
        margin: 0;
    }

    .status-radio-option input[type="radio"] {
        display: none;
    }

    .status-radio-card {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.25rem;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        background: white;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }

    .status-radio-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    }

    .status-radio-indicator {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        border: 2px solid #d1d5db;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: all 0.3s ease;
    }

    .status-radio-content {
        flex: 1;
    }

    .status-radio-info {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.25rem;
    }

    .status-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    /* Active/Checked State */
    .status-radio-option input[type="radio"]:checked + .status-radio-card {
        border-color: #03AC0E;
        background: #f0fdf4;
    }

    .status-radio-option input[type="radio"]:checked + .status-radio-card .status-radio-indicator {
        background: #03AC0E;
        border-color: #03AC0E;
    }

    /* Dark Mode untuk Modal Baru */
    body.dark-mode .status-radio-card {
        background: #16213e;
        border-color: rgba(255, 255, 255, 0.1);
    }

    body.dark-mode .status-radio-card:hover {
        background: #1a2332;
    }

    body.dark-mode .status-radio-content strong {
        color: #e5e7eb;
    }

    body.dark-mode .status-radio-content small {
        color: #9ca3af;
    }

    body.dark-mode .status-radio-option input[type="radio"]:checked + .status-radio-card {
        background: rgba(3, 172, 14, 0.1);
        border-color: #03AC0E;
    }

    /* Responsive untuk Modal Baru */
    @media (max-width: 575.98px) {
        .modal-header {
            padding: 1.5rem !important;
        }

        .modal-body {
            padding: 1.25rem !important;
        }

        .status-radio-card {
            padding: 1rem;
            gap: 0.75rem;
        }

        .status-radio-content strong {
            font-size: 0.9rem;
        }

        .status-radio-content small {
            font-size: 0.75rem;
        }

        .status-radio-indicator {
            width: 20px;
            height: 20px;
        }

        .status-dot {
            width: 10px;
            height: 10px;
        }
    }

    /* RESPONSIVE STYLES */
    @media (max-width: 991.98px) {
        .page-header h2 {
            font-size: 1.5rem;
        }

        .page-header p {
            font-size: 0.9rem;
        }

        .table {
            font-size: 0.9rem;
        }

        .btn-group .btn {
            padding: 0.35rem 0.5rem;
            font-size: 0.85rem;
        }
    }

    /* MOBILE RESPONSIVE TABLE - SAMA SEPERTI TABEL PRODUK */
    @media (max-width: 768px) {
        .page-header {
            padding: 1rem 0;
            margin-bottom: 1rem !important;
        }

        .page-header h2 {
            font-size: 1.3rem;
        }

        /* Hide kolom No */
        .table th:first-child,
        .table td:first-child {
            display: none;
        }

        /* Hide kolom Tanggal di mobile */
        .table th:nth-child(3),
        .table td:nth-child(3) {
            display: none;
        }

        .table th,
        .table td {
            padding: 0.75rem 0.5rem !important;
            font-size: 0.85rem;
        }

        /* Nama pelanggan */
        .table td .fw-semibold {
            font-size: 0.8rem !important;
        }

        .table td .bi-person-circle {
            font-size: 1.2rem !important;
        }

        /* Badge lebih kecil */
        .table .badge {
            font-size: 0.7rem !important;
            padding: 0.25rem 0.4rem !important;
        }

        /* Tombol aksi lebih kecil */
        .btn-group .btn {
            padding: 0.35rem 0.5rem !important;
            font-size: 0.75rem !important;
        }

        .btn-group .btn i {
            font-size: 0.85rem;
        }

        /* Header tabel */
        .table thead th {
            font-size: 0.75rem !important;
            padding: 0.65rem 0.5rem !important;
        }
    }

    @media (max-width: 576px) {
        .container {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }

        .page-header {
            padding: 0.75rem 0;
            margin-bottom: 0.75rem !important;
        }

        .page-header h2 {
            font-size: 1.15rem;
        }

        /* Nama pelanggan dengan icon */
        .table td .d-flex {
            gap: 0.5rem !important;
        }

        .table td .bi-person-circle {
            font-size: 1.1rem !important;
        }

        .table td .fw-semibold {
            font-size: 0.75rem !important;
            max-width: 100px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Badge */
        .table .badge {
            font-size: 0.65rem !important;
            padding: 0.2rem 0.35rem !important;
        }

        .table .badge i {
            font-size: 0.65rem !important;
            margin-right: 0.15rem !important;
        }

        /* Tombol aksi */
        .btn-group {
            gap: 0.15rem !important;
        }

        .btn-group .btn {
            padding: 0.3rem 0.45rem !important;
            font-size: 0.7rem !important;
        }

        .btn-group .btn i {
            font-size: 0.8rem;
        }

        /* Header tabel */
        .table thead th {
            font-size: 0.7rem !important;
            padding: 0.6rem 0.4rem !important;
        }

        .table th,
        .table td {
            padding: 0.6rem 0.4rem !important;
        }

        /* Card */
        .card {
            border-radius: 10px !important;
        }
    }

    @media (max-width: 400px) {
        .container {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }

        .page-header h2 {
            font-size: 1.05rem;
        }

        /* Nama pelanggan */
        .table td .bi-person-circle {
            font-size: 1rem !important;
        }

        .table td .fw-semibold {
            font-size: 0.7rem !important;
            max-width: 80px;
        }

        /* Badge sangat kecil */
        .table .badge {
            font-size: 0.6rem !important;
            padding: 0.15rem 0.3rem !important;
        }

        .table .badge i {
            display: none; /* Hide icon di layar sangat kecil */
        }

        /* Tombol aksi stack vertikal */
        .btn-group {
            flex-direction: column;
            gap: 0.25rem !important;
        }

        .btn-group .btn {
            padding: 0.25rem 0.4rem !important;
            font-size: 0.65rem !important;
            width: 100%;
        }

        .btn-group .btn i {
            font-size: 0.75rem;
        }

        /* Header tabel */
        .table thead th {
            font-size: 0.65rem !important;
            padding: 0.5rem 0.3rem !important;
        }

        .table th,
        .table td {
            padding: 0.5rem 0.3rem !important;
        }
    }

    @media (max-width: 767.98px) {
    }
</style>

@endsection
