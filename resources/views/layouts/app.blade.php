<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Warung Sembako CPM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://code.jquery.com https://maps.googleapis.com https://maps.gstatic.com; style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com https://cdn.jsdelivr.net; img-src 'self' data: https: blob:; connect-src 'self' https://maps.googleapis.com; frame-src https://www.google.com;">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">
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

        /* NAVBAR TOP - Logo, Search, Auth */
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

        /* SEARCH BAR - Tokopedia Style */
        .search-wrapper {
            flex: 1;
            max-width: 600px;
            margin: 0 2rem;
        }

        .search-form {
            position: relative;
            width: 100%;
        }

        .search-input {
            width: 100%;
            padding: 0.75rem 3rem 0.75rem 1rem;
            border: 2px solid #e5e7e9;
            border-radius: 8px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: #03AC0E;
            box-shadow: 0 0 0 3px rgba(3, 172, 14, 0.1);
        }

        .search-btn {
            position: absolute;
            right: 0;
            top: 0;
            height: 100%;
            padding: 0 1.2rem;
            background: #03AC0E;
            color: white;
            border: none;
            border-radius: 0 8px 8px 0;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .search-btn:hover {
            background: #028A0F;
        }

        /* AUTH BUTTONS */
        .auth-buttons {
            display: flex;
            gap: 0.75rem;
            align-items: center;
        }

        .btn-masuk {
            padding: 0.6rem 1.5rem;
            border: 2px solid #03AC0E;
            color: #03AC0E;
            background: white;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .btn-masuk:hover {
            background: #f0fdf4;
            color: #028A0F;
            border-color: #028A0F;
        }

        .btn-daftar {
            padding: 0.6rem 1.5rem;
            background: #03AC0E;
            color: white;
            border: 2px solid #03AC0E;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .btn-daftar:hover {
            background: #028A0F;
            border-color: #028A0F;
            color: white;
        }

        /* CART & ACCOUNT ICONS */
        .icon-group {
            display: flex;
            gap: 1rem;
            align-items: center;
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
            display: flex;
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

        .offcanvas-nav-link i {
            display: none; /* Hide icons */
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

        .offcanvas-auth-buttons {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .offcanvas-btn {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s ease;
            border: 2px solid;
        }

        .offcanvas-btn-login {
            border-color: #03AC0E;
            color: #03AC0E;
            background: white;
        }

        .offcanvas-btn-login:hover {
            background: #f0fdf4;
        }

        .offcanvas-btn-register {
            background: #03AC0E;
            color: white;
            border-color: #03AC0E;
        }

        .offcanvas-btn-register:hover {
            background: #028A0F;
        }

        .offcanvas-btn-logout {
            width: 100%;
            background: transparent;
            color: #dc2626;
            border: 2px solid #dc2626;
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

        body.dark-mode .offcanvas-btn-login {
            background: transparent;
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

        .icon-btn.active-nav {
            background: #03AC0E;
            color: white;
        }

        .icon-btn.active-nav:hover {
            background: #028A0F;
            color: white;
        }

        /* USER NAME TRUNCATE */
        .user-name-truncate {
            max-width: 150px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: inline-block;
        }

        /* NAVIGATION LINK */
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

        .badge-cart {
            position: absolute;
            top: -2px;
            right: -2px;
            background: #e53e3e;
            color: #fff;
            font-size: 0.65rem;
            font-weight: 700;
            padding: 0.2rem 0.4rem;
            border-radius: 10px;
            min-width: 18px;
            text-align: center;
            border: 2px solid #ffffff;
        }

        /* ACCOUNT DROPDOWN */
        .account-dropdown {
            position: relative;
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

        .dropdown-divider-custom {
            height: 1px;
            background: #e5e7e9;
            margin: 8px 0;
        }

        /* MAIN CONTENT */
        main {
            flex: 1;
            padding-top: 140px; /* Space for fixed navbar */
        }

        /* Hilangkan padding top di main jika ada running text */
        body:has(.running-text-wrapper) main {
            padding-top: 120px; /* Space for navbar + running text */
        }

        /* RUNNING TEXT / INFO BERJALAN */
        .running-text-wrapper {
            position: fixed;
            top: 72px; /* Below navbar */
            left: 0;
            right: 0;
            width: 100%;
            background: linear-gradient(135deg, #03AC0E 0%, #02d115 100%);
            padding: 0.5rem 0;
            box-shadow: 0 2px 8px rgba(3, 172, 14, 0.2);
            overflow: hidden;
            margin-bottom: 0;
            z-index: 999;
        }

        .running-text-container {
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .running-text-container > i {
            font-size: 1.1rem;
            color: #ffffff;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.2); }
        }

        .running-text-content {
            flex: 1;
            overflow: hidden;
            position: relative;
        }

        .running-text {
            display: flex;
            gap: 2.5rem;
            animation: scroll 30s linear infinite;
            white-space: nowrap;
        }

        .running-text span {
            color: #ffffff;
            font-weight: 500;
            font-size: 0.85rem;
            display: inline-block;
        }

        @keyframes scroll {
            0% {
                transform: translateX(0);
            }
            100% {
                transform: translateX(-50%);
            }
        }

        .running-text::after {
            content: ' 🎉 Selamat Datang di Warung Sembako CPM! ⭐ Belanja hemat, harga terjangkau, kualitas terpercaya! 🛒 Stok lengkap, pelayanan ramah! 💰 Dapatkan promo menarik setiap harinya! 📱 Pesan online, praktis dan mudah!';
            color: #ffffff;
            font-weight: 500;
            font-size: 0.85rem;
            margin-left: 2.5rem;
        }

        /* FOOTER - CLEAN & SIMPLE */
        footer {
            background: #2d3748;
            color: #e2e8f0;
            text-align: center;
            padding: 1.5rem 0;
            margin-top: auto;
        }

        footer .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        footer .footer-content {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 2rem;
            flex-wrap: wrap;
        }

        footer a {
            color: #cbd5e0;
            text-decoration: none;
            font-weight: 400;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        footer a:hover {
            color: #ffffff;
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

        .alert-fixed.alert-success {
            border-left-color: #03AC0E;
        }

        .alert-fixed.alert-success i {
            color: #03AC0E;
        }

        .alert-fixed.alert-error {
            border-left-color: #dc3545;
        }

        .alert-fixed.alert-error i {
            color: #dc3545;
        }

        .alert-fixed.alert-warning {
            border-left-color: #ffc107;
        }

        .alert-fixed.alert-warning i {
            color: #ffc107;
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

        /* SCROLLBAR */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #a0aec0;
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

        body.dark-mode .search-input {
            background: #0f3460;
            border-color: rgba(3, 172, 14, 0.3);
            color: #e5e7eb;
        }

        body.dark-mode .search-input::placeholder {
            color: #9ca3af;
        }

        body.dark-mode .search-input:focus {
            background: #0f3460;
            border-color: #03AC0E;
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

        body.dark-mode .dropdown-divider-custom {
            background: rgba(255, 255, 255, 0.1);
        }

        body.dark-mode footer {
            background: #0f1419;
        }

        /* THEME TOGGLE BUTTON */
        .theme-toggle {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            background: transparent;
            border: 2px solid #e5e7e9;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .theme-toggle:hover {
            border-color: #03AC0E;
            background: rgba(3, 172, 14, 0.1);
        }

        .theme-toggle i {
            font-size: 1.3rem;
            transition: all 0.3s ease;
            color: #fbbf24;
        }

        body.dark-mode .theme-toggle {
            border-color: rgba(3, 172, 14, 0.3);
        }

        body.dark-mode .theme-toggle:hover {
            border-color: #03AC0E;
            background: rgba(3, 172, 14, 0.15);
        }

        body.dark-mode .theme-toggle i {
            color: #60a5fa;
        }

        .theme-toggle-icon {
            position: absolute;
            transition: all 0.3s ease;
        }

        .theme-toggle .sun-icon {
            opacity: 1;
            transform: rotate(0deg) scale(1);
        }

        .theme-toggle .moon-icon {
            opacity: 0;
            transform: rotate(180deg) scale(0);
        }

        body.dark-mode .theme-toggle .sun-icon {
            opacity: 0;
            transform: rotate(-180deg) scale(0);
        }

        body.dark-mode .theme-toggle .moon-icon {
            opacity: 1;
            transform: rotate(0deg) scale(1);
        }

        /* MOBILE RESPONSIVE */
        @media (max-width: 992px) {
            .navbar-top .container > .d-flex {
                display: flex;
                justify-content: space-between;
                align-items: center;
                width: 100%;
                flex-wrap: wrap;
            }

            /* Logo di kiri */
            .navbar-brand {
                order: 1;
                margin-right: 0;
            }

            /* Icon group di kanan (cart + hamburger) */
            .icon-group {
                order: 2;
                margin-left: auto;
                display: flex;
                gap: 0.75rem;
                align-items: center;
            }

            /* Cart icon - order pertama (kiri) */
            .icon-group > .icon-btn {
                order: 1;
            }

            /* Hamburger - order kedua (kanan) */
            .navbar-toggler {
                order: 2;
            }

            /* HIDE Search bar di navbar untuk mobile */
            .search-wrapper {
                display: none !important;
            }

            /* Show hamburger button */
            .navbar-toggler {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            /* Hide desktop navigation menu */
            .nav-link-custom {
                display: none;
            }

            /* Hide desktop auth buttons */
            .auth-buttons {
                display: none;
            }

            /* Hide account dropdown */
            .account-dropdown {
                display: none;
            }

            .navbar-top .container {
                flex-wrap: wrap;
            }

            .alert-fixed {
                right: 15px;
                left: 15px;
                min-width: auto;
                top: 80px;
            }

            main {
                padding-top: 130px;
            }

            body:has(.running-text-wrapper) main {
                padding-top: 170px;
            }

            .running-text-wrapper {
                top: 73px;
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
                padding: 0.45rem;
            }

            .navbar-toggler-icon {
                width: 22px;
                height: 2px;
            }

            .navbar-toggler-icon::before,
            .navbar-toggler-icon::after {
                width: 22px;
            }

            .icon-btn {
                padding: 0.45rem;
            }

            .icon-btn i {
                font-size: 1.35rem;
            }

            .icon-group {
                gap: 0.8rem;
            }

            .badge-cart {
                top: -4px;
                right: -4px;
                font-size: 0.6rem;
                padding: 0.15rem 0.35rem;
                min-width: 16px;
            }

            .search-wrapper {
                margin: 0.7rem 0 0 0;
            }

            .search-input {
                padding: 0.65rem 2.5rem 0.65rem 0.9rem;
                font-size: 0.85rem;
            }

            .search-btn {
                padding: 0 1rem;
            }

            main {
                padding-top: 120px;
            }

            body:has(.running-text-wrapper) main {
                padding-top: 158px;
            }

            .running-text-wrapper {
                top: 69px;
                padding: 0.35rem 0;
            }

            .running-text span {
                font-size: 0.8rem;
            }

            .running-text::after {
                font-size: 0.8rem;
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
                padding: 0.4rem;
            }

            .navbar-toggler-icon {
                width: 20px;
            }

            .navbar-toggler-icon::before,
            .navbar-toggler-icon::after {
                width: 20px;
            }

            .icon-btn {
                padding: 0.4rem;
            }

            .icon-btn i {
                font-size: 1.3rem;
            }

            .icon-group {
                gap: 0.7rem;
            }

            .badge-cart {
                top: -3px;
                right: -3px;
                font-size: 0.55rem;
                padding: 0.12rem 0.3rem;
                min-width: 15px;
            }

            .search-input {
                padding: 0.6rem 2.3rem 0.6rem 0.8rem;
                font-size: 0.82rem;
            }

            .search-btn {
                padding: 0 0.85rem;
            }

            .search-btn i {
                font-size: 0.9rem;
            }

            .search-wrapper {
                margin: 0.65rem 0 0 0;
            }

            main {
                padding-top: 110px;
            }

            body:has(.running-text-wrapper) main {
                padding-top: 145px;
            }

            .running-text-wrapper {
                top: 64px;
                padding: 0.32rem 0;
            }

            .running-text-container {
                gap: 0.6rem;
            }

            .running-text-container > i {
                font-size: 0.88rem;
            }

            .running-text span {
                font-size: 0.75rem;
            }

            .running-text::after {
                font-size: 0.75rem;
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
                -webkit-line-clamp: 1; /* Maksimal 1 baris di mobile */
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
                padding-top: 105px;
            }

            body:has(.running-text-wrapper) main {
                padding-top: 138px;
            }

            .running-text-wrapper {
                top: 60px;
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
    </style>
</head>

<body>

    {{-- NAVBAR - TOKOPEDIA STYLE --}}
    <div class="navbar-wrapper">
        {{-- NAVBAR TOP --}}
        <div class="navbar-top">
            <div class="container">
                <div class="d-flex align-items-center">
                    {{-- LOGO --}}
                    <a class="navbar-brand" href="{{ route('home') }}">
                        <img src="{{ asset('logo/logo 2.png') }}" alt="Logo CPM" class="logo-navbar">
                        <span>CPM</span>
                    </a>

                    {{-- SEARCH BAR --}}
                    @if(Request::routeIs('produk.*'))
                        <div class="search-wrapper">
                            <form class="search-form" id="searchForm">
                                <input type="text" class="search-input" name="search" id="searchInput" placeholder="Cari produk di CPM..." value="{{ request('search') }}">
                                <button type="submit" class="search-btn">
                                    <i class="bi bi-search"></i>
                                </button>
                            </form>
                        </div>
                    @endif

                    {{-- AUTH BUTTONS OR USER MENU --}}
                    <div class="icon-group ms-auto">
                        {{-- HAMBURGER MENU BUTTON (Mobile Only) --}}
                        <button class="navbar-toggler" id="navbarToggler" type="button">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        {{-- NAVIGATION MENU (Desktop) --}}
                        <a href="{{ route('home') }}" class="nav-link-custom {{ Request::routeIs('home') ? 'active-nav' : '' }}">
                            Home
                        </a>
                        <a href="{{ route('produk.index') }}" class="nav-link-custom {{ Request::routeIs('produk.*') ? 'active-nav' : '' }}">
                            Produk
                        </a>
                        <a href="{{ route('tentang') }}" class="nav-link-custom {{ Request::routeIs('tentang') ? 'active-nav' : '' }}">
                            Tentang Kami
                        </a>
                        <a href="{{ route('maps') }}" class="nav-link-custom {{ Request::routeIs('maps') ? 'active-nav' : '' }}">
                            Maps
                        </a>
                        <a href="{{ route('kontak') }}" class="nav-link-custom {{ Request::routeIs('kontak') ? 'active-nav' : '' }}">
                            Kontak
                        </a>

                        {{-- CART --}}
                        <a href="{{ route('keranjang.index') }}" class="icon-btn">
                            <i class="bi bi-cart3"></i>
                            @php $count = count(session('keranjang', [])); @endphp
                            <span class="badge-cart" id="cartBadge" style="display: {{ $count > 0 ? 'inline-block' : 'none' }};">{{ $count }}</span>
                        </a>

                        {{-- AUTH SECTION --}}
                        @auth
                            {{-- USER LOGGED IN - SHOW ACCOUNT DROPDOWN --}}
                            <div class="account-dropdown">
                                <button class="icon-btn" id="accountBtn">
                                    <i class="bi bi-person-circle"></i>
                                    <span class="user-name-truncate">{{ Auth::user()->name }}</span>
                                </button>
                                <div class="dropdown-menu-custom">
                                    <div class="user-info">
                                        <div class="user-name">{{ Auth::user()->name }}</div>
                                        <span class="user-role">{{ ucfirst(Auth::user()->role) }}</span>
                                    </div>
                                    @if(Auth::user()->isAdminOrOwner())
                                        <a href="{{ route('admin.dashboard') }}" class="dropdown-item-custom">
                                            <i class="bi bi-speedometer2"></i>
                                            <span>Dashboard Admin</span>
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
                            {{-- GUEST - SHOW LOGIN/REGISTER BUTTONS --}}
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

    {{-- MOBILE OFFCANVAS MENU --}}
    <div class="navbar-offcanvas" id="navbarOffcanvas">
        <div class="navbar-offcanvas-header">
            <h5 class="navbar-offcanvas-title">Menu</h5>
            <button class="offcanvas-close-btn" id="offcanvasCloseBtn">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div class="navbar-offcanvas-body">
            {{-- Navigation Links --}}
            <div class="offcanvas-nav-links">
                <a href="{{ route('home') }}" class="offcanvas-nav-link {{ Request::routeIs('home') ? 'active' : '' }}">
                    <i class="bi bi-house-door-fill"></i>
                    <span>Home</span>
                </a>
                <a href="{{ route('produk.index') }}" class="offcanvas-nav-link {{ Request::routeIs('produk.*') ? 'active' : '' }}">
                    <i class="bi bi-box-seam-fill"></i>
                    <span>Produk</span>
                </a>
                <a href="{{ route('tentang') }}" class="offcanvas-nav-link {{ Request::routeIs('tentang') ? 'active' : '' }}">
                    <i class="bi bi-info-circle-fill"></i>
                    <span>Tentang Kami</span>
                </a>
                <a href="{{ route('maps') }}" class="offcanvas-nav-link {{ Request::routeIs('maps') ? 'active' : '' }}">
                    <i class="bi bi-geo-alt-fill"></i>
                    <span>Maps</span>
                </a>
                <a href="{{ route('kontak') }}" class="offcanvas-nav-link {{ Request::routeIs('kontak') ? 'active' : '' }}">
                    <i class="bi bi-telephone-fill"></i>
                    <span>Kontak</span>
                </a>
            </div>

            <div class="offcanvas-divider"></div>

            {{-- Auth Section --}}
            @auth
                <div class="offcanvas-auth-section">
                    <div class="offcanvas-user-info">
                        <div class="offcanvas-user-avatar">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div class="offcanvas-user-details">
                            <div class="offcanvas-user-name">{{ Auth::user()->name }}</div>
                            <span class="offcanvas-user-role">{{ ucfirst(Auth::user()->role) }}</span>
                        </div>
                    </div>
                    @if(Auth::user()->isAdminOrOwner())
                        <a href="{{ route('admin.dashboard') }}" class="offcanvas-nav-link">
                            <i class="bi bi-speedometer2"></i>
                            <span>Dashboard Admin</span>
                        </a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" style="margin-top: 0.5rem;">
                        @csrf
                        <button type="submit" class="offcanvas-btn offcanvas-btn-logout">
                            <i class="bi bi-box-arrow-right me-2"></i>
                            Logout
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

    {{-- OVERLAY --}}
    <div class="navbar-overlay" id="navbarOverlay"></div>

    {{-- RUNNING TEXT / INFO BERJALAN - HANYA DI HOME --}}
    @if(Request::routeIs('home'))
        <div class="running-text-wrapper">
            <div class="container">
                <div class="running-text-container">
                    <i class="bi bi-megaphone-fill"></i>
                    <div class="running-text-content">
                        <div class="running-text">
                            <span>Selamat Datang di Warung Sembako Cahaya Putri Maulana (CPM)</span>
                            <span>Warung yang menyediakan stok kebutuhan rumah tangga</span>
                            <span>Buka setiap hari dari jam 07:00-21:00</span>
                            <span>Belanja Langsung di tempatnya</span>
                            <span>Kumplit Serta harganya Ramah Didompet</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- MAIN CONTENT --}}
    <main>
        {{-- FLASH MESSAGE --}}
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
            <div class="footer-content">
                <div class="footer-copyright">
                    &copy; {{ date('Y') }} <strong>Warung Sembako Cahaya Putri Maulana (CPM)</strong>
                </div>
            </div>
        </div>
    </footer>

    {{-- SCRIPTS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // ===== SAFE STORAGE ACCESS =====
        // Helper function untuk akses localStorage dengan error handling
        function safeGetStorage(key, defaultValue) {
            try {
                return localStorage.getItem(key) || defaultValue;
            } catch (e) {
                console.warn('localStorage blocked:', e);
                return defaultValue;
            }
        }

        function safeSetStorage(key, value) {
            try {
                localStorage.setItem(key, value);
                return true;
            } catch (e) {
                console.warn('localStorage blocked:', e);
                return false;
            }
        }

        // ===== THEME MANAGEMENT =====
        // Load theme on page load
        document.addEventListener('DOMContentLoaded', function() {
            const savedTheme = safeGetStorage('theme', 'light');
            applyTheme(savedTheme);
        });

        // Global function to apply theme
        window.applyTheme = function(theme) {
            if (theme === 'dark') {
                document.body.classList.add('dark-mode');
                document.body.classList.remove('light-mode');
            } else {
                document.body.classList.add('light-mode');
                document.body.classList.remove('dark-mode');
            }
            safeSetStorage('theme', theme);
        };

        // Fungsi global untuk update badge keranjang
        window.updateCartBadge = function(count) {
            const badge = document.getElementById('cartBadge');
            if (badge) {
                if (count > 0) {
                    badge.textContent = count;
                    badge.style.display = 'inline-block';
                } else {
                    badge.style.display = 'none';
                }
            }
        };

        // Theme Toggle Button
        const themeToggle = document.getElementById('themeToggle');
        if (themeToggle) {
            themeToggle.addEventListener('click', function() {
                const currentTheme = document.body.classList.contains('dark-mode') ? 'dark' : 'light';
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                applyTheme(newTheme);
            });
        }

        // Account Dropdown Toggle
        const accountBtn = document.getElementById('accountBtn');
        const accountDropdown = accountBtn?.closest('.account-dropdown');

        if (accountBtn && accountDropdown) {
            accountBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                accountDropdown.classList.toggle('show');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!accountDropdown.contains(e.target)) {
                    accountDropdown.classList.remove('show');
                }
            });
        }

        // Auto hide alert after 5 seconds
        const alertFixed = document.querySelector('.alert-fixed');
        if (alertFixed) {
            setTimeout(() => {
                alertFixed.style.animation = 'slideInRight 0.4s ease-out reverse';
                setTimeout(() => alertFixed.remove(), 400);
            }, 5000);
        }

        // Navbar Toggler for Mobile
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
    </script>

    @stack('scripts')
</body>
</html>
