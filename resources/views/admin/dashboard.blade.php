@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="page-header mb-4">
        <h2 class="fw-bold" style="color: #550000;">Dashboard</h2>
    </div>

    {{-- STATISTIK CARDS --}}
    <div class="row g-3">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="background: linear-gradient(135deg, #550000 0%, #3d0000 100%);">
                <div class="stat-icon">
                    <i class="bi bi-box-seam"></i>
                </div>
                <div class="stat-info">
                    <h3 class="stat-number">{{ $totalProduk }}</h3>
                    <p class="stat-label">Total Produk</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="background: linear-gradient(135deg, #0081C9 0%, #0056A3 100%);">
                <div class="stat-icon">
                    <i class="bi bi-cart-check-fill"></i>
                </div>
                <div class="stat-info">
                    <h3 class="stat-number">{{ $totalProdukTerjual }}</h3>
                    <p class="stat-label">Produk Terjual</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);">
                <div class="stat-icon">
                    <i class="bi bi-receipt"></i>
                </div>
                <div class="stat-info">
                    <h3 class="stat-number">{{ $totalTransaksi }}</h3>
                    <p class="stat-label">Total Transaksi</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);">
                <div class="stat-icon">
                    <i class="bi bi-cash-coin"></i>
                </div>
                <div class="stat-info">
                    <h3 class="stat-number"> {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                    <p class="stat-label">Total Pendapatan</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .page-header {
        padding: 1.5rem 0;
    }

    .stat-card {
        padding: 1.25rem 1.5rem;
        border-radius: 16px;
        color: white;
        display: flex;
        align-items: center;
        gap: 1rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        min-height: 120px;
        height: 100%;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .stat-icon {
        width: 64px;
        height: 64px;
        min-width: 64px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        flex-shrink: 0;
    }

    .stat-info {
        flex: 1;
        min-width: 0;
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .stat-number {
        font-size: clamp(1.5rem, 2.5vw, 2rem);
        font-weight: 700;
        margin: 0;
        line-height: 1.2;
        word-break: break-word;
        overflow-wrap: break-word;
    }

    .stat-label {
        margin: 0;
        font-size: 0.875rem;
        opacity: 0.95;
        font-weight: 500;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Responsive adjustments */
    @media (max-width: 1399.98px) {
        .stat-card {
            min-height: 110px;
        }
        
        .stat-icon {
            width: 56px;
            height: 56px;
            min-width: 56px;
            font-size: 1.5rem;
        }
    }

    @media (max-width: 1199.98px) {
        .page-header {
            padding: 1rem 0;
        }

        .container {
            padding-left: 1rem;
            padding-right: 1rem;
        }
    }

    @media (max-width: 991.98px) {
        .stat-card {
            min-height: 100px;
        }

        .stat-number {
            font-size: clamp(1.25rem, 3vw, 1.75rem);
        }
    }

    @media (max-width: 767.98px) {
        .container {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }

        .stat-card {
            min-height: 95px;
            padding: 1rem 1.25rem;
            gap: 0.85rem;
        }
        
        .stat-number {
            font-size: clamp(1.25rem, 4vw, 1.75rem);
        }
        
        .stat-label {
            font-size: 0.8rem;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            min-width: 50px;
            font-size: 1.3rem;
            border-radius: 12px;
        }

        .page-header {
            padding: 0.75rem 0;
        }

        .page-header h2 {
            font-size: 1.5rem;
        }

        .row.g-3 {
            gap: 0.75rem !important;
        }
    }

    @media (max-width: 575.98px) {
        .container {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }

        .page-header {
            padding: 0.5rem 0;
            margin-bottom: 0.75rem !important;
        }

        .page-header h2 {
            font-size: 1.25rem;
        }

        .stat-card {
            padding: 0.85rem 1rem;
            min-height: 90px;
            gap: 0.75rem;
            border-radius: 12px;
        }

        .stat-icon {
            width: 45px;
            height: 45px;
            min-width: 45px;
            font-size: 1.15rem;
            border-radius: 10px;
        }

        .stat-number {
            font-size: clamp(1rem, 5vw, 1.4rem);
        }

        .stat-label {
            font-size: 0.7rem;
        }

        .row.g-3 {
            gap: 0.65rem !important;
        }
    }

    /* Extra small devices (â‰¤400px) */
    @media (max-width: 400px) {
        .page-header h2 {
            font-size: 1.15rem;
        }

        .stat-card {
            padding: 0.75rem 0.85rem;
            min-height: 85px;
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            min-width: 40px;
            font-size: 1rem;
        }

        .stat-number {
            font-size: clamp(0.95rem, 5vw, 1.25rem);
        }

        .stat-label {
            font-size: 0.65rem;
        }
    }
</style>

@endsection

