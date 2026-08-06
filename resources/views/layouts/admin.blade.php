<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin - Warung Sembako CPM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net; style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com https://cdn.jsdelivr.net; img-src 'self' data: https:; connect-src 'self';">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

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

        html {
            overflow-x: hidden;
        }

        /* NAVBAR - TOKOPEDIA STYLE */
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

        /* NAVBAR TOP - Logo, Menu, Auth */
        .navbar-top {
            padding: 1rem 0;
            border-bottom: 1px solid #e5e7e9;
        }

        .navbar-brand {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1.5rem;
            color: #03AC0E;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .navbar-brand:hover {
            color: #028A0F;
        }

        .logo-navbar {
            width: 40px;
            height: 40px;
            object-fit: contain;
            border-radius: 6px;
        }

        /* HAMBURGER MENU BUTTON */
        .navbar-toggler {
            display: none;
            border: none;
            background: transparent;
            padding: 0;
            cursor: pointer;
            position: relative;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            transition: all 0.3s ease;
            align-items: center;
            justify-content: center;
        }

        .navbar-toggler:hover {
            background: #f3f4f6;
        }

        .navbar-toggler-icon {
            display: block;
            width: 24px;
            height: 2px;
            background: #4b5563;
            position: relative;
            transition: all 0.3s ease;
            border-radius: 2px;
        }

        .navbar-toggler-icon::before,
        .navbar-toggler-icon::after {
            content: '';
            position: absolute;
            left: 0;
            width: 24px;
            height: 2px;
            background: #4b5563;
            transition: all 0.3s ease;
            border-radius: 2px;
        }

        .navbar-toggler-icon::before {
            top: -8px;
        }

        .navbar-toggler-icon::after {
            top: 8px;
        }

        .navbar-toggler.active .navbar-toggler-icon {
            background: transparent;
        }

        .navbar-toggler.active .navbar-toggler-icon::before {
            top: 0;
            transform: rotate(45deg);
            background: #03AC0E;
        }

        .navbar-toggler.active .navbar-toggler-icon::after {
            top: 0;
            transform: rotate(-45deg);
            background: #03AC0E;
        }

        /* MOBILE OFFCANVAS MENU */
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

        .navbar-offcanvas.show {
            right: 0;
        }

        .navbar-offcanvas-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            border-bottom: 1px solid #e5e7e9;
            margin-bottom: 1rem;
        }

        .navbar-offcanvas-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: #03AC0E;
            margin: 0;
        }

        .offcanvas-close-btn {
            background: transparent;
            border: none;
            font-size: 1.5rem;
            color: #6b7280;
            cursor: pointer;
            padding: 0.25rem;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .offcanvas-close-btn:hover {
            background: #f3f4f6;
            color: #03AC0E;
        }

        .navbar-offcanvas-body {
            padding: 0 1rem;
        }

        .offcanvas-nav-links {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .offcanvas-nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.85rem 1rem;
            background: transparent;
            color: #4b5563;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
        }

        .offcanvas-nav-link:hover {
            background: #f3f4f6;
            color: #03AC0E;
        }

        .offcanvas-nav-link.active {
            background: #03AC0E;
            color: white;
            font-weight: 600;
        }

        .offcanvas-divider {
            height: 1px;
            background: #e5e7e9;
            margin: 1rem 0;
        }

        .offcanvas-auth-section {
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .offcanvas-user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .offcanvas-user-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, #03AC0E 0%, #028A0F 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.2rem;
        }

        .offcanvas-user-details {
            flex: 1;
        }

        .offcanvas-user-name {
            font-weight: 600;
            color: #1f2937;
            font-size: 0.95rem;
            margin-bottom: 0.25rem;
        }

        .offcanvas-user-role {
            font-size: 0.75rem;
            color: #6b7280;
            text-transform: uppercase;
            background: #e5e7e9;
            padding: 2px 8px;
            border-radius: 10px;
            display: inline-block;
            font-weight: 600;
        }

        .offcanvas-btn-logout {
            width: 100%;
            background: transparent;
            color: #dc2626;
            border: 2px solid #dc2626;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s ease;
        }

        .offcanvas-btn-logout:hover {
            background: #fef2f2;
        }

        /* OVERLAY */
        .navbar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 9998;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .navbar-overlay.show {
            opacity: 1;
            visibility: visible;
        }

        /* NAVIGATION MENU */
        .icon-group {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .nav-link-custom {
            display: flex;
            align-items: center;
            padding: 0.6rem 1.2rem;
            background: transparent;
            color: #4b5563;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            white-space: nowrap;
            position: relative;
        }

        .nav-link-custom:hover {
            background: #f3f4f6;
            color: #03AC0E;
        }

        .nav-link-custom.active-nav {
            background: #03AC0E;
            color: white;
            font-weight: 600;
        }

        .nav-link-custom.active-nav:hover {
            background: #028A0F;
            color: white;
        }

        /* ACCOUNT DROPDOWN */
        .account-dropdown {
            position: relative;
        }

        .icon-btn {
            position: relative;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1rem;
            background: transparent;
            color: #6b7280;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .icon-btn i {
            font-size: 1.3rem;
        }

        .icon-btn:hover {
            background: #f3f4f6;
            color: #03AC0E;
        }

        .dropdown-menu-custom {
            position: absolute;
            top: 120%;
            right: 0;
            min-width: 240px;
            background: #ffffff;
            border: 1px solid #e5e7e9;
            border-radius: 12px;
            padding: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .account-dropdown.show .dropdown-menu-custom {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .user-info {
            padding: 12px;
            border-bottom: 1px solid #e5e7e9;
            margin-bottom: 8px;
            background: #f9fafb;
            border-radius: 8px;
        }

        .user-name {
            font-weight: 600;
            color: #1f2937;
            font-size: 0.95rem;
            margin-bottom: 4px;
        }

        .user-role {
            font-size: 0.7rem;
            color: #6b7280;
            text-transform: uppercase;
            background: #e5e7e9;
            padding: 2px 8px;
            border-radius: 10px;
            display: inline-block;
            font-weight: 600;
        }

        .dropdown-item-custom {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            color: #4b5563;
            text-decoration: none;
            border-radius: 8px;
            margin: 4px 0;
            transition: all 0.3s ease;
            background: transparent;
            border: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
            font-size: 0.85rem;
        }

        .dropdown-item-custom i {
            font-size: 1rem;
            color: #6b7280;
        }

        .dropdown-item-custom:hover {
            background: #f3f4f6;
            color: #03AC0E;
        }

        /* MAIN CONTENT */
        main {
            flex: 1;
            padding-top: 100px;
            padding-bottom: 2rem;
        }

        /* ALERT NOTIFICATION */
        .alert-fixed {
            position: fixed;
            top: 80px;
            right: 30px;
            z-index: 9999;
            min-width: 320px;
            max-width: 400px;
            background: #ffffff;
            color: #2d3748;
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-left: 4px solid #03AC0E;
            border-radius: 8px;
            padding: 0.9rem 1.2rem;
            font-weight: 500;
            font-size: 0.9rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            animation: slideInRight 0.4s ease-out;
            display: flex;
            align-items: center;
            gap: 10px;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .alert-fixed i {
            font-size: 1.25rem;
            color: #03AC0E;
            flex-shrink: 0;
        }

        .alert-fixed-text {
            flex: 1;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .alert-fixed.alert-error {
            border-left-color: #dc3545;
        }

        .alert-fixed.alert-error i {
            color: #dc3545;
        }

        @keyframes slideInRight {
            from { 
                opacity: 0; 
                transform: translateX(100px);
            }
            to { 
                opacity: 1; 
                transform: translateX(0);
            }
        }

        /* FOOTER */
        footer {
            background: #2d3748;
            color: #e2e8f0;
            text-align: center;
            padding: 1.5rem 0;
            margin-top: auto;
        }

        footer .footer-copyright {
            font-size: 0.85rem;
            color: #a0aec0;
            margin: 0;
        }

        footer .footer-copyright strong {
            color: #ffffff;
            font-weight: 500;
        }

        /* ===== DARK MODE STYLES ===== */
        body.dark-mode {
            background: #1a1a2e;
            color: #e5e7eb;
        }

        body.dark-mode .navbar-wrapper {
            background: #16213e;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.5);
        }

        body.dark-mode .navbar-top {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        body.dark-mode .nav-link-custom {
            color: #cbd5e0;
        }

        body.dark-mode .nav-link-custom:hover {
            background: rgba(3, 172, 14, 0.1);
            color: #03AC0E;
        }

        body.dark-mode .icon-btn {
            color: #cbd5e0;
        }

        body.dark-mode .icon-btn:hover {
            background: rgba(3, 172, 14, 0.1);
            color: #03AC0E;
        }

        body.dark-mode .dropdown-menu-custom {
            background: #16213e;
            border-color: rgba(255, 255, 255, 0.1);
        }

        body.dark-mode .user-info {
            background: rgba(3, 172, 14, 0.1);
        }

        body.dark-mode .user-name {
            color: #e5e7eb;
        }

        body.dark-mode .user-role {
            background: rgba(3, 172, 14, 0.2);
            color: #03AC0E;
        }

        body.dark-mode .dropdown-item-custom {
            color: #cbd5e0;
        }

        body.dark-mode .dropdown-item-custom:hover {
            background: rgba(3, 172, 14, 0.1);
            color: #03AC0E;
        }

        body.dark-mode footer {
            background: #0f1419;
        }

        body.dark-mode .navbar-toggler:hover {
            background: rgba(3, 172, 14, 0.1);
        }

        body.dark-mode .navbar-toggler-icon,
        body.dark-mode .navbar-toggler-icon::before,
        body.dark-mode .navbar-toggler-icon::after {
            background: #cbd5e0;
        }

        body.dark-mode .navbar-offcanvas {
            background: #16213e;
        }

        body.dark-mode .navbar-offcanvas-header {
            border-bottom-color: rgba(255, 255, 255, 0.1);
        }

        body.dark-mode .offcanvas-close-btn {
            color: #cbd5e0;
        }

        body.dark-mode .offcanvas-close-btn:hover {
            background: rgba(3, 172, 14, 0.1);
            color: #03AC0E;
        }

        body.dark-mode .offcanvas-nav-link {
            color: #cbd5e0;
        }

        body.dark-mode .offcanvas-nav-link:hover {
            background: rgba(3, 172, 14, 0.1);
            color: #03AC0E;
        }

        body.dark-mode .offcanvas-divider {
            background: rgba(255, 255, 255, 0.1);
        }

        body.dark-mode .offcanvas-auth-section {
            background: rgba(3, 172, 14, 0.05);
        }

        body.dark-mode .offcanvas-user-name {
            color: #e5e7eb;
        }

        body.dark-mode .offcanvas-user-role {
            background: rgba(3, 172, 14, 0.2);
            color: #03AC0E;
        }

        /* MOBILE RESPONSIVE */
        @media (max-width: 992px) {
            .navbar-top .container > .d-flex {
                display: flex;
                justify-content: space-between;
                align-items: center;
                width: 100%;
            }

            /* Logo di kiri */
            .navbar-brand {
                order: 1;
            }

            /* Icon group di kanan (hamburger) */
            .icon-group {
                order: 2;
                margin-left: auto;
            }

            /* Show hamburger button */
            .navbar-toggler {
                display: flex;
            }

            /* Hide desktop navigation menu */
            .nav-link-custom {
                display: none;
            }

            /* Hide account dropdown */
            .account-dropdown {
                display: none;
            }

            .alert-fixed {
                right: 15px;
                left: 15px;
                min-width: auto;
                top: 80px;
            }

            main {
                padding-top: 90px;
            }
        }

        @media (max-width: 768px) {
            .navbar-top {
                padding: 0.7rem 0;
            }

            .navbar-brand {
                font-size: 1.35rem;
            }

            .logo-navbar {
                width: 38px;
                height: 38px;
            }

            .navbar-toggler {
                width: 40px;
                height: 40px;
            }

            .navbar-toggler-icon {
                width: 22px;
            }

            .navbar-toggler-icon::before,
            .navbar-toggler-icon::after {
                width: 22px;
            }

            main {
                padding-top: 80px;
            }

            .alert-fixed {
                top: 75px;
            }
        }

        @media (max-width: 576px) {
            .navbar-top {
                padding: 0.65rem 0;
            }

            .navbar-brand {
                font-size: 1.25rem;
            }

            .logo-navbar {
                width: 35px;
                height: 35px;
            }

            .navbar-toggler {
                width: 38px;
                height: 38px;
            }

            .navbar-toggler-icon {
                width: 20px;
            }

            .navbar-toggler-icon::before,
            .navbar-toggler-icon::after {
                width: 20px;
            }

            main {
                padding-top: 75px;
            }

            /* Notifikasi Mobile - Lebih Pendek & Compact */
            .alert-fixed {
                top: 70px;
                right: 8px;
                left: 8px;
                padding: 0.55rem 0.75rem;
                font-size: 0.75rem;
                min-width: auto;
                max-width: none;
                gap: 6px;
                border-radius: 6px;
            }

            .alert-fixed i {
                font-size: 0.95rem;
            }

            .alert-fixed-text {
                -webkit-line-clamp: 1;
                font-size: 0.75rem;
                line-height: 1.3;
            }

            footer {
                padding: 1rem 0;
            }

            footer .footer-copyright {
                font-size: 0.75rem;
            }
        }

        @media (max-width: 400px) {
            .navbar-top {
                padding: 0.6rem 0;
            }

            .navbar-brand {
                font-size: 1.15rem;
            }

            .logo-navbar {
                width: 32px;
                height: 32px;
            }

            main {
                padding-top: 70px;
            }
        }

        /* Desktop - Hide hamburger, show desktop menu */
        @media (min-width: 993px) {
            .navbar-toggler {
                display: none !important;
            }

            .nav-link-custom {
                display: flex !important;
            }

            .account-dropdown {
                display: block !important;
            }
        }

        /* ===== BADGE NOTIFIKASI TRANSAKSI (SEPERTI KERANJANG) ===== */
        .transaksi-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            color: white;
            font-size: 0.7rem;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 10px;
            min-width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(220, 38, 38, 0.4);
            animation: badgePulse 2s ease-in-out infinite;
        }

        .offcanvas-nav-link {
            position: relative;
        }

        @keyframes badgePulse {
            0%, 100% {
                transform: scale(1);
                box-shadow: 0 2px 8px rgba(220, 38, 38, 0.4);
            }
            50% {
                transform: scale(1.1);
                box-shadow: 0 4px 12px rgba(220, 38, 38, 0.6);
            }
        }

        /* Badge di mobile offcanvas */
        .offcanvas-nav-link .transaksi-badge {
            position: static;
            margin-left: auto;
            top: auto;
            right: auto;
        }

        body.dark-mode .transaksi-badge {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            box-shadow: 0 2px 8px rgba(239, 68, 68, 0.5);
        }
    </style>
</head>

<body>

    {{-- NAVBAR - STYLE SAMA SEPERTI USER --}}
    <div class="navbar-wrapper">
        <div class="navbar-top">
            <div class="container">
                <div class="d-flex align-items-center">
                    {{-- LOGO --}}
                    <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                        <img src="{{ asset('logo/logo 2.png') }}" alt="Logo CPM" class="logo-navbar">
                        <span>CPM</span>
                    </a>

                    {{-- NAVIGATION MENU ADMIN --}}
                    <div class="icon-group ms-auto">
                        {{-- HAMBURGER MENU BUTTON (Mobile Only) --}}
                        <button class="navbar-toggler" id="navbarToggler" type="button">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <a href="{{ route('admin.dashboard') }}" class="nav-link-custom {{ Request::routeIs('admin.dashboard') ? 'active-nav' : '' }}">
                            Dashboard
                        </a>
                        <a href="{{ route('admin.produk') }}" class="nav-link-custom {{ Request::routeIs('admin.produk') ? 'active-nav' : '' }}">
                            Produk
                        </a>
                        <a href="{{ route('admin.pelanggan') }}" class="nav-link-custom {{ Request::routeIs('admin.pelanggan') ? 'active-nav' : '' }}">
                            Pelanggan
                        </a>
                        <a href="{{ route('admin.transaksi') }}" class="nav-link-custom {{ Request::routeIs('admin.transaksi') ? 'active-nav' : '' }}">
                            Transaksi
                            <span class="transaksi-badge" id="transaksiBadge" style="display: none;">0</span>
                        </a>

                        {{-- ACCOUNT DROPDOWN --}}
                        <div class="account-dropdown">
                            <button class="icon-btn" id="adminAccountBtn">
                                <i class="bi bi-person-circle"></i>
                                <span>Admin</span>
                            </button>
                            <div class="dropdown-menu-custom">
                                <div class="user-info">
                                    <div class="user-name">Administrator</div>
                                    <span class="user-role">Admin Panel</span>
                                </div>
                                <form action="{{ route('admin.logout') }}" method="POST" style="margin: 0;">
                                    @csrf
                                    <button type="submit" class="dropdown-item-custom">
                                        <i class="bi bi-box-arrow-right"></i>
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

    {{-- MOBILE OFFCANVAS MENU --}}
    <div class="navbar-offcanvas" id="navbarOffcanvas">
        <div class="navbar-offcanvas-header">
            <h5 class="navbar-offcanvas-title">Menu Admin</h5>
            <button class="offcanvas-close-btn" id="offcanvasCloseBtn">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div class="navbar-offcanvas-body">
            {{-- Navigation Links --}}
            <div class="offcanvas-nav-links">
                <a href="{{ route('admin.dashboard') }}" class="offcanvas-nav-link {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.produk') }}" class="offcanvas-nav-link {{ Request::routeIs('admin.produk') ? 'active' : '' }}">
                    <span>Produk</span>
                </a>
                <a href="{{ route('admin.pelanggan') }}" class="offcanvas-nav-link {{ Request::routeIs('admin.pelanggan') ? 'active' : '' }}">
                    <span>Pelanggan</span>
                </a>
                <a href="{{ route('admin.transaksi') }}" class="offcanvas-nav-link {{ Request::routeIs('admin.transaksi') ? 'active' : '' }}">
                    <span>Transaksi</span>
                    <span class="transaksi-badge" id="transaksiBadgeMobile" style="display: none;">0</span>
                </a>
            </div>

            <div class="offcanvas-divider"></div>

            {{-- Auth Section --}}
            <div class="offcanvas-auth-section">
                <div class="offcanvas-user-info">
                    <div class="offcanvas-user-avatar">
                        A
                    </div>
                    <div class="offcanvas-user-details">
                        <div class="offcanvas-user-name">Administrator</div>
                        <span class="offcanvas-user-role">Admin Panel</span>
                    </div>
                </div>
                <form action="{{ route('admin.logout') }}" method="POST" style="margin-top: 0.5rem;">
                    @csrf
                    <button type="submit" class="offcanvas-btn-logout">
                        <i class="bi bi-box-arrow-right me-2"></i>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- OVERLAY --}}
    <div class="navbar-overlay" id="navbarOverlay"></div>

    {{-- MAIN CONTENT --}}
    <main>
        {{-- FLASH MESSAGE --}}
        @if(session('success'))
            <div class="alert-fixed">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert-fixed alert-error">
                <i class="bi bi-x-circle-fill"></i>
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer>
        <div class="container">
            <div class="footer-copyright">
                &copy; {{ date('Y') }} <strong>Warung Sembako Cahaya Putri Maulana (CPM)</strong> 
            </div>
        </div>
    </footer>

    {{-- SCRIPTS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Account Dropdown Toggle
        const adminAccountBtn = document.getElementById('adminAccountBtn');
        const adminDropdown = adminAccountBtn?.closest('.account-dropdown');

        if (adminAccountBtn && adminDropdown) {
            adminAccountBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                adminDropdown.classList.toggle('show');
            });

            document.addEventListener('click', function(e) {
                if (!adminDropdown.contains(e.target)) {
                    adminDropdown.classList.remove('show');
                }
            });
        }

        // Auto hide alert
        const alertFixed = document.querySelector('.alert-fixed');
        if (alertFixed) {
            setTimeout(() => {
                alertFixed.style.animation = 'slideInRight 0.4s ease-out reverse';
                setTimeout(() => alertFixed.remove(), 400);
            }, 5000);
        }

        // Dark mode support
        function safeGetStorage(key, defaultValue) {
            try {
                return localStorage.getItem(key) || defaultValue;
            } catch (e) {
                return defaultValue;
            }
        }

        const savedTheme = safeGetStorage('theme', 'light');
        if (savedTheme === 'dark') {
            document.body.classList.add('dark-mode');
        }

        // Navbar Offcanvas Toggle
        const navbarToggler = document.getElementById('navbarToggler');
        const navbarOffcanvas = document.getElementById('navbarOffcanvas');
        const navbarOverlay = document.getElementById('navbarOverlay');
        const offcanvasCloseBtn = document.getElementById('offcanvasCloseBtn');

        if (navbarToggler && navbarOffcanvas && navbarOverlay && offcanvasCloseBtn) {
            navbarToggler.addEventListener('click', function() {
                navbarOffcanvas.classList.add('show');
                navbarOverlay.classList.add('show');
            });

            offcanvasCloseBtn.addEventListener('click', function() {
                navbarOffcanvas.classList.remove('show');
                navbarOverlay.classList.remove('show');
            });

            navbarOverlay.addEventListener('click', function() {
                navbarOffcanvas.classList.remove('show');
                navbarOverlay.classList.remove('show');
            });
        }

        // ===== BADGE NOTIFIKASI TRANSAKSI PENDING ===== //
        function updateTransaksiBadge() {
            fetch("{{ route('admin.transaksi.checkNew') }}?last_check=2000-01-01T00:00:00Z")
                .then(response => response.json())
                .then(data => {
                    const badge = document.getElementById('transaksiBadge');
                    const badgeMobile = document.getElementById('transaksiBadgeMobile');
                    
                    // Hitung transaksi pending
                    const pendingCount = data.transactions ? data.transactions.filter(t => t.status === 'pending').length : 0;
                    
                    if (pendingCount > 0) {
                        // Tampilkan badge
                        if (badge) {
                            badge.textContent = pendingCount;
                            badge.style.display = 'flex';
                        }
                        if (badgeMobile) {
                            badgeMobile.textContent = pendingCount;
                            badgeMobile.style.display = 'flex';
                        }
                    } else {
                        // Sembunyikan badge
                        if (badge) badge.style.display = 'none';
                        if (badgeMobile) badgeMobile.style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error('Error updating badge:', error);
                });
        }

        // Update badge saat halaman dimuat
        updateTransaksiBadge();

        // Update badge setiap 10 detik
        setInterval(updateTransaksiBadge, 10000);
    </script>

    @stack('scripts')
</body>
</html>
