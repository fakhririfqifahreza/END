<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin - Waroeng 86</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        :root {
            --brand-success: #550000;
            --brand-success-dark: #3d0000;
            --brand-success-rgb: 85, 0, 0;
            --bs-success: #550000;
            --bs-success-rgb: 85, 0, 0;
            --bs-success-text-emphasis: #550000;
            --bs-success-bg-subtle: #f7e3e3;
            --bs-success-border-subtle: #d9a3a3;
        }

        .text-success { color: var(--brand-success) !important; }
        .bg-success { background-color: var(--brand-success) !important; }
        .btn-success {
            --bs-btn-bg: var(--brand-success);
            --bs-btn-border-color: var(--brand-success);
            --bs-btn-hover-bg: var(--brand-success-dark);
            --bs-btn-hover-border-color: var(--brand-success-dark);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            background: #f8f9fa;
            color: #212529;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .navbar-wrapper {
            background: #ffffff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            width: 100%;
            z-index: 1000;
        }

        .navbar-top { padding: 1rem 0; border-bottom: 1px solid #e5e7e9; }
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--brand-success);
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }
        .logo-navbar { width: 40px; height: 40px; object-fit: contain; border-radius: 6px; }

        .icon-group { display: flex; gap: 1rem; align-items: center; }
        .nav-link-custom {
            display: flex;
            align-items: center;
            padding: 0.6rem 1.2rem;
            color: #4b5563;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            position: relative;
        }
        .nav-link-custom:hover { background: #f3f4f6; color: var(--brand-success); }
        .nav-link-custom.active-nav { background: var(--brand-success); color: white; font-weight: 600; }

        .account-dropdown { position: relative; }
        .icon-btn { display: flex; align-items: center; gap: 0.5rem; padding: 0.6rem 1rem; background: transparent; color: #6b7280; border: none; border-radius: 8px; cursor: pointer; font-size: 0.9rem; }
        .dropdown-menu-custom { position: absolute; top: 120%; right: 0; min-width: 240px; background: #ffffff; border: 1px solid #e5e7e9; border-radius: 12px; padding: 12px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15); opacity: 0; visibility: hidden; transform: translateY(-10px); transition: all 0.3s ease; z-index: 1000; }
        .account-dropdown.show .dropdown-menu-custom { opacity: 1; visibility: visible; transform: translateY(0); }
        .user-info { padding: 12px; border-bottom: 1px solid #e5e7e9; margin-bottom: 8px; background: #f9fafb; border-radius: 8px; }
        .user-name { font-weight: 600; color: #1f2937; font-size: 0.95rem; }
        .user-role { font-size: 0.7rem; color: #6b7280; text-transform: uppercase; background: #e5e7e9; padding: 2px 8px; border-radius: 10px; display: inline-block; font-weight: 600; }
        .dropdown-item-custom { display: flex; align-items: center; gap: 10px; padding: 10px 12px; color: #4b5563; text-decoration: none; border-radius: 8px; margin: 4px 0; background: transparent; border: none; width: 100%; text-align: left; cursor: pointer; font-size: 0.85rem; }
        .dropdown-item-custom:hover { background: #f3f4f6; color: var(--brand-success); }

        .navbar-toggler { display: none; border: none; background: transparent; width: 40px; height: 40px; border-radius: 8px; align-items: center; justify-content: center; }
        .navbar-toggler-icon { display: block; width: 24px; height: 2px; background: #4b5563; position: relative; }
        .navbar-toggler-icon::before, .navbar-toggler-icon::after { content: ''; position: absolute; left: 0; width: 24px; height: 2px; background: #4b5563; }
        .navbar-toggler-icon::before { top: -8px; }
        .navbar-toggler-icon::after { top: 8px; }

        .navbar-offcanvas { position: fixed; top: 0; right: -100%; width: 280px; height: 100vh; background: #ffffff; box-shadow: -5px 0 15px rgba(0, 0, 0, 0.1); z-index: 9999; transition: right 0.3s ease; overflow-y: auto; padding: 1rem; }
        .navbar-offcanvas.show { right: 0; }
        .navbar-offcanvas-header { display: flex; justify-content: space-between; align-items: center; padding: 1rem; border-bottom: 1px solid #e5e7e9; margin-bottom: 1rem; }
        .navbar-offcanvas-title { font-size: 1.2rem; font-weight: 700; color: var(--brand-success); margin: 0; }
        .offcanvas-close-btn { background: transparent; border: none; font-size: 1.5rem; color: #6b7280; cursor: pointer; }
        .offcanvas-nav-links { display: flex; flex-direction: column; gap: 0.5rem; margin-bottom: 1.5rem; }
        .offcanvas-nav-link { display: flex; align-items: center; padding: 0.85rem 1rem; color: #4b5563; border-radius: 8px; text-decoration: none; font-weight: 500; }
        .offcanvas-nav-link.active { background: var(--brand-success); color: white; font-weight: 600; }
        .offcanvas-btn-logout { width: 100%; background: transparent; color: #dc2626; border: 2px solid #dc2626; padding: 0.75rem 1.5rem; border-radius: 8px; font-weight: 600; font-size: 0.9rem; cursor: pointer; }

        .navbar-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 9998; opacity: 0; visibility: hidden; transition: all 0.3s ease; }
        .navbar-overlay.show { opacity: 1; visibility: visible; }

        main { flex: 1; padding-top: 100px; padding-bottom: 2rem; }
        .alert-fixed { position: fixed; top: 80px; right: 30px; z-index: 9999; min-width: 320px; max-width: 400px; background: #ffffff; color: #2d3748; border-left: 4px solid var(--brand-success); border-radius: 8px; padding: 0.9rem 1.2rem; font-weight: 500; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15); display: flex; align-items: center; gap: 10px; }
        .alert-fixed.alert-error { border-left-color: #dc3545; }

        footer { background: #2d3748; color: #e2e8f0; text-align: center; padding: 1.5rem 0; margin-top: auto; }
        .transaksi-badge { position: absolute; top: -8px; right: -8px; background: linear-gradient(135deg, #dc2626, #b91c1c); color: white; font-size: 0.7rem; font-weight: 700; padding: 2px 6px; border-radius: 10px; min-width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; }

        @media (max-width: 992px) {
            .navbar-toggler { display: flex; }
            .nav-link-custom { display: none; }
            .account-dropdown { display: none; }
            main { padding-top: 90px; }
        }
    </style>
</head>

<body>

    {{-- NAVBAR --}}
    <div class="navbar-wrapper">
        <div class="navbar-top">
            <div class="container">
                <div class="d-flex align-items-center">
                    {{-- LOGO --}}
                    <a class="navbar-brand" href="{{ route('admin.kasir') }}">
                        <img src="{{ asset('logo/logo baru.jpeg') }}" alt="Logo Waroeng 86" class="logo-navbar">
                        <span>Waroeng 86</span>
                    </a>

                    {{-- MENU NAVIGASI --}}
                    <div class="icon-group ms-auto">
                        <button class="navbar-toggler" id="navbarToggler" type="button">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                                <i class="bi bi-people-fill me-2"></i>Kelola Kasir
                            </a>
                        </li>
                        <a href="{{ route('admin.kasir') }}" class="nav-link-custom {{ Request::routeIs('admin.kasir*') ? 'active-nav' : '' }}">
                            <i class="bi bi-calculator me-1"></i> Kasir
                        </a>
                        <a href="{{ route('admin.transaksi') }}" class="nav-link-custom {{ Request::routeIs('admin.transaksi*') ? 'active-nav' : '' }}">
                            <i class="bi bi-receipt me-1"></i> Transaksi
                            <span class="transaksi-badge" id="transaksiBadge" style="display: none;">0</span>
                        </a>
                        <a href="{{ route('admin.laporan') }}" class="nav-link-custom {{ Request::routeIs('admin.laporan*') ? 'active-nav' : '' }}">
                            <i class="bi bi-file-earmark-excel me-1"></i> Laporan
                        </a>

                        @if(Auth::check() && Auth::user()->isOwner())
                            <a href="{{ route('admin.produk') }}" class="nav-link-custom {{ Request::routeIs('admin.produk*') ? 'active-nav' : '' }}">
                                <i class="bi bi-box-seam me-1"></i> Kelola Produk
                            </a>
                        @endif

                        {{-- USER PROFILE --}}
                        <div class="account-dropdown">
                            <button class="icon-btn" id="adminAccountBtn">
                                <i class="bi bi-person-circle"></i>
                                <span>{{ Auth::user()->name ?? 'Pengelola' }}</span>
                            </button>
                            <div class="dropdown-menu-custom">
                                <div class="user-info">
                                    <div class="user-name">{{ Auth::user()->name ?? 'Pengelola' }}</div>
                                    <span class="user-role">{{ ucwords(str_replace('_', ' ', Auth::user()->role ?? 'admin')) }}</span>
                                </div>
                                <form action="{{ route('admin.logout') }}" method="POST" style="margin: 0;">
                                    @csrf
                                    <button type="submit" class="dropdown-item-custom text-danger">
                                        <i class="bi bi-box-arrow-right text-danger"></i>
                                        <span>Logout</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MOBILE MENU --}}
    <div class="navbar-offcanvas" id="navbarOffcanvas">
        <div class="navbar-offcanvas-header">
            <h5 class="navbar-offcanvas-title">Menu Pengelola</h5>
            <button class="offcanvas-close-btn" id="offcanvasCloseBtn">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div class="navbar-offcanvas-body">
            <div class="offcanvas-nav-links">
                <a href="{{ route('admin.kasir') }}" class="offcanvas-nav-link {{ Request::routeIs('admin.kasir*') ? 'active' : '' }}">
                    <span>Kasir</span>
                </a>
                <a href="{{ route('admin.transaksi') }}" class="offcanvas-nav-link {{ Request::routeIs('admin.transaksi*') ? 'active' : '' }}">
                    <span>Transaksi</span>
                </a>
                <a href="{{ route('admin.laporan') }}" class="offcanvas-nav-link {{ Request::routeIs('admin.laporan*') ? 'active' : '' }}">
                    <span>Laporan</span>
                </a>

                @if(Auth::check() && Auth::user()->isOwner())
                    <a href="{{ route('admin.produk') }}" class="offcanvas-nav-link {{ Request::routeIs('admin.produk*') ? 'active' : '' }}">
                        <span>Kelola Produk</span>
                    </a>
                @endif
            </div>

            <form action="{{ route('admin.logout') }}" method="POST" style="margin-top: 1rem;">
                @csrf
                <button type="submit" class="offcanvas-btn-logout">Logout</button>
            </form>
        </div>
    </div>

    <div class="navbar-overlay" id="navbarOverlay"></div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const alertBox = document.querySelector('.alert-fixed');
        if (alertBox) {
            // Menunggu 2 detik sebelum mulai menghilang
            setTimeout(() => {
                alertBox.style.transition = 'all 0.4s ease';
                alertBox.style.opacity = '0';
                alertBox.style.transform = 'translateX(60px)';

                // Hapus elemen dari halaman setelah animasi selesai
                setTimeout(() => alertBox.remove(), 400);
            }, 2000); // 2000 ms = 2 detik
        }
    });
</script>
    {{-- MAIN CONTENT --}}
    <main>
        @if(session('success'))
            <div class="alert-fixed">
                <i class="bi bi-check-circle-fill text-success"></i>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        @if(session('error'))
            <div class="alert-fixed alert-error">
                <i class="bi bi-x-circle-fill text-danger"></i>
                <div>{{ session('error') }}</div>
            </div>
        @endif

        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer>
        <div class="container">
            <div class="footer-copyright">
                &copy; {{ date('Y') }} <strong>Waroeng 86</strong>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const adminAccountBtn = document.getElementById('adminAccountBtn');
        const adminDropdown = adminAccountBtn?.closest('.account-dropdown');

        if (adminAccountBtn && adminDropdown) {
            adminAccountBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                adminDropdown.classList.toggle('show');
            });
            document.addEventListener('click', (e) => {
                if (!adminDropdown.contains(e.target)) adminDropdown.classList.remove('show');
            });
        }

        const navbarToggler = document.getElementById('navbarToggler');
        const navbarOffcanvas = document.getElementById('navbarOffcanvas');
        const navbarOverlay = document.getElementById('navbarOverlay');
        const offcanvasCloseBtn = document.getElementById('offcanvasCloseBtn');

        if (navbarToggler && navbarOffcanvas && navbarOverlay && offcanvasCloseBtn) {
            navbarToggler.addEventListener('click', () => {
                navbarOffcanvas.classList.add('show');
                navbarOverlay.classList.add('show');
            });
            offcanvasCloseBtn.addEventListener('click', () => {
                navbarOffcanvas.classList.remove('show');
                navbarOverlay.classList.remove('show');
            });
            navbarOverlay.addEventListener('click', () => {
                navbarOffcanvas.classList.remove('show');
                navbarOverlay.classList.remove('show');
            });
        }
    </script>
    @stack('scripts')
</body>
</html>
