@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="page-header mb-4">
        <h2 class="fw-bold" style="color: #550000;">Mengelola Pelanggan</h2>
    </div>

    {{-- TABLE PELANGGAN --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background: #f8f9fa;">
                        <tr>
                            <th class="px-4 py-3">No</th>
                            <th class="py-3">Nama</th>
                            <th class="py-3">Email</th>
                            <th class="py-3">Bergabung Sejak</th>
                            <th class="py-3 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pelanggan as $index => $user)
                            <tr>
                                <td class="px-4 py-3">{{ $index + 1 }}</td>
                                <td class="py-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar-circle">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                                        <span class="fw-semibold">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="py-3">{{ $user->email }}</td>
                                <td class="py-3">{{ \Carbon\Carbon::parse($user->created_at)->format('d M Y') }}</td>
                                <td class="py-3 text-center">
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle me-1"></i>Aktif
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <i class="bi bi-people" style="font-size: 3rem; color: #d1d5db;"></i>
                                    <p class="text-muted mt-2">Belum ada pelanggan terdaftar</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .avatar-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #550000 0%, #3d0000 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.1rem;
    }

    .page-header {
        padding: 1.5rem 0;
    }

    .table th {
        font-weight: 600;
        color: #4b5563;
        border-bottom: 2px solid #e9ecef;
    }

    .table td {
        vertical-align: middle;
    }

    .table tbody tr:hover {
        background: #f8f9fa;
    }

    body.dark-mode .card {
        background: #16213e;
    }

    body.dark-mode .table {
        color: #e5e7eb;
    }

    body.dark-mode .table thead {
        background: #1a1a2e !important;
    }

    body.dark-mode .table tbody tr:hover {
        background: #1a1a2e;
    }

    /* MOBILE RESPONSIVE TABLE */
    @media (max-width: 768px) {
        .page-header {
            padding: 1rem 0;
            margin-bottom: 1rem !important;
        }

        .page-header h2 {
            font-size: 1.3rem;
        }

        /* Hide kolom No dan Bergabung Sejak di mobile */
        .table th:first-child,
        .table td:first-child,
        .table th:nth-child(4),
        .table td:nth-child(4) {
            display: none;
        }

        .table th,
        .table td {
            padding: 0.75rem 0.5rem !important;
            font-size: 0.85rem;
        }

        /* Avatar lebih kecil di mobile */
        .avatar-circle {
            width: 35px;
            height: 35px;
            font-size: 0.95rem;
        }

        /* Nama pelanggan lebih kecil */
        .table td .fw-semibold {
            font-size: 0.8rem !important;
        }

        /* Email lebih kecil */
        .table td:nth-child(3) {
            font-size: 0.75rem !important;
        }

        /* Badge status lebih kecil */
        .table .badge {
            font-size: 0.7rem !important;
            padding: 0.25rem 0.4rem !important;
        }

        .table .badge i {
            font-size: 0.65rem;
        }

        /* Header tabel */
        .table thead th {
            font-size: 0.75rem !important;
            padding: 0.65rem 0.5rem !important;
        }
    }

    @media (max-width: 576px) {
        .page-header h2 {
            font-size: 1.15rem;
        }

        /* Avatar lebih kecil lagi */
        .avatar-circle {
            width: 32px;
            height: 32px;
            font-size: 0.85rem;
        }

        /* Nama pelanggan */
        .table td .fw-semibold {
            font-size: 0.75rem !important;
        }

        /* Email */
        .table td:nth-child(3) {
            font-size: 0.7rem !important;
            max-width: 150px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Badge status */
        .table .badge {
            font-size: 0.65rem !é‡è¦;
            padding: 0.2rem 0.35rem !é‡è¦;
        }

        .table .badge i {
            font-size: 0.6rem;
            margin-right: 2px !é‡è¦;
        }

        /* Header tabel */
        .table thead th {
            font-size: 0.7rem !é‡è¦;
            padding: 0.6rem 0.4rem !é‡è¦;
        }

        .table th,
        .table td {
            padding: 0.6rem 0.4rem !é‡è¦;
        }

        /* Gap antara avatar dan nama lebih kecil */
        .table td .d-flex.gap-2 {
            gap: 0.5rem !é‡è¦;
        }
    }

    @media (max-width: 400px) {
        .page-header h2 {
            font-size: 1.05rem;
        }

        /* Avatar sangat kecil */
        .avatar-circle {
            width: 28px;
            height: 28px;
            font-size: 0.75rem;
        }

        /* Nama pelanggan */
        .table td .fw-semibold {
            font-size: 0.7rem !é‡è¦;
        }

        /* Email sangat compact */
        .table td:nth-child(3) {
            font-size: 0.65rem !é‡è¦;
            max-width: 120px;
        }

        /* Badge status sangat kecil */
        .table .badge {
            font-size: 0.6rem !é‡è¦;
            padding: 0.15rem 0.3rem !é‡è¦;
        }

        .table .badge i {
            display: none; /* Hide icon di layar sangat kecil */
        }
    }
</style>

@endsection

