@extends('layouts.app')

@section('content')
<style>
    /* ===== TOKOPEDIA STYLE CART ===== */
    .cart-wrapper {
        padding: 2rem 0;
        background: #f5f5f5;
        min-height: calc(100vh - 200px);
    }

    .cart-header {
        background: #ffffff;
        padding: 1.5rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .cart-header h2 {
        font-size: 1.8rem;
        font-weight: 700;
        color: #212529;
        margin: 0;
    }

    .cart-item-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }

    .cart-item-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
    }

    .item-row {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .item-checkbox {
        width: 20px;
        height: 20px;
        cursor: pointer;
    }

    .item-name {
        flex: 1;
        font-size: 1rem;
        font-weight: 600;
        color: #212529;
    }

    .item-price {
        min-width: 120px;
        text-align: right;
        font-size: 0.95rem;
        color: #6b7280;
    }

    .item-qty-control {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        min-width: 120px;
        justify-content: center;
    }

    .qty-btn {
        width: 28px;
        height: 28px;
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        background: #ffffff;
        color: #03AC0E;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 1rem;
        font-weight: 600;
    }

    .qty-btn:hover {
        background: #03AC0E;
        color: #ffffff;
        border-color: #03AC0E;
    }

    .qty-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .qty-display {
        min-width: 40px;
        text-align: center;
        font-weight: 600;
        color: #212529;
        font-size: 1rem;
    }

    .item-subtotal {
        min-width: 140px;
        text-align: right;
        font-size: 1.1rem;
        font-weight: 700;
        color: #03AC0E;
    }

    .item-delete {
        min-width: 80px;
        text-align: center;
    }

    .btn-delete-item {
        background: transparent;
        border: 1px solid #ef4444;
        color: #ef4444;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-delete-item:hover {
        background: #ef4444;
        color: #ffffff;
    }

    /* Summary Box - Sticky */
    .cart-summary {
        background: #ffffff;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        position: sticky;
        top: 100px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1rem;
        font-size: 0.95rem;
    }

    .summary-label {
        color: #6b7280;
    }

    .summary-value {
        font-weight: 600;
        color: #212529;
    }

    .summary-total {
        border-top: 2px solid #f3f4f6;
        padding-top: 1rem;
        margin-top: 1rem;
    }

    .summary-total-label {
        font-size: 1.1rem;
        font-weight: 700;
        color: #212529;
    }

    .summary-total-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #03AC0E;
    }

    .btn-checkout {
        width: 100%;
        background: #03AC0E;
        color: #ffffff;
        border: none;
        border-radius: 8px;
        padding: 1rem;
        font-size: 1rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 1.5rem;
    }

    .btn-checkout:hover {
        background: #028A0F;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(3, 172, 14, 0.3);
    }

    .btn-delete-all {
        background: transparent;
        border: 1px solid #ef4444;
        color: #ef4444;
        padding: 0.6rem 1.5rem;
        border-radius: 8px;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-delete-all:hover {
        background: #ef4444;
        color: #ffffff;
    }

    /* Empty Cart */
    .empty-cart {
        background: #ffffff;
        border-radius: 12px;
        padding: 4rem 2rem;
        text-align: center;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .empty-cart i {
        font-size: 4rem;
        color: #d1d5db;
        margin-bottom: 1rem;
    }

    .empty-cart h3 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #212529;
        margin-bottom: 0.5rem;
    }

    .empty-cart p {
        color: #6b7280;
        margin-bottom: 2rem;
    }

    .btn-shop {
        background: #03AC0E;
        color: #ffffff;
        border: none;
        border-radius: 8px;
        padding: 0.8rem 2rem;
        font-size: 1rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
    }

    .btn-shop:hover {
        background: #028A0F;
        color: #ffffff;
        transform: translateY(-2px);
    }

    .qty-loading {
        opacity: 0.5;
        pointer-events: none;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .item-row {
            flex-wrap: wrap;
            gap: 1rem;
        }

        .item-checkbox {
            display: none;
        }

        .item-name {
            flex: 1 1 100%;
            margin-bottom: 0.5rem;
        }

        .item-price,
        .item-qty-control,
        .item-subtotal {
            flex: 1;
            min-width: auto;
            text-align: center;
        }

        .item-delete {
            flex: 1 1 100%;
            margin-top: 0.5rem;
        }

        .btn-delete-item {
            width: 100%;
        }

        .cart-summary {
            position: static;
            margin-top: 1.5rem;
        }

        .cart-header h2 {
            font-size: 1.4rem;
        }
    }

    /* Modal Konfirmasi Hapus - Mobile Responsive */
    @media (max-width: 576px) {
        #modalKonfirmasiHapus .modal-dialog {
            margin: 1rem auto;
            max-width: 90%;
        }

        #modalKonfirmasiHapus .modal-content {
            border-radius: 10px;
        }

        #modalKonfirmasiHapus .modal-header {
            padding: 0.75rem 1rem;
        }

        #modalKonfirmasiHapus .modal-title {
            font-size: 0.9rem;
        }

        #modalKonfirmasiHapus .modal-title i {
            font-size: 1rem;
        }

        #modalKonfirmasiHapus .modal-body {
            padding: 1rem;
        }

        #modalKonfirmasiHapus .modal-body .mb-3 {
            margin-bottom: 0.75rem !important;
        }

        #modalKonfirmasiHapus .modal-body .bi-trash {
            font-size: 2rem !important;
        }

        #modalKonfirmasiHapus .modal-body h5 {
            font-size: 0.95rem;
            margin-bottom: 0.5rem;
        }

        #modalKonfirmasiHapus .modal-body p {
            font-size: 0.75rem;
            line-height: 1.3;
        }

        #modalKonfirmasiHapus .modal-footer {
            padding: 0.75rem;
            gap: 0.5rem;
            display: flex;
            flex-direction: column;
        }

        #modalKonfirmasiHapus .modal-footer .btn {
            width: 100%;
            padding: 0.5rem 0.85rem;
            font-size: 0.8rem;
        }

        #modalKonfirmasiHapus .modal-footer .btn i {
            font-size: 0.85rem;
        }
    }

    /* Extra small devices - lebih kecil lagi */
    @media (max-width: 400px) {
        #modalKonfirmasiHapus .modal-dialog {
            margin: 0.75rem auto;
            max-width: 95%;
        }

        #modalKonfirmasiHapus .modal-header {
            padding: 0.65rem 0.85rem;
        }

        #modalKonfirmasiHapus .modal-title {
            font-size: 0.85rem;
        }

        #modalKonfirmasiHapus .modal-body {
            padding: 0.85rem;
        }

        #modalKonfirmasiHapus .modal-body .bi-trash {
            font-size: 1.75rem !important;
        }

        #modalKonfirmasiHapus .modal-body h5 {
            font-size: 0.9rem;
        }

        #modalKonfirmasiHapus .modal-body p {
            font-size: 0.7rem;
        }

        #modalKonfirmasiHapus .modal-footer {
            padding: 0.65rem;
        }

        #modalKonfirmasiHapus .modal-footer .btn {
            padding: 0.45rem 0.75rem;
            font-size: 0.75rem;
        }
    }

    /* ===== DARK MODE STYLES ===== */
    body.dark-mode .cart-wrapper {
        background: #1a1a2e;
    }

    body.dark-mode .cart-header {
        background: #16213e;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.5);
    }

    body.dark-mode .cart-header h2 {
        color: #e5e7eb;
    }

    body.dark-mode .cart-item-card {
        background: #16213e;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.5);
    }

    body.dark-mode .cart-item-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.7);
    }

    body.dark-mode .item-name {
        color: #e5e7eb;
    }

    body.dark-mode .item-price {
        color: #9ca3af;
    }

    body.dark-mode .qty-btn {
        background: #1a1a2e;
        border-color: rgba(3, 172, 14, 0.3);
        color: #03AC0E;
    }

    body.dark-mode .qty-btn:hover {
        background: #03AC0E;
        color: #ffffff;
        border-color: #03AC0E;
    }

    body.dark-mode .qty-display {
        color: #e5e7eb;
    }

    body.dark-mode .item-subtotal {
        color: #03AC0E;
    }

    body.dark-mode .btn-delete-item {
        background: transparent;
        border-color: #ef4444;
        color: #ef4444;
    }

    body.dark-mode .btn-delete-item:hover {
        background: #ef4444;
        color: #ffffff;
    }

    body.dark-mode .btn-delete-all {
        background: transparent;
        border-color: #ef4444;
        color: #ef4444;
    }

    body.dark-mode .btn-delete-all:hover {
        background: #ef4444;
        color: #ffffff;
    }

    body.dark-mode .cart-summary {
        background: #16213e;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.5);
    }

    body.dark-mode .cart-summary h5 {
        color: #e5e7eb;
    }

    body.dark-mode .summary-label {
        color: #9ca3af;
    }

    body.dark-mode .summary-value {
        color: #e5e7eb;
    }

    body.dark-mode .summary-total-label {
        color: #e5e7eb;
    }

    body.dark-mode .summary-total-value {
        color: #03AC0E;
    }

    body.dark-mode .summary-total {
        border-top-color: rgba(255, 255, 255, 0.1);
    }

    body.dark-mode .empty-cart {
        background: #16213e;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.5);
    }

    body.dark-mode .empty-cart i {
        color: #4b5563;
    }

    body.dark-mode .empty-cart h3 {
        color: #e5e7eb;
    }

    body.dark-mode .empty-cart p {
        color: #9ca3af;
    }

    /* Dark Mode - Modal */
    body.dark-mode .modal-content {
        background: #16213e;
    }

    body.dark-mode .modal-body {
        background: #1a1a2e !important;
    }

    body.dark-mode .modal-footer {
        background: #16213e !important;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    body.dark-mode .card {
        background: #16213e;
        border-color: rgba(3, 172, 14, 0.2);
    }

    body.dark-mode .card-body span {
        color: #9ca3af;
    }

    body.dark-mode .payment-section-compact {
        background: #16213e;
        border-color: rgba(3, 172, 14, 0.2);
    }

    body.dark-mode .payment-details-compact {
        background: #16213e;
        border-color: rgba(3, 172, 14, 0.2);
    }

    body.dark-mode .form-label {
        color: #e5e7eb;
    }

    body.dark-mode .form-control {
        background: #1a1a2e;
        border-color: rgba(3, 172, 14, 0.3);
        color: #e5e7eb;
    }

    body.dark-mode .form-control:focus {
        background: #1a1a2e;
        border-color: #03AC0E;
        color: #e5e7eb;
    }

    body.dark-mode .form-control::placeholder {
        color: #6b7280;
    }

    body.dark-mode .text-muted {
        color: #9ca3af !important;
    }

    body.dark-mode .payment-method-compact {
        border-color: rgba(3, 172, 14, 0.3);
    }

    body.dark-mode .payment-method-compact:hover {
        border-color: #03AC0E;
    }

    body.dark-mode .btn-check:checked + .payment-method-compact {
        background: #03AC0E;
    }

    body.dark-mode .alert-success {
        background: rgba(3, 172, 14, 0.1);
        border: 1px solid rgba(3, 172, 14, 0.3);
        color: #03AC0E;
    }

    .payment-input-section {
        transition: all 0.3s ease;
    }

    .payment-input-section:focus-within {
        border-color: #03AC0E !important;
        box-shadow: 0 0 0 0.2rem rgba(3, 172, 14, 0.15);
    }

    #bayar:focus {
        border-color: #03AC0E !important;
        box-shadow: 0 0 0 0.2rem rgba(3, 172, 14, 0.15);
    }

    .modal-checkout .modal-dialog {
        max-width: 500px;
    }

    @media (max-width: 576px) {
        .modal-checkout .modal-dialog {
            margin: 0.5rem;
        }
    }

    /* Dark Mode untuk modal baru */
    body.dark-mode .payment-input-section {
        background: #1a1a2e !important;
        border-color: rgba(3, 172, 14, 0.3) !important;
    }

    body.dark-mode .payment-input-section label {
        color: #e5e7eb !important;
    }

    body.dark-mode #bayar {
        background: #16213e !important;
        border-color: rgba(3, 172, 14, 0.3) !important;
        color: #e5e7eb !important;
    }

    body.dark-mode #kembalian {
        background: rgba(3, 172, 14, 0.15) !important;
        border-color: #03AC0E !important;
    }

    body.dark-mode #kembalian strong {
        color: #e5e7eb !important;
    }

    /* Dark Mode untuk QRIS Section */
    body.dark-mode .payment-qris-section {
        background: #1a1a2e !important;
        border-color: rgba(3, 172, 14, 0.3) !important;
    }

    body.dark-mode .payment-qris-section h6 {
        color: #e5e7eb !important;
    }

    body.dark-mode .qr-code-container {
        background: #16213e !important;
    }

    body.dark-mode .payment-qris-section .alert-info {
        background: rgba(33, 150, 243, 0.15) !important;
        border-color: rgba(33, 150, 243, 0.3) !important;
    }

    body.dark-mode .payment-qris-section .alert-info small {
        color: #64b5f6 !important;
    }

    body.dark-mode .payment-qris-section p {
        color: #e5e7eb !important;
    }

    body.dark-mode .btn-outline-success {
        color: #03AC0E;
        border-color: #03AC0E;
    }

    body.dark-mode .btn-check:checked + .btn-outline-success {
        background: #03AC0E;
        color: white;
    }

    /* Dark Mode untuk DANA Section */
    body.dark-mode .dana-number-box {
        background: #16213e !important;
        border-color: rgba(3, 172, 14, 0.5) !important;
    }

    body.dark-mode .dana-number-box h3 {
        color: #03AC0E !important;
    }

    body.dark-mode .dana-number-box small {
        color: #9ca3af !important;
    }

    body.dark-mode .dana-amount {
        background: rgba(3, 172, 14, 0.15) !important;
        border-color: #03AC0E !important;
    }

    body.dark-mode .dana-amount strong {
        color: #e5e7eb !important;
    }

    body.dark-mode .dana-amount span {
        color: #03AC0E !important;
    }

    body.dark-mode .alert-info {
        background: rgba(33, 150, 243, 0.15) !important;
        border-color: rgba(33, 150, 243, 0.3) !important;
    }

    body.dark-mode .alert-info strong,
    body.dark-mode .alert-info ol,
    body.dark-mode .alert-info li {
        color: #64b5f6 !important;
    }
</style>

<div class="cart-wrapper">
    <div class="container">
        @if(count($keranjang) > 0)
            <div class="row">
                <!-- Cart Items -->
                <div class="col-lg-8">
                    <div class="cart-header">
                        <h2>Keranjang Belanja</h2>
                    </div>

                    @foreach($keranjang as $id => $item)
                        @php
                            $barang = \App\Models\Barang::find($id);
                            $stokString = $barang ? trim($barang->stok_barang) : '0';
                            preg_match('/^(\d+(?:\.\d+)?)/', $stokString, $matches);
                            $stokTersedia = isset($matches[1]) ? floatval($matches[1]) : 0;
                        @endphp
                        <div class="cart-item-card" data-id="{{ $id }}" data-stock="{{ $stokTersedia }}">
                            <div class="item-row">
                                <div class="item-name">
                                    {{ $item['nama_barang'] }}
                                </div>
                                <div class="item-price">
                                    Rp {{ number_format($item['harga_barang'], 0, ',', '.') }}
                                </div>
                                <div class="item-qty-control">
                                    <button type="button" class="qty-btn" onclick="updateQuantity('{{ $id }}', -1)">
                                        <i class="bi bi-dash"></i>
                                    </button>
                                    <span class="qty-display" id="qty-{{ $id }}">{{ $item['jumlah'] }}</span>
                                    <button type="button" class="qty-btn" onclick="updateQuantity('{{ $id }}', 1)">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                </div>
                                <div class="item-subtotal" id="subtotal-{{ $id }}">
                                    Rp {{ number_format($item['harga_barang'] * $item['jumlah'], 0, ',', '.') }}
                                </div>
                                <div class="item-delete">
                                    <button type="button" class="btn-delete-item" data-id="{{ $id }}">
                                        Hapus
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Summary Sidebar -->
                <div class="col-lg-4">
                    <div class="cart-summary">
                        <h5 class="mb-3 fw-bold">Ringkasan Belanja</h5>
                        <div class="summary-row">
                            <span class="summary-label">Total Item</span>
                            <span class="summary-value">{{ count($keranjang) }} item</span>
                        </div>
                        <div class="summary-row summary-total">
                            <span class="summary-total-label">Total Belanja</span>
                            <span class="summary-total-value" id="total-belanja">
                                Rp {{ number_format($total, 0, ',', '.') }}
                            </span>
                        </div>
                        
                        @auth
                            <button type="button" class="btn-checkout" data-bs-toggle="modal" data-bs-target="#modalBayar">
                                Bayar
                            </button>
                        @else
                            <a href="{{ route('login') }}" class="btn-checkout" style="display: block; text-align: center; text-decoration: none;">
                                Login untuk Checkout
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        @else
            <div class="empty-cart">
                <i class="bi bi-cart-x"></i>
                <h3>Keranjang Masih Kosong</h3>
                <p></p>
            </div>
        @endif
    </div>
</div>

{{-- MODAL BAYAR - HANYA TAMPIL JIKA SUDAH LOGIN --}}
@auth
<div class="modal fade modal-checkout" id="modalBayar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: #03AC0E; color: white; padding: 1.5rem;">
                <h5 class="modal-title fw-bold mb-0">
                    <i class="bi bi-cash-coin me-2"></i>Pembayaran
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('keranjang.checkout') }}" method="POST" id="checkoutForm">
                @csrf
                <input type="hidden" name="metode_pembayaran" id="metodePembayaranInput" value="">
                
                <div class="modal-body" style="background: #f8f9fa; padding: 1.5rem;">
                    {{-- RINGKASAN BELANJA - SIMPLE VERSION --}}
                    <div class="card mb-4 border-0 shadow-sm">
                        <div class="card-body" style="padding: 1.5rem;">
                            <div class="d-flex justify-content-between align-items-center mb-3 pb-3" style="border-bottom: 2px solid #e9ecef;">
                                <span style="font-size: 1.1rem; font-weight: 600; color: #6b7280;">
                                    <i class="bi bi-bag-check me-2"></i>Total Item:
                                </span>
                                <span class="fw-bold" style="font-size: 1.2rem; color: #212529;">{{ count($keranjang) }} item</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span style="font-size: 1.2rem; font-weight: 700; color: #212529;">
                                    <i class="bi bi-cash-coin me-2"></i>Total Harga:
                                </span>
                                <span class="fw-bold" style="font-size: 1.6rem; color: #03AC0E;" id="modal-total-belanja">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- PILIHAN METODE PEMBAYARAN --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold mb-3" style="font-size: 1rem; color: #212529;">
                            <i class="bi bi-wallet2 me-2 text-success"></i>Pilih Metode Pembayaran <span class="text-danger">*</span>
                        </label>
                        <div class="row g-2">
                            <div class="col-4">
                                <input type="radio" class="btn-check" name="payment-method" id="metodeDana" value="DANA">
                                <label class="btn btn-outline-success w-100 py-3" for="metodeDana" style="border: 2px solid #dee2e6; border-radius: 12px;">
                                    <i class="bi bi-wallet2 d-block mb-2" style="font-size: 2rem; color: #118EEA;"></i>
                                    <span class="fw-bold">DANA</span>
                                </label>
                            </div>
                            <div class="col-4">
                                <input type="radio" class="btn-check" name="payment-method" id="metodeQRIS" value="QRIS">
                                <label class="btn btn-outline-success w-100 py-3" for="metodeQRIS" style="border: 2px solid #dee2e6; border-radius: 12px;">
                                    <i class="bi bi-qr-code d-block mb-2" style="font-size: 2rem;"></i>
                                    <span class="fw-bold">QRIS</span>
                                </label>
                            </div>
                            <div class="col-4">
                                <input type="radio" class="btn-check" name="payment-method" id="metodeTunai" value="Tunai">
                                <label class="btn btn-outline-success w-100 py-3" for="metodeTunai" style="border: 2px solid #dee2e6; border-radius: 12px;">
                                    <i class="bi bi-cash-coin d-block mb-2" style="font-size: 2rem; color: #6c757d;"></i>
                                    <span class="fw-bold">Tunai</span>
                                </label>
                            </div>
                        </div>
                        <div id="payment-method-error" class="text-danger mt-2" style="display: none; font-size: 0.875rem;">
                            <i class="bi bi-exclamation-circle me-1"></i>Silakan pilih metode pembayaran terlebih dahulu
                        </div>
                    </div>

                    {{-- INPUT PEMBAYARAN DANA --}}
                    <div class="payment-input-section" id="danaSection" style="background: white; padding: 1.25rem; border-radius: 12px; border: 2px solid #e9ecef; display: none;">
                        <div class="text-center mb-3">
                            <div style="background: linear-gradient(135deg, #03AC0E 0%, #028A0F 100%); color: white; padding: 1rem; border-radius: 12px; margin-bottom: 1rem;">
                                <i class="bi bi-wallet2" style="font-size: 2.5rem; display: block; margin-bottom: 0.5rem;"></i>
                                <h6 class="fw-bold mb-2">Transfer ke DANA</h6>
                                <p class="mb-0" style="font-size: 0.9rem; opacity: 0.9;">Kirim pembayaran ke nomor DANA berikut:</p>
                            </div>
                            
                            <div class="dana-number-box" style="background: #f8f9fa; border: 2px dashed #03AC0E; border-radius: 12px; padding: 1.5rem; margin-bottom: 1rem;">
                                <label class="form-label fw-bold text-muted mb-2" style="font-size: 0.85rem;">NOMOR DANA</label>
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    <h3 class="fw-bold mb-0" style="color: #03AC0E; font-size: 1.8rem; letter-spacing: 2px;" id="danaNomor">085893265952</h3>
                                    <button type="button" class="btn btn-sm btn-outline-success" onclick="copyDanaNumber()" style="border-radius: 8px; border-color: #03AC0E; color: #03AC0E;">
                                        <i class="bi bi-clipboard"></i> Salin
                                    </button>
                                </div>
                                <small class="text-muted d-block mt-2">
                                    <i class="bi bi-person-circle me-1"></i>a.n. Warung Sembako CPM
                                </small>
                            </div>

                            <div class="alert alert-info" style="background: #d1f4e0; border: 1px solid #03AC0E; border-radius: 8px; text-align: left;">
                                <strong style="color: #028A0F;"><i class="bi bi-info-circle me-2"></i>Cara Pembayaran:</strong>
                                <ol class="mb-0 mt-2" style="color: #028A0F; font-size: 0.85rem; padding-left: 1.2rem;">
                                    <li>Buka aplikasi DANA</li>
                                    <li>Pilih menu "Kirim"</li>
                                    <li>Masukkan nomor DANA: <strong>085893265952</strong></li>
                                    <li>Masukkan nominal: <strong id="dana-total-inline">Rp {{ number_format($total, 0, ',', '.') }}</strong></li>
                                    <li>Konfirmasi dan kirim pembayaran</li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    {{-- TAMPILAN QRIS --}}
                    <div class="payment-qris-section" id="qrisSection" style="background: white; padding: 1.5rem; border-radius: 12px; border: 2px solid #e9ecef; display: none;">
                        <div class="text-center">
                            <h6 class="fw-bold mb-3" style="color: #212529;">
                                <i class="bi bi-qr-code-scan me-2 text-success"></i>Scan QR Code untuk Pembayaran
                            </h6>
                            <div class="qr-code-container mb-3" style="background: white; padding: 1rem; border-radius: 12px; display: inline-block; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                                <img src="{{ asset('images/qris-code.jpeg') }}" alt="QRIS Code" style="max-width: 100%; height: auto; max-height: 350px; border: 2px solid #03AC0E; border-radius: 8px; object-fit: contain;">
                            </div>
                            <div class="alert alert-info mb-3" style="background: #e3f2fd; border: 1px solid #2196F3; border-radius: 8px;">
                                <i class="bi bi-info-circle me-2"></i>
                                <small class="fw-semibold" style="color: #1976d2;">Scan kode QR dengan aplikasi pembayaran digital Anda</small>
                            </div>
                            <div class="payment-apps" style="display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;">
                                <span class="badge" style="background: #00AA13; padding: 0.5rem 1rem; font-size: 0.85rem; border-radius: 20px;">
                                    <i class="bi bi-wallet2 me-1"></i>GoPay
                                </span>
                                <span class="badge" style="background: #0081C9; padding: 0.5rem 1rem; font-size: 0.85rem; border-radius: 20px;">
                                    <i class="bi bi-wallet2 me-1"></i>OVO
                                </span>
                                <span class="badge" style="background: #002A5C; padding: 0.5rem 1rem; font-size: 0.85rem; border-radius: 20px;">
                                    <i class="bi bi-wallet2 me-1"></i>DANA
                                </span>
                                <span class="badge" style="background: #EC0033; padding: 0.5rem 1rem; font-size: 0.85rem; border-radius: 20px;">
                                    <i class="bi bi-wallet2 me-1"></i>LinkAja
                                </span>
                            </div>
                            <div class="mt-3 text-center">
                                <p class="mb-2 fw-bold" style="color: #212529; font-size: 1.1rem;">
                                    Total Pembayaran: <span class="text-success" id="qris-total">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </p>
                                <small class="text-muted" style="font-size: 0.85rem;">
                                    <i class="bi bi-shield-check me-1"></i>Pembayaran aman dan terenkripsi
                                </small>
                            </div>
                        </div>
                    </div>

                    {{-- TAMPILAN BAYAR DI TEMPAT (TUNAI) --}}
                    <div class="payment-tunai-section" id="tunaiSection" style="background: white; padding: 1.5rem; border-radius: 12px; border: 2px solid #e9ecef; display: none;">
                        <div class="text-center">
                            <div style="background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%); color: white; padding: 1rem; border-radius: 12px; margin-bottom: 1rem;">
                                <i class="bi bi-cash-coin" style="font-size: 2.5rem; display: block; margin-bottom: 0.5rem;"></i>
                                <h6 class="fw-bold mb-2">Bayar di Tempat</h6>
                                <p class="mb-0" style="font-size: 0.9rem; opacity: 0.9;">Lakukan pembayaran tunai saat pengambilan produk</p>
                            </div>

                            <div class="alert alert-info" style="background: #fff3cd; border: 1px solid #ffc107; border-radius: 8px; text-align: left;">
                                <strong style="color: #856404;"><i class="bi bi-info-circle me-2"></i>Informasi Penting:</strong>
                                <ul class="mb-0 mt-2" style="color: #856404; font-size: 0.85rem; padding-left: 1.5rem;">
                                    <li>Pesanan Anda akan disiapkan setelah konfirmasi</li>
                                    <li>Siapkan uang pas atau kembalian yang sesuai</li>
                                    <li>Tunjukkan bukti pemesanan saat pengambilan</li>
                                    <li>Pembayaran dilakukan di kasir warung</li>
                                </ul>
                            </div>

                            <div style="background: #f8f9fa; border: 2px dashed #6c757d; border-radius: 12px; padding: 1.5rem;">
                                <label class="form-label fw-bold text-muted mb-2" style="font-size: 0.85rem;">TOTAL YANG HARUS DIBAYAR</label>
                                <h3 class="fw-bold mb-0" style="color: #6c757d; font-size: 2rem;" id="tunai-total">Rp {{ number_format($total, 0, ',', '.') }}</h3>
                                <small class="text-muted d-block mt-2">
                                    <i class="bi bi-shop me-1"></i>Bayar di Warung Sembako CPM
                                </small>
                            </div>

                            <div class="mt-3">
                                <p class="mb-0 fw-semibold" style="color: #28a745; font-size: 0.9rem;">
                                    <i class="bi bi-check-circle me-1"></i>
                                    Klik "Proses Pembayaran" untuk konfirmasi pesanan
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer" style="background: white; padding: 1rem 1.5rem; border-top: 2px solid #e9ecef;">
                    <button type="button" class="btn btn-secondary px-4 py-2" data-bs-dismiss="modal" style="font-size: 1rem; font-weight: 600;">
                        <i class="bi bi-x-circle me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-success px-4 py-2" id="btnProsesPembayaran" style="font-size: 1rem; font-weight: 600; background: #03AC0E; border: none;">
                        <i class="bi bi-check-circle me-2"></i>Proses Pembayaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endauth

{{-- MODAL KONFIRMASI HAPUS --}}
<div class="modal fade" id="modalKonfirmasiHapus" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; overflow: hidden; border: none;">
            <div class="modal-header" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; padding: 1.5rem; border: none;">
                <h5 class="modal-title fw-bold mb-0">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center" style="padding: 2rem;">
                <div class="mb-3">
                    <i class="bi bi-trash" style="font-size: 4rem; color: #ef4444;"></i>
                </div>
                <h5 class="fw-bold mb-2" style="color: #212529;">Hapus Produk Ini?</h5>
                <p class="text-muted mb-0" style="font-size: 0.95rem;">
                    Produk ini akan dihapus dari keranjang belanja Anda
                </p>
            </div>
            <div class="modal-footer" style="border: none; padding: 1rem 1.5rem; background: #f8f9fa;">
                <button type="button" class="btn btn-secondary px-4 py-2" data-bs-dismiss="modal" style="font-size: 1rem; font-weight: 600; border-radius: 8px;">
                    <i class="bi bi-x-circle me-2"></i>Batal
                </button>
                <button type="button" class="btn btn-danger px-4 py-2" id="confirmDeleteBtn" style="font-size: 1rem; font-weight: 600; border-radius: 8px;">
                    <i class="bi bi-trash me-2"></i>Ya, Hapus
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Variable global untuk menyimpan total saat ini
    let currentTotal = {{ $total }};
    let deleteItemId = null;

    // Update modal ketika dibuka
    document.getElementById('modalBayar').addEventListener('show.bs.modal', function() {
        updateModalTotal();
    });

    // Fungsi untuk update total di modal
    function updateModalTotal() {
        const totalBelanjaText = document.getElementById('total-belanja').textContent;
        const totalValue = parseInt(totalBelanjaText.replace(/[^0-9]/g, ''));
        currentTotal = totalValue;
        
        // Update total di modal
        document.getElementById('modal-total-belanja').textContent = 'Rp ' + totalValue.toLocaleString('id-ID');
        document.getElementById('qris-total').textContent = 'Rp ' + totalValue.toLocaleString('id-ID');
        document.getElementById('dana-total').textContent = 'Rp ' + totalValue.toLocaleString('id-ID');
        document.getElementById('dana-total-inline').textContent = 'Rp ' + totalValue.toLocaleString('id-ID');
        
        // Reset ke metode DANA
        document.getElementById('metodeDana').checked = false;
        document.getElementById('danaSection').style.display = 'none';
        document.getElementById('qrisSection').style.display = 'none';
        document.getElementById('tunaiSection').style.display = 'none';
        document.getElementById('metodePembayaranInput').value = '';
    }

    // Fungsi untuk copy nomor DANA
    function copyDanaNumber() {
        const nomorDana = document.getElementById('danaNomor').textContent;
        navigator.clipboard.writeText(nomorDana).then(function() {
            showNotification('Nomor DANA berhasil disalin: ' + nomorDana, 'success');
        }).catch(function(err) {
            console.error('Gagal menyalin:', err);
            showNotification('Gagal menyalin nomor DANA', 'error');
        });
    }

    // Handle perubahan metode pembayaran
    document.querySelectorAll('input[name="payment-method"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const metodePembayaran = this.value;
            const danaSection = document.getElementById('danaSection');
            const qrisSection = document.getElementById('qrisSection');
            const tunaiSection = document.getElementById('tunaiSection');
            
            // Update hidden input
            document.getElementById('metodePembayaranInput').value = metodePembayaran;
            
            if (metodePembayaran === 'QRIS') {
                // Tampilkan QRIS, sembunyikan DANA dan Tunai
                danaSection.style.display = 'none';
                qrisSection.style.display = 'block';
                tunaiSection.style.display = 'none';
            } else if (metodePembayaran === 'Tunai') {
                // Tampilkan Tunai, sembunyikan DANA dan QRIS
                danaSection.style.display = 'none';
                qrisSection.style.display = 'none';
                tunaiSection.style.display = 'block';
            } else {
                // Tampilkan DANA, sembunyikan QRIS dan Tunai
                danaSection.style.display = 'block';
                qrisSection.style.display = 'none';
                tunaiSection.style.display = 'none';
            }
        });
    });

    // Validasi form sebelum submit
    document.getElementById('checkoutForm').addEventListener('submit', function(e) {
        const metodePembayaran = document.getElementById('metodePembayaranInput').value;
        if (!metodePembayaran) {
            e.preventDefault();
            const errorElement = document.getElementById('payment-method-error');
            errorElement.style.display = 'block';
            return false;
        }
        return true;
    });

    // Handle tombol Hapus per item
    document.querySelectorAll('.btn-delete-item').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const itemId = this.getAttribute('data-id');
            deleteItemId = itemId;
            
            const modal = new bootstrap.Modal(document.getElementById('modalKonfirmasiHapus'));
            modal.show();
        });
    });

    // Konfirmasi hapus item
    document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
        if (deleteItemId) {
            // Buat form untuk POST request
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/keranjang/hapus/${deleteItemId}`;
            
            // Tambahkan CSRF token
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = document.querySelector('meta[name="csrf-token"]').content;
            form.appendChild(csrfInput);
            
            // Tambahkan form ke body dan submit
            document.body.appendChild(form);
            form.submit();
        }
    });

    function updateQuantity(id, change) {
        const qtyElement = document.getElementById('qty-' + id);
        const currentQty = parseInt(qtyElement.textContent);
        const newQty = currentQty + change;
        
        // Jika jumlah akan menjadi 0 atau kurang, tampilkan modal konfirmasi hapus
        if (newQty <= 0) {
            deleteItemId = id;
            const modal = new bootstrap.Modal(document.getElementById('modalKonfirmasiHapus'));
            modal.show();
            return;
        }
        
        const card = document.querySelector(`[data-id="${id}"]`);
        const stokTersedia = parseFloat(card.getAttribute('data-stock'));
        
        // Cek stok sebelum update
        if (newQty > stokTersedia) {
            showNotification('Stok tidak mencukupi! Stok tersedia: ' + stokTersedia, 'error');
            return;
        }
        
        card.classList.add('qty-loading');
        
        // Gunakan URL helper Laravel
        const updateUrl = "{{ route('keranjang.update', ':id') }}".replace(':id', id);
        
        fetch(updateUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ change: change })
        })
        .then(response => {
            // Cek apakah response adalah HTML (error page)
            const contentType = response.headers.get('content-type');
            if (contentType && contentType.includes('text/html')) {
                // Redirect ke login jika session habis
                if (response.status === 401 || response.status === 419) {
                    showNotification('Sesi Anda telah berakhir. Silakan login kembali.', 'error');
                    setTimeout(() => {
                        window.location.href = "{{ route('login') }}";
                    }, 2000);
                    throw new Error('Session expired');
                }
                throw new Error('Server mengembalikan HTML alih-alih JSON. Silakan refresh halaman.');
            }
            
            // Cek status response
            if (!response.ok) {
                return response.json().then(err => {
                    throw new Error(err.message || 'Terjadi kesalahan');
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Update tampilan keranjang
                qtyElement.textContent = data.quantity;
                document.getElementById('subtotal-' + id).textContent = 'Rp ' + data.subtotal.toLocaleString('id-ID');
                document.getElementById('total-belanja').textContent = 'Rp ' + data.total.toLocaleString('id-ID');
                
                // Update badge
                if (typeof window.updateCartBadge === 'function') {
                    window.updateCartBadge(data.cart_count);
                }
                
                // Update currentTotal untuk modal
                currentTotal = data.total;
                
                card.classList.remove('qty-loading');
                
                // Tampilkan notifikasi sukses
                showNotification('Jumlah produk berhasil diupdate', 'success');
            } else {
                card.classList.remove('qty-loading');
                showNotification(data.message || 'Gagal mengupdate jumlah produk', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            card.classList.remove('qty-loading');
            
            // Tampilkan pesan error yang lebih user-friendly
            if (error.message.includes('Session expired')) {
                return; // Sudah ada notifikasi dan redirect
            } else if (error.message.includes('HTML')) {
                showNotification('Terjadi kesalahan. Silakan refresh halaman (F5)', 'error');
            } else {
                showNotification(error.message || 'Terjadi kesalahan saat mengupdate jumlah produk', 'error');
            }
        });
    }
    
    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = 'alert-fixed';
        
        let iconClass = 'bi-check-circle-fill';
        let borderColor = '#03AC0E';
        let iconColor = '#03AC0E';
        
        if (type === 'error') {
            iconClass = 'bi-x-circle-fill';
            borderColor = '#dc3545';
            iconColor = '#dc3545';
            notification.classList.add('alert-error');
        } else if (type === 'warning') {
            iconClass = 'bi-exclamation-triangle-fill';
            borderColor = '#ffc107';
            iconColor = '#ffc107';
            notification.classList.add('alert-warning');
        } else {
            notification.classList.add('alert-success');
        }
        
        notification.style.background = '#ffffff';
        notification.style.color = '#2d3748';
        notification.style.borderLeft = `4px solid ${borderColor}`;
        
        notification.innerHTML = `<i class="bi ${iconClass}" style="color: ${iconColor};"></i><div class="alert-fixed-text">${message}</div>`;
        document.body.appendChild(notification);
        
        setTimeout(function() {
            notification.style.transition = 'opacity 0.5s ease';
            notification.style.opacity = '0';
            setTimeout(function() {
                notification.remove();
            }, 500);
        }, 3000);
    }
</script>

{{-- Dark Mode Styles untuk Modal Konfirmasi --}}
<style>
    body.dark-mode .modal-content {
        background: #16213e;
    }
    
    body.dark-mode .modal-body {
        background: #16213e !important;
    }
    
    body.dark-mode .modal-body h5 {
        color: #e5e7eb;
    }
    
    body.dark-mode .modal-body p {
        color: #9ca3af;
    }
    
    body.dark-mode .modal-footer {
        background: #1a1a2e !important;
    }
</style>
@endsection
