<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Waroeng 86</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://code.jquery.com https://maps.googleapis.com https://maps.gstatic.com; style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com https://cdn.jsdelivr.net; img-src 'self' data: https: blob:; connect-src 'self' https://maps.googleapis.com; frame-src https://www.google.com;">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">
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
            --bs-btn-active-bg: var(--brand-success-dark);
            --bs-btn-active-border-color: var(--brand-success-dark);
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
            padding-top: 0;
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
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--brand-success);
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }
        .navbar-brand:hover { color: var(--brand-success-dark); }
        .logo-navbar { width: 40px; height: 40px; object-fit: contain; border-radius: 6px; }

        .search-wrapper { flex: 1; max-width: 600px; margin: 0 2rem; }
        .search-form { position: relative; width: 100%; }
        .search-input {
            width: 100%;
            padding: 0.75rem 3rem 0.75rem 1rem;
            border: 2px solid #e5e7e9;
            border-radius: 8px;
            font-size: 0.9rem;
        }
        .search-btn {
            position: absolute;
            right: 0;
            top: 0;
            height: 100%;
            padding: 0 1.2rem;
            background: var(--brand-success);
            color: white;
            border: none;
            border-radius: 0 8px 8px 0;
            cursor: pointer;
        }

        .auth-buttons { display: flex; gap: 0.75rem; align-items: center; }
        .btn-masuk {
            padding: 0.6rem 1.5rem;
            border: 2px solid var(--brand-success);
            color: var(--brand-success);
            background: white;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
        }
        .btn-daftar {
            padding: 0.6rem 1.5rem;
            background: var(--brand-success);
            color: white;
            border: 2px solid var(--brand-success);
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
        }

        .icon-group { display: flex; gap: 1rem; align-items: center; }
        .navbar-toggler { display: none; border: none; background: transparent; width: 40px; height: 40px; border-radius: 8px; align-items: center; justify-content: center; }
        .navbar-toggler-icon { display: block; width: 24px; height: 2px; background: #4b5563; position: relative; border-radius: 2px; }
        .navbar-toggler-icon::before, .navbar-toggler-icon::after { content: ''; position: absolute; left: 0; width: 24px; height: 2px; background: #4b5563; border-radius: 2px; }
        .navbar-toggler-icon::before { top: -8px; }
        .navbar-toggler-icon::after { top: 8px; }

        .navbar-offcanvas {
            position: fixed;
            top: 0;
            right: -100%;
            width: 280px;
            height: 100vh;
            background: #ffffff;
            box-shadow: -5px 0 15px rgba(0, 0, 0, 0.1);
            z-index: 9999;
            transition: right 0.3s ease;
            overflow-y: auto;
            padding: 1rem;
        }
        .navbar-offcanvas.show { right: 0; }
        .navbar-offcanvas-header { display: flex; justify-content: space-between; align-items: center; padding: 1rem; border-bottom: 1px solid #e5e7e9; margin-bottom: 1rem; }
        .navbar-offcanvas-title { font-size: 1.2rem; font-weight: 700; color: var(--brand-success); margin: 0; }
        .offcanvas-close-btn { background: transparent; border: none; font-size: 1.5rem; color: #6b7280; cursor: pointer; }
        .offcanvas-nav-links { display: flex; flex-direction: column; gap: 0.5rem; margin-bottom: 1.5rem; }
        .offcanvas-nav-link { display: flex; align-items: center; gap: 0.75rem; padding: 0.85rem 1rem; color: #4b5563; border-radius: 8px; text-decoration: none; font-size: 0.95rem; font-weight: 500; }
        .offcanvas-nav-link.active { background: var(--brand-success); color: white; font-weight: 600; }
        .offcanvas-divider { height: 1px; background: #e5e7e9; margin: 1rem 0; }
        .offcanvas-auth-section { padding: 1rem; background: #f8f9fa; border-radius: 8px; margin-bottom: 1rem; }
        .offcanvas-user-info { display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem; }
        .offcanvas-user-avatar { width: 48px; height: 48px; border-radius: 50%; background: linear-gradient(135deg, var(--brand-success) 0%, var(--brand-success-dark) 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 1.2rem; }
        .offcanvas-user-name { font-weight: 600; color: #1f2937; font-size: 0.95rem; }
        .offcanvas-user-role { font-size: 0.75rem; color: #6b7280; text-transform: uppercase; background: #e5e7e9; padding: 2px 8px; border-radius: 10px; display: inline-block; font-weight: 600; }
        .offcanvas-btn { padding: 0.75rem 1.5rem; border-radius: 8px; font-weight: 600; font-size: 0.9rem; text-decoration: none; text-align: center; border: 2px solid; }
        .offcanvas-btn-login { border-color: var(--brand-success); color: var(--brand-success); background: white; }
        .offcanvas-btn-register { background: var(--brand-success); color: white; border-color: var(--brand-success); }
        .offcanvas-btn-logout { width: 100%; background: transparent; color: #dc2626; border: 2px solid #dc2626; }

        .navbar-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 9998; opacity: 0; visibility: hidden; transition: all 0.3s ease; }
        .navbar-overlay.show { opacity: 1; visibility: visible; }

        .icon-btn { display: flex; align-items: center; gap: 0.5rem; padding: 0.6rem 1rem; background: transparent; color: #6b7280; border: none; border-radius: 8px; cursor: pointer; text-decoration: none; font-size: 0.9rem; }
        .icon-btn i { font-size: 1.3rem; }
        .icon-btn:hover { background: #f3f4f6; color: var(--brand-success); }
        .icon-btn.active-nav { background: var(--brand-success); color: white; }
        .nav-link-custom { display: flex; align-items: center; padding: 0.6rem 1.2rem; background: transparent; color: #4b5563; border-radius: 8px; text-decoration: none; font-size: 0.9rem; font-weight: 500; white-space: nowrap; }
        .nav-link-custom:hover { background: #f3f4f6; color: var(--brand-success); }
        .nav-link-custom.active-nav { background: var(--brand-success); color: white; font-weight: 600; }

        .badge-cart { position: absolute; top: -2px; right: -2px; background: #e53e3e; color: #fff; font-size: 0.65rem; font-weight: 700; padding: 0.2rem 0.4rem; border-radius: 10px; min-width: 18px; text-align: center; border: 2px solid #ffffff; }

        .account-dropdown { position: relative; }
        .dropdown-menu-custom { position: absolute; top: 120%; right: 0; min-width: 240px; background: #ffffff; border: 1px solid #e5e7e9; border-radius: 12px; padding: 12px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15); opacity: 0; visibility: hidden; transform: translateY(-10px); transition: all 0.3s ease; z-index: 1000; }
        .account-dropdown.show .dropdown-menu-custom { opacity: 1; visibility: visible; transform: translateY(0); }
        .user-info { padding: 12px; border-bottom: 1px solid #e5e7e9; margin-bottom: 8px; background: #f9fafb; border-radius: 8px; }
        .user-name { font-weight: 600; color: #1f2937; font-size: 0.95rem; }
        .user-role { font-size: 0.7rem; color: #6b7280; text-transform: uppercase; background: #e5e7e9; padding: 2px 8px; border-radius: 10px; display: inline-block; font-weight: 600; }
        .dropdown-item-custom { display: flex; align-items: center; gap: 10px; padding: 10px 12px; color: #4b5563; text-decoration: none; border-radius: 8px; margin: 4px 0; background: transparent; border: none; width: 100%; text-align: left; cursor: pointer; font-size: 0.85rem; }
        .dropdown-item-custom:hover { background: #f3f4f6; color: var(--brand-success); }
        .dropdown-divider-custom { height: 1px; background: #e5e7e9; margin: 8px 0; }

        main { flex: 1; padding-top: 140px; }
        body:has(.running-text-wrapper) main { padding-top: 120px; }

        .running-text-wrapper { position: fixed; top: 72px; left: 0; right: 0; width: 100%; background: linear-gradient(135deg, var(--brand-success) 0%, var(--brand-success-dark) 100%); padding: 0.5rem 0; box-shadow: 0 2px 8px rgba(var(--brand-success-rgb), 0.2); overflow: hidden; z-index: 999; }
        .running-text-container { display: flex; align-items: center; gap: 0.8rem; }
        .running-text-container > i { font-size: 1.1rem; color: #ffffff; }
        .running-text-content { flex: 1; overflow: hidden; position: relative; }
        .running-text { display: flex; gap: 2.5rem; animation: scroll 30s linear infinite; white-space: nowrap; }
        .running-text span { color: #ffffff; font-weight: 500; font-size: 0.85rem; display: inline-block; }
        @keyframes scroll { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }

        footer { background: #2d3748; color: #e2e8f0; text-align: center; padding: 1.5rem 0; margin-top: auto; }
        footer .container { max-width: 1200px; margin: 0 auto; padding: 0 15px; }
        footer .footer-copyright { font-size: 0.85rem; color: #a0aec0; margin: 0; }
        footer .footer-copyright strong { color: #ffffff; font-weight: 500; }

        .alert-fixed { position: fixed; top: 80px; right: 30px; z-index: 9999; min-width: 320px; max-width: 400px; background: #ffffff; color: #2d3748; border-left: 4px solid var(--brand-success); border-radius: 8px; padding: 0.9rem 1.2rem; font-weight: 500; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15); display: flex; align-items: center; gap: 10px; }

        @media (max-width: 992px) {
            .navbar-top .container > .d-flex { display: flex; justify-content: space-between; align-items: center; width: 100%; flex-wrap: wrap; }
            .navbar-brand { order: 1; margin-right: 0; }
            .icon-group { order: 2; margin-left: auto; display: flex; gap: 0.75rem; align-items: center; }
            .icon-group > .icon-btn { order: 1; }
            .navbar-toggler { order: 2; display: flex; align-items: center; justify-content: center; }
            .search-wrapper { display: none !important; }
            .nav-link-custom { display: none; }
            .auth-buttons { display: none; }
            .account-dropdown { display: none; }
            main { padding-top: 130px; }
            body:has(.running-text-wrapper) main { padding-top: 170px; }
            .running-text-wrapper { top: 73px; }
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
                    <a class="navbar-brand" href="{{ route('home') }}">
                        <img src="{{ asset('logo/logo baru.jpeg') }}" alt="Logo Waroeng 86" class="logo-navbar">
                        <span>Waroeng 86</span>
                    </a>

                    {{-- SEARCH BAR --}}
                    @if(Request::routeIs('produk.*'))
                        <div class="search-wrapper">
                            <form class="search-form" id="searchForm">
                                <input type="text" class="search-input" name="search" id="searchInput" placeholder="Cari produk di Waroeng 86..." value="{{ request('search') }}">
                                <button type="submit" class="search-btn">
                                    <i class="bi bi-search"></i>
                                </button>
                            </form>
                        </div>
                    @endif

                    {{-- AUTH BUTTONS / USER MENU --}}
                    <div class="icon-group ms-auto">
                        <button class="navbar-toggler" id="navbarToggler" type="button">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <a href="{{ route('home') }}" class="nav-link-custom {{ Request::routeIs('home') ? 'active-nav' : '' }}">Home</a>
                        


                        {{-- AUTH SECTION --}}
                        @auth
                            <div class="account-dropdown">
                                <button class="icon-btn" id="accountBtn">
                                    <i class="bi bi-person-circle"></i>
                                    <span>{{ Auth::user()->name }}</span>
                                </button>
                                <div class="dropdown-menu-custom">
                                    <div class="user-info">
                                        <div class="user-name">{{ Auth::user()->name }}</div>
                                        <span class="user-role">{{ ucwords(str_replace('_', ' ', Auth::user()->role)) }}</span>
                                    </div>

                                    @if(Auth::user()->isAdminOrOwner())
                                        <a href="{{ route('admin.kasir') }}" class="dropdown-item-custom">
                                            <i class="bi bi-calculator"></i>
                                            <span>Panel Kasir</span>
                                        </a>
                                    @endif

                                    <div class="dropdown-divider-custom"></div>
                                    <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                                        @csrf
                                        <button type="submit" class="dropdown-item-custom">
                                            <i class="bi bi-box-arrow-right"></i>
                                            <span>Logout</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <div class="auth-buttons">
                                <a href="{{ route('login') }}" class="btn-masuk">Login</a>
                                <a href="{{ route('register') }}" class="btn-daftar">Daftar</a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MOBILE OFFCANVAS --}}
    <div class="navbar-offcanvas" id="navbarOffcanvas">
        <div class="navbar-offcanvas-header">
            <h5 class="navbar-offcanvas-title">Menu</h5>
            <button class="offcanvas-close-btn" id="offcanvasCloseBtn">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div class="navbar-offcanvas-body">
            <div class="offcanvas-nav-links">
                <a href="{{ route('home') }}" class="offcanvas-nav-link {{ Request::routeIs('home') ? 'active' : '' }}"><span>Home</span></a>

            </div>

            <div class="offcanvas-divider"></div>

            @auth
                <div class="offcanvas-auth-section">
                    <div class="offcanvas-user-info">
                        <div class="offcanvas-user-avatar">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div class="offcanvas-user-details">
                            <div class="offcanvas-user-name">{{ Auth::user()->name }}</div>
                            <span class="offcanvas-user-role">{{ ucwords(str_replace('_', ' ', Auth::user()->role)) }}</span>
                        </div>
                    </div>

                    @if(Auth::user()->isAdminOrOwner())
                        <a href="{{ route('admin.kasir') }}" class="offcanvas-nav-link">
                            <i class="bi bi-calculator"></i>
                            <span>Panel Kasir</span>
                        </a>
                    @endif

                    <form action="{{ route('logout') }}" method="POST" style="margin-top: 0.5rem;">
                        @csrf
                        <button type="submit" class="offcanvas-btn offcanvas-btn-logout">
                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                        </button>
                    </form>
                </div>
            @else
                <div class="offcanvas-auth-section">
                    <div class="offcanvas-auth-buttons">
                        <a href="{{ route('login') }}" class="offcanvas-btn offcanvas-btn-login">Login</a>
                        <a href="{{ route('register') }}" class="offcanvas-btn offcanvas-btn-register">Daftar</a>
                    </div>
                </div>
            @endauth
        </div>
    </div>

    <div class="navbar-overlay" id="navbarOverlay"></div>

    {{-- RUNNING TEXT --}}
    @if(Request::routeIs('home'))
        <div class="running-text-wrapper">
            <div class="container">
                <div class="running-text-container">
                    <i class="bi bi-megaphone-fill"></i>
                    <div class="running-text-content">
                        <div class="running-text">
                            <span>Selamat Datang di Aplikasi Waroeng 86</span>
                            <span>Selamat Dan Semangat Kerjanya!!!!</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- MAIN CONTENT --}}
    <main>
        @if(session('success'))
            <div class="alert-fixed">
                <i class="bi bi-check-circle-fill"></i>
                <div class="alert-fixed-text">{{ session('success') }}</div>
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
        const accountBtn = document.getElementById('accountBtn');
        const accountDropdown = accountBtn?.closest('.account-dropdown');

        if (accountBtn && accountDropdown) {
            accountBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                accountDropdown.classList.toggle('show');
            });
            document.addEventListener('click', (e) => {
                if (!accountDropdown.contains(e.target)) accountDropdown.classList.remove('show');
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
