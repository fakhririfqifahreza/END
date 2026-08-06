@extends('layouts.app')

@section('content')
<div class="settings-container">
    <div class="container py-5">
        <div class="settings-card">
            <div class="settings-header">
                <i class="bi bi-gear-fill"></i>
                <h2>Pengaturan</h2>
            </div>

            <div class="settings-body">
                <!-- Theme Settings -->
                <div class="setting-item">
                    <div class="setting-info">
                        <i class="bi bi-palette-fill setting-icon"></i>
                        <div>
                            <h5>Tema Tampilan</h5>
                            <p>Pilih tema yang sesuai dengan preferensi Anda</p>
                        </div>
                    </div>
                    <div class="theme-toggle">
                        <button class="theme-btn" data-theme="dark" id="darkBtn">
                            <i class="bi bi-moon-stars-fill"></i>
                            Dark Mode
                        </button>
                        <button class="theme-btn" data-theme="light" id="lightBtn">
                            <i class="bi bi-sun-fill"></i>
                            Light Mode
                        </button>
                    </div>
                </div>

                <div class="setting-divider"></div>

                <!-- Account Settings -->
                <div class="setting-item">
                    <div class="setting-info">
                        <i class="bi bi-person-fill setting-icon"></i>
                        <div>
                            <h5>Informasi Akun</h5>
                            <p>Lihat dan kelola informasi akun Anda</p>
                        </div>
                    </div>
                    <div class="account-info-box">
                        <div class="info-row">
                            <span class="info-label">Nama:</span>
                            <span class="info-value">Admin CPM</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Email:</span>
                            <span class="info-value">admin@cpm.com</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Role:</span>
                            <span class="info-value role-badge">Admin</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .settings-container {
        min-height: calc(100vh - 200px);
        padding: 40px 0;
        background: #f5f5f5;
    }

    .settings-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 2px solid #e5e7e9;
        overflow: hidden;
        max-width: 800px;
        margin: 0 auto;
    }

    .settings-header {
        background: linear-gradient(135deg, #03AC0E, #02d115);
        padding: 30px;
        display: flex;
        align-items: center;
        gap: 15px;
        color: #fff;
    }

    .settings-header i {
        font-size: 2.5rem;
    }

    .settings-header h2 {
        margin: 0;
        font-weight: 700;
        font-size: 2rem;
    }

    .settings-body {
        padding: 30px;
    }

    .setting-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
    }

    .setting-info {
        display: flex;
        align-items: flex-start;
        gap: 15px;
        flex: 1;
    }

    .setting-icon {
        font-size: 2rem;
        color: #03AC0E;
        margin-top: 5px;
    }

    .setting-info h5 {
        margin: 0 0 8px 0;
        color: #212529;
        font-weight: 600;
        font-size: 1.2rem;
    }

    .setting-info p {
        margin: 0;
        color: #6b7280;
        font-size: 0.95rem;
    }

    .theme-toggle {
        display: flex;
        gap: 10px;
        background: #f3f4f6;
        padding: 8px;
        border-radius: 30px;
        border: 2px solid #e5e7e9;
    }

    .theme-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        border: none;
        border-radius: 25px;
        background: transparent;
        color: #6b7280;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 600;
        font-size: 0.95rem;
    }

    .theme-btn i {
        font-size: 1.2rem;
    }

    .theme-btn:hover {
        color: #03AC0E;
        transform: translateY(-2px);
    }

    .theme-btn.active {
        background: #03AC0E;
        color: #fff;
        box-shadow: 0 4px 15px rgba(3, 172, 14, 0.3);
    }

    .setting-divider {
        height: 2px;
        background: #e5e7e9;
        margin: 30px 0;
    }

    .account-info-box {
        background: #f9fafb;
        border: 2px solid #e5e7e9;
        border-radius: 12px;
        padding: 20px;
        min-width: 300px;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }

    .info-row:last-child {
        margin-bottom: 0;
    }

    .info-label {
        color: #6b7280;
        font-weight: 500;
    }

    .info-value {
        color: #212529;
        font-weight: 600;
    }

    .role-badge {
        background: #03AC0E;
        padding: 4px 12px;
        border-radius: 15px;
        font-size: 0.9rem;
        color: #ffffff;
    }

    .btn-custom-primary {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 24px;
        background: #03AC0E;
        color: #fff;
        border: none;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(3, 172, 14, 0.2);
    }

    .btn-custom-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(3, 172, 14, 0.3);
        color: #fff;
        background: #028A0F;
    }

    /* Dark Mode Styles */
    body.dark-mode .settings-container {
        background: #1a1a2e;
    }

    body.dark-mode .settings-card {
        background: #16213e;
        border-color: rgba(3, 172, 14, 0.3);
    }

    body.dark-mode .setting-info h5 {
        color: #e5e7eb;
    }

    body.dark-mode .setting-info p {
        color: #9ca3af;
    }

    body.dark-mode .theme-toggle {
        background: rgba(3, 172, 14, 0.1);
        border-color: rgba(3, 172, 14, 0.3);
    }

    body.dark-mode .theme-btn {
        color: #9ca3af;
    }

    body.dark-mode .theme-btn:hover {
        color: #03AC0E;
    }

    body.dark-mode .setting-divider {
        background: rgba(255, 255, 255, 0.1);
    }

    body.dark-mode .account-info-box {
        background: rgba(3, 172, 14, 0.1);
        border-color: rgba(3, 172, 14, 0.3);
    }

    body.dark-mode .info-label {
        color: #9ca3af;
    }

    body.dark-mode .info-value {
        color: #e5e7eb;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .settings-header {
            padding: 20px;
        }

        .settings-header i {
            font-size: 2rem;
        }

        .settings-header h2 {
            font-size: 1.5rem;
        }

        .settings-body {
            padding: 20px;
        }

        .setting-item {
            flex-direction: column;
            align-items: flex-start;
        }

        .theme-toggle {
            width: 100%;
            justify-content: center;
        }

        .account-info-box {
            width: 100%;
            min-width: auto;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const darkBtn = document.getElementById('darkBtn');
        const lightBtn = document.getElementById('lightBtn');

        // Load saved theme and update button states
        const savedTheme = localStorage.getItem('theme') || 'light';
        updateButtonStates(savedTheme);

        // Dark mode button
        darkBtn.addEventListener('click', () => {
            window.applyTheme('dark');
            updateButtonStates('dark');
        });

        // Light mode button
        lightBtn.addEventListener('click', () => {
            window.applyTheme('light');
            updateButtonStates('light');
        });

        function updateButtonStates(theme) {
            if (theme === 'dark') {
                darkBtn.classList.add('active');
                lightBtn.classList.remove('active');
            } else {
                lightBtn.classList.add('active');
                darkBtn.classList.remove('active');
            }
        }
    });
</script>
@endsection
