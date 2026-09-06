@extends('layouts.app')

@section('content')
<div class="profile-container">
    <div class="container py-5">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3 mb-4">
                <div class="profile-sidebar">
                    <div class="profile-avatar">
                        <div class="avatar-circle">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <h5 class="mt-3">{{ Auth::user()->name }}</h5>
                        <p class="text-muted">{{ Auth::user()->email }}</p>
                        <span class="role-badge">{{ ucfirst(Auth::user()->role) }}</span>
                    </div>
                    
                    <div class="profile-menu mt-4">
                        <a href="#ubah-password" class="menu-item active" data-tab="ubah-password">
                            <i class="bi bi-shield-lock"></i>
                            <span>Ubah Password</span>
                        </a>
                        <a href="#riwayat-pesanan" class="menu-item" data-tab="riwayat-pesanan">
                            <i class="bi bi-receipt-cutoff"></i>
                            <span>Riwayat Transaksi</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Ubah Password Tab -->
                <div class="profile-content-card tab-content active" id="ubah-password">
                    <div class="card-header">
                        <h4><i class="bi bi-shield-lock me-2"></i>Ubah Password</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('profile.password.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-3">
                                <label for="current_password" class="form-label">
                                    <i class="bi bi-key me-1"></i>Password Saat Ini
                                </label>
                                <input type="password" class="form-control" id="current_password" 
                                       name="current_password" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="password" class="form-label">
                                    <i class="bi bi-key-fill me-1"></i>Password Baru
                                </label>
                                <input type="password" class="form-control" id="password" 
                                       name="password" required>

                            </div>
                            
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">
                                    <i class="bi bi-key-fill me-1"></i>Konfirmasi Password Baru
                                </label>
                                <input type="password" class="form-control" id="password_confirmation" 
                                       name="password_confirmation" required>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-shield-check me-1"></i>Update Password
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Riwayat Transaksi Tab -->
                <div class="profile-content-card tab-content" id="riwayat-pesanan">
                    <div class="card-header">
                        <h4><i class="bi bi-receipt-cutoff me-2"></i>Riwayat Transaksi</h4>
                        
                    </div>
                    <div class="card-body">
                        @if($transaksi->count() > 0)
                            <!-- Filter & Search untuk Admin/Pemilik Warung -->
                            @if(Auth::user()->isAdminOrOwner())
                                <div class="filter-section mb-4">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" id="searchTransaksi" 
                                                   placeholder="ðŸ” Cari berdasarkan ID, nama pembeli, atau metode pembayaran...">
                                        </div>
                                        <div class="col-md-3">
                                            <select class="form-control" id="filterMetode">
                                                <option value="">Semua Metode Pembayaran</option>
                                                <option value="Tunai">Tunai</option>
                                                <option value="Transfer">Transfer</option>
                                                <option value="E-Wallet">E-Wallet</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <select class="form-control" id="sortBy">
                                                <option value="terbaru">Terbaru</option>
                                                <option value="terlama">Terlama</option>
                                                <option value="tertinggi">Total Tertinggi</option>
                                                <option value="terendah">Total Terendah</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Statistik untuk Admin/Pemilik Warung -->
                                <div class="stats-grid mb-4">
                                    <div class="stat-card">
                                        <div class="stat-icon">
                                            <i class="bi bi-receipt"></i>
                                        </div>
                                        <div class="stat-info">
                                            <h3>{{ $transaksi->count() }}</h3>
                                            <p>Total Transaksi</p>
                                        </div>
                                    </div>
                                    <div class="stat-card">
                                        <div class="stat-icon">
                                            <i class="bi bi-cash-stack"></i>
                                        </div>
                                        <div class="stat-info">
                                            <h3>Rp {{ number_format($transaksi->sum('total_harga'), 0, ',', '.') }}</h3>
                                            <p>Total Pendapatan</p>
                                        </div>
                                    </div>
                                    <div class="stat-card">
                                        <div class="stat-icon">
                                            <i class="bi bi-people"></i>
                                        </div>
                                        <div class="stat-info">
                                            <h3>{{ $transaksi->unique('user_id')->count() }}</h3>
                                            <p>Total Pelanggan</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="order-list" id="transaksiList">
                                @foreach($transaksi as $t)
                                    <div class="order-item" data-id="{{ $t->id }}" 
                                         data-user="{{ strtolower($t->user->name ?? '') }}" 
                                         data-metode="{{ $t->metode_pembayaran }}"
                                         data-total="{{ $t->total_harga }}"
                                         data-date="{{ $t->created_at->timestamp }}">
                                        <div class="order-header">
                                            <div>
                                                <span class="order-id">#TRX-{{ str_pad($t->id, 5, '0', STR_PAD_LEFT) }}</span>
                                                <span class="order-date">
                                                    <i class="bi bi-calendar3 me-1"></i>
                                                    {{ $t->created_at->format('d M Y, H:i') }}
                                                </span>
                                            </div>
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle me-1"></i>Selesai
                                            </span>
                                        </div>
                                        
                                        <div class="order-body">
                                            @if(Auth::user()->isAdminOrOwner())
                                                <div class="order-user mb-3">
                                                    <i class="bi bi-person-circle me-2"></i>
                                                    <strong>Pembeli:</strong> {{ $t->user->name ?? 'User Tidak Ditemukan' }}
                                                    <span class="text-muted ms-2">({{ $t->user->email ?? '-' }})</span>
                                                </div>
                                            @endif
                                            
                                            <div class="row g-3 mb-3">
                                                <div class="col-md-4">
                                                    <div class="info-item">
                                                        <i class="bi bi-wallet2 me-2 text-success"></i>
                                                        <div>
                                                            <small class="text-muted">Metode Pembayaran</small>
                                                            <div class="fw-bold">{{ $t->metode_pembayaran }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="info-item">
                                                        <i class="bi bi-cash-coin me-2 text-warning"></i>
                                                        <div>
                                                            <small class="text-muted">Total Belanja</small>
                                                            <div class="fw-bold text-success">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="info-item">
                                                        <i class="bi bi-cart-check me-2 text-info"></i>
                                                        <div>
                                                            <small class="text-muted">Item Dibeli</small>
                                                            <div class="fw-bold">
                                                                {{ is_array(json_decode($t->detail_barang, true)) ? count(json_decode($t->detail_barang, true)) : 0 }} Item
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            @if($t->metode_pembayaran === 'Tunai')
                                                <div class="payment-details mb-3">
                                                    <div class="payment-row">
                                                        <span><i class="bi bi-cash me-2"></i>Uang Dibayar:</span>
                                                        <span class="fw-bold">Rp {{ number_format($t->bayar, 0, ',', '.') }}</span>
                                                    </div>
                                                    <div class="payment-row">
                                                        <span><i class="bi bi-arrow-return-left me-2"></i>Kembalian:</span>
                                                        <span class="fw-bold text-success">Rp {{ number_format($t->kembalian, 0, ',', '.') }}</span>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <div class="order-footer">
                                            <a href="{{ route('struk.show', $t->id) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                                <i class="bi bi-receipt"></i> Lihat Struk
                                            </a>
                                            <a href="{{ route('struk.show', $t->id) }}" class="btn btn-sm btn-outline-success" target="_blank">
                                                <i class="bi bi-printer"></i> Cetak Struk
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="empty-state">
                                <i class="bi bi-receipt-cutoff"></i>
                                <h5>Belum ada transaksi</h5>
                                <p>
                                    @if(Auth::user()->isAdminOrOwner())
                                        Belum ada transaksi yang dilakukan pelanggan
                                    @else
                                        Anda belum memiliki riwayat transaksi
                                    @endif
                                </p>
                                @if(!Auth::user()->isAdminOrOwner())
                                    <a href="{{ route('barang.index') }}" class="btn btn-primary">
                                        <i class="bi bi-cart-plus me-1"></i>Mulai Belanja
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* ===== PROFILE CONTAINER - ADAPTIVE BACKGROUND ===== */
    .profile-container {
        min-height: calc(100vh - 200px);
        padding: 20px 0 40px 0; /* Kurangi padding atas */
        background: transparent !important; /* Hilangkan background abu-abu */
    }

    /* Dark Mode - Hapus background gradient yang mengganggu */
    body.dark-mode .profile-container {
        background: transparent !important;
    }

    /* Light Mode - Hapus background gradient yang mengganggu */
    body.light-mode .profile-container {
        background: transparent !important;
    }

    /* ===== PROFILE SIDEBAR ===== */
    body.dark-mode .profile-sidebar {
        background: rgba(20, 20, 30, 0.95);
        border: 2px solid rgba(85, 0, 0, 0.3);
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
    }

    body.light-mode .profile-sidebar {
        background: rgba(255, 255, 255, 0.95);
        border: 2px solid rgba(85, 0, 0, 0.3);
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }

    .profile-sidebar {
        border-radius: 15px;
        padding: 30px;
    }

    .profile-avatar {
        text-align: center;
    }

    .avatar-circle {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: linear-gradient(135deg, #550000, #3d0000);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        font-size: 60px;
        color: white;
        box-shadow: 0 5px 20px rgba(85, 0, 0, 0.4);
    }

    body.dark-mode .profile-avatar h5 {
        color: #fff;
        margin-bottom: 5px;
        font-weight: 700;
    }

    body.light-mode .profile-avatar h5 {
        color: #1a1a2e;
        margin-bottom: 5px;
        font-weight: 700;
    }

    body.dark-mode .profile-avatar .text-muted {
        color: #aaa !important;
        font-size: 14px;
    }

    body.light-mode .profile-avatar .text-muted {
        color: #666 !important;
        font-size: 14px;
    }

    .role-badge {
        display: inline-block;
        background: linear-gradient(135deg, #550000, #3d0000);
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        margin-top: 10px;
    }

    /* ===== PROFILE MENU ===== */
    .profile-menu {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    body.dark-mode .profile-menu .menu-item {
        background: rgba(255, 255, 255, 0.05);
        color: #fff;
        border: 1px solid transparent;
    }

    body.light-mode .profile-menu .menu-item {
        background: rgba(85, 0, 0, 0.05);
        color: #1a1a2e;
        border: 1px solid rgba(85, 0, 0, 0.1);
    }

    .profile-menu .menu-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 15px 20px;
        border-radius: 10px;
        text-decoration: none;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    body.dark-mode .profile-menu .menu-item:hover {
        background: rgba(85, 0, 0, 0.1);
        border-color: rgba(85, 0, 0, 0.5);
        transform: translateX(5px);
    }

    body.light-mode .profile-menu .menu-item:hover {
        background: rgba(85, 0, 0, 0.15);
        border-color: rgba(85, 0, 0, 0.4);
        transform: translateX(5px);
    }

    .profile-menu .menu-item.active {
        background: linear-gradient(135deg, #550000, #3d0000) !important;
        border-color: #550000 !important;
        box-shadow: 0 5px 15px rgba(85, 0, 0, 0.3);
        color: white !important;
    }

    .profile-menu .menu-item i {
        font-size: 20px;
    }

    /* ===== PROFILE CONTENT CARD ===== */
    body.dark-mode .profile-content-card {
        background: rgba(20, 20, 30, 0.95);
        border: 2px solid rgba(85, 0, 0, 0.3);
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
    }

    body.light-mode .profile-content-card {
        background: rgba(255, 255, 255, 0.95);
        border: 2px solid rgba(85, 0, 0, 0.3);
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }

    .profile-content-card {
        border-radius: 15px;
        overflow: hidden;
        display: none;
    }

    .profile-content-card.active {
        display: block;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .profile-content-card .card-header {
        background: linear-gradient(135deg, #550000, #3d0000);
        padding: 25px 30px;
        color: white;
    }

    .profile-content-card .card-header h4 {
        margin: 0;
        font-size: 24px;
        font-weight: 700;
    }

    body.dark-mode .profile-content-card .card-body {
        padding: 30px;
        color: #fff;
    }

    body.light-mode .profile-content-card .card-body {
        padding: 30px;
        color: #1a1a2e;
    }

    /* ===== FORM ELEMENTS ===== */
    body.dark-mode .form-label {
        color: #fff;
        font-weight: 600;
        margin-bottom: 8px;
    }

    body.light-mode .form-label {
        color: #1a1a2e;
        font-weight: 600;
        margin-bottom: 8px;
    }

    body.dark-mode .form-control {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(85, 0, 0, 0.3);
        color: #fff;
    }

    body.light-mode .form-control {
        background: rgba(255, 255, 255, 1);
        border: 1px solid rgba(85, 0, 0, 0.3);
        color: #1a1a2e;
    }

    .form-control {
        padding: 12px 15px;
        border-radius: 8px;
        font-weight: 500;
    }

    body.dark-mode .form-control::placeholder {
        color: #888;
    }

    body.light-mode .form-control::placeholder {
        color: #999;
    }

    body.dark-mode .form-control:focus {
        background: rgba(255, 255, 255, 0.08);
        border-color: #550000;
        color: #fff;
        box-shadow: 0 0 0 0.2rem rgba(85, 0, 0, 0.25);
    }

    body.light-mode .form-control:focus {
        background: #fff;
        border-color: #550000;
        color: #1a1a2e;
        box-shadow: 0 0 0 0.2rem rgba(85, 0, 0, 0.25);
    }

    body.dark-mode .form-control:disabled {
        background: rgba(255, 255, 255, 0.02);
        color: #999;
    }

    body.light-mode .form-control:disabled {
        background: rgba(0, 0, 0, 0.05);
        color: #666;
    }

    body.dark-mode .form-control option {
        background: #1a1a2e;
        color: #fff;
    }

    body.light-mode .form-control option {
        background: #fff;
        color: #1a1a2e;
    }

    /* ===== BUTTONS ===== */
    .btn-primary {
        background: linear-gradient(135deg, #550000, #3d0000);
        border: none;
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 700;
        color: white;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(85, 0, 0, 0.4);
        color: white;
    }

    body.dark-mode .btn-secondary {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: #fff;
    }

    body.light-mode .btn-secondary {
        background: rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(0, 0, 0, 0.2);
        color: #1a1a2e;
    }

    .btn-secondary {
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 700;
        transition: all 0.3s ease;
    }

    body.dark-mode .btn-secondary:hover {
        background: rgba(255, 255, 255, 0.15);
        color: #fff;
    }

    body.light-mode .btn-secondary:hover {
        background: rgba(0, 0, 0, 0.1);
        color: #1a1a2e;
    }

    /* ===== ORDER LIST ===== */
    .order-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    body.dark-mode .order-item {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(85, 0, 0, 0.3);
    }

    body.light-mode .order-item {
        background: rgba(255, 255, 255, 0.8);
        border: 1px solid rgba(85, 0, 0, 0.3);
    }

    .order-item {
        border-radius: 10px;
        padding: 20px;
        transition: all 0.3s ease;
    }

    body.dark-mode .order-item:hover {
        background: rgba(255, 255, 255, 0.08);
        border-color: rgba(85, 0, 0, 0.5);
    }

    body.light-mode .order-item:hover {
        background: rgba(255, 255, 255, 1);
        border-color: rgba(85, 0, 0, 0.5);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    body.dark-mode .order-header {
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    body.light-mode .order-header {
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    }

    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        padding-bottom: 15px;
    }

    .order-id {
        color: #550000;
        font-weight: 700;
        font-size: 16px;
        margin-right: 15px;
    }

    body.dark-mode .order-date {
        color: #aaa;
        font-size: 14px;
        font-weight: 500;
    }

    body.light-mode .order-date {
        color: #666;
        font-size: 14px;
        font-weight: 500;
    }

    .order-body {
        margin-bottom: 15px;
    }

    body.dark-mode .order-user {
        color: #fff;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    body.light-mode .order-user {
        color: #1a1a2e;
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    }

    .order-user {
        padding: 10px 0;
        font-weight: 500;
    }

    body.dark-mode .info-item {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(85, 0, 0, 0.2);
    }

    body.light-mode .info-item {
        background: rgba(85, 0, 0, 0.05);
        border: 1px solid rgba(85, 0, 0, 0.2);
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px;
        border-radius: 8px;
    }

    .info-item i {
        font-size: 20px;
    }

    body.dark-mode .info-item small {
        color: #999;
    }

    body.light-mode .info-item small {
        color: #666;
    }

    .info-item small {
        display: block;
        font-size: 11px;
        margin-bottom: 3px;
        font-weight: 600;
        text-transform: uppercase;
    }

    body.dark-mode .info-item .fw-bold {
        color: #fff;
        font-weight: 700;
    }

    body.light-mode .info-item .fw-bold {
        color: #1a1a2e;
        font-weight: 700;
    }

    body.dark-mode .payment-details {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(85, 0, 0, 0.2);
    }

    body.light-mode .payment-details {
        background: rgba(85, 0, 0, 0.05);
        border: 1px solid rgba(85, 0, 0, 0.2);
    }

    .payment-details {
        border-radius: 8px;
        padding: 15px;
    }

    body.dark-mode .payment-row {
        color: #fff;
    }

    body.light-mode .payment-row {
        color: #1a1a2e;
    }

    .payment-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        font-weight: 600;
    }

    body.dark-mode .payment-row:not(:last-child) {
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    body.light-mode .payment-row:not(:last-child) {
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    }

    body.dark-mode .order-footer {
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    body.light-mode .order-footer {
        border-top: 1px solid rgba(0, 0, 0, 0.1);
    }

    .order-footer {
        display: flex;
        gap: 10px;
        padding-top: 15px;
    }

    .btn-outline-primary {
        background: transparent;
        border: 1px solid #550000;
        color: #550000;
        padding: 8px 16px;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 700;
        transition: all 0.3s ease;
    }

    .btn-outline-primary:hover {
        background: #550000;
        color: #fff;
        transform: translateY(-2px);
    }

    .btn-outline-success {
        background: transparent;
        border: 1px solid #28a745;
        color: #28a745;
        padding: 8px 16px;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 700;
        transition: all 0.3s ease;
    }

    .btn-outline-success:hover {
        background: #28a745;
        color: #fff;
        transform: translateY(-2px);
    }

    /* ===== EMPTY STATE ===== */
    body.dark-mode .empty-state {
        color: #aaa;
    }

    body.light-mode .empty-state {
        color: #666;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-state i {
        font-size: 80px;
        color: rgba(85, 0, 0, 0.3);
        margin-bottom: 20px;
    }

    body.dark-mode .empty-state h5 {
        color: #fff;
        margin-bottom: 10px;
        font-weight: 700;
    }

    body.light-mode .empty-state h5 {
        color: #1a1a2e;
        margin-bottom: 10px;
        font-weight: 700;
    }

    /* ===== ALERTS ===== */
    .alert {
        border-radius: 10px;
        border: none;
        margin-bottom: 20px;
        font-weight: 600;
    }

    .alert-success {
        background: rgba(85, 0, 0, 0.2);
        color: #550000;
        border: 1px solid rgba(85, 0, 0, 0.5);
    }

    .alert-danger {
        background: rgba(220, 53, 69, 0.2);
        color: #dc3545;
        border: 1px solid rgba(220, 53, 69, 0.5);
    }

    body.light-mode .alert-success {
        background: rgba(85, 0, 0, 0.15);
        color: #02a00c;
    }

    body.light-mode .alert-danger {
        background: rgba(220, 53, 69, 0.15);
        color: #bd2130;
    }

    /* ===== STATS GRID ===== */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-bottom: 25px;
    }

    body.dark-mode .stat-card {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(85, 0, 0, 0.3);
    }

    body.light-mode .stat-card {
        background: rgba(255, 255, 255, 0.8);
        border: 1px solid rgba(85, 0, 0, 0.3);
    }

    .stat-card {
        border-radius: 10px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        transition: all 0.3s ease;
    }

    body.dark-mode .stat-card:hover {
        background: rgba(85, 0, 0, 0.1);
        border-color: rgba(85, 0, 0, 0.5);
        transform: translateY(-5px);
    }

    body.light-mode .stat-card:hover {
        background: rgba(255, 255, 255, 1);
        border-color: rgba(85, 0, 0, 0.5);
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, #550000, #3d0000);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        color: white;
        flex-shrink: 0;
    }

    body.dark-mode .stat-info h3 {
        color: #fff;
        font-weight: 700;
    }

    body.light-mode .stat-info h3 {
        color: #1a1a2e;
        font-weight: 700;
    }

    .stat-info h3 {
        margin: 0;
        font-size: 24px;
    }

    body.dark-mode .stat-info p {
        color: #aaa;
    }

    body.light-mode .stat-info p {
        color: #666;
    }

    .stat-info p {
        margin: 5px 0 0 0;
        font-size: 14px;
        font-weight: 600;
    }

    /* ===== FILTER SECTION ===== */
    body.dark-mode .filter-section {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(85, 0, 0, 0.3);
    }

    body.light-mode .filter-section {
        background: rgba(255, 255, 255, 0.8);
        border: 1px solid rgba(85, 0, 0, 0.3);
    }

    .filter-section {
        border-radius: 10px;
        padding: 20px;
    }

    /* ===== TEXT MUTED ===== */
    body.dark-mode .text-muted {
        color: #999 !important;
    }

    body.light-mode .text-muted {
        color: #666 !important;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 991px) {
        .profile-sidebar {
            margin-bottom: 20px;
        }
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .order-footer {
            flex-direction: column;
        }

        .order-footer .btn {
            width: 100%;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const menuItems = document.querySelectorAll('.menu-item, .menu-trigger');
        const tabContents = document.querySelectorAll('.tab-content');

        menuItems.forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const targetTab = this.getAttribute('data-tab');

                // Update active menu item
                document.querySelectorAll('.menu-item').forEach(mi => mi.classList.remove('active'));
                const menuItem = document.querySelector(`.menu-item[data-tab="${targetTab}"]`);
                if (menuItem) menuItem.classList.add('active');

                // Show target tab content
                tabContents.forEach(tc => tc.classList.remove('active'));
                const targetContent = document.getElementById(targetTab);
                if (targetContent) targetContent.classList.add('active');

                // Scroll to top of content
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        });

        // Filter & Search untuk Admin
        const searchInput = document.getElementById('searchTransaksi');
        const filterMetode = document.getElementById('filterMetode');
        const sortBy = document.getElementById('sortBy');
        const transaksiList = document.getElementById('transaksiList');

        if (searchInput && filterMetode && sortBy && transaksiList) {
            // Search function
            searchInput.addEventListener('input', filterTransaksi);
            filterMetode.addEventListener('change', filterTransaksi);
            sortBy.addEventListener('change', sortTransaksi);

            function filterTransaksi() {
                const searchTerm = searchInput.value.toLowerCase();
                const selectedMetode = filterMetode.value;
                const items = transaksiList.querySelectorAll('.order-item');

                items.forEach(item => {
                    const id = item.getAttribute('data-id');
                    const user = item.getAttribute('data-user');
                    const metode = item.getAttribute('data-metode');
                    
                    const matchSearch = id.includes(searchTerm) || user.includes(searchTerm) || metode.toLowerCase().includes(searchTerm);
                    const matchMetode = !selectedMetode || metode === selectedMetode;

                    if (matchSearch && matchMetode) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            }

            function sortTransaksi() {
                const sortValue = sortBy.value;
                const items = Array.from(transaksiList.querySelectorAll('.order-item'));

                items.sort((a, b) => {
                    if (sortValue === 'terbaru') {
                        return parseInt(b.getAttribute('data-date')) - parseInt(a.getAttribute('data-date'));
                    } else if (sortValue === 'terlama') {
                        return parseInt(a.getAttribute('data-date')) - parseInt(b.getAttribute('data-date'));
                    } else if (sortValue === 'tertinggi') {
                        return parseInt(b.getAttribute('data-total')) - parseInt(a.getAttribute('data-total'));
                    } else if (sortValue === 'terendah') {
                        return parseInt(a.getAttribute('data-total')) - parseInt(b.getAttribute('data-total'));
                    }
                });

                items.forEach(item => transaksiList.appendChild(item));
            }
        }
    });
</script>
@endsection

