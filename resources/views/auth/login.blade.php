@extends('layouts.app')

@section('content')
<div class="container my-5 py-4">
    <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="col-md-5">
            <div class="auth-card">
                {{-- LOGO --}}
                <div class="text-center mb-4">
                    <img src="{{ asset('logo/logo baru.jpeg') }}" alt="Logo CPM" style="width: 80px; height: 80px; object-fit: contain; margin-bottom: 1rem;">
                    <h2 class="fw-bold" style="color: #550000;">Login</h2>
                    <p class="text-muted"></p>
                </div>

                {{-- FORM LOGIN --}}
                <form action="{{ route('login') }}" method="POST">
                    @csrf

                    {{-- EMAIL --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <div class="input-group">
                            <span class="input-icon">
                                <i class="bi bi-envelope"></i>
                            </span>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                   placeholder="Masukkan email Anda" value="{{ old('email') }}" required>
                        </div>
                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
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
                    {{-- PASSWORD --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Password</label>
                        <div class="input-group">
                            <span class="input-icon">
                                <i class="bi bi-lock"></i>
                            </span>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Masukkan password Anda" required>
                        </div>
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- REMEMBER ME --}}
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember">
                        <label class="form-check-label" for="remember">Ingat saya</label>
                    </div>

                    {{-- BUTTON LOGIN --}}
                    <button type="submit" class="btn-login">
                        <i></i>Login
                    </button>

                    {{-- LINK TO REGISTER --}}
                    <div class="text-center mt-3">
                        <p class="text-muted mb-0">Belum punya akun? <a href="{{ route('register') }}" class="link-register">Daftar di sini</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .auth-card {
        background: #ffffff;
        padding: 2.5rem;
        border-radius: 16px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        margin-bottom: 3rem;
    }

    .input-group {
        position: relative;
    }

    .input-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #6b7280;
        z-index: 10;
        font-size: 1.1rem;
    }

    .form-control {
        padding: 0.75rem 1rem 0.75rem 3rem;
        border: 2px solid #e5e7e9;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #550000;
        box-shadow: 0 0 0 4px rgba(85, 0, 0, 0.1);
    }

    .form-control.is-invalid {
        border-color: #dc3545;
    }

    .btn-login {
        width: 100%;
        padding: 0.85rem;
        background: linear-gradient(135deg, #550000 0%, #3d0000 100%);
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(85, 0, 0, 0.3);
    }

    .btn-login:hover {
        background: linear-gradient(135deg, #3d0000 0%, #026D0B 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(85, 0, 0, 0.4);
    }

    .link-register {
        color: #550000;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .link-register:hover {
        color: #3d0000;
        text-decoration: underline;
    }

    .form-check-input:checked {
        background-color: #550000;
        border-color: #550000;
    }

    /* Dark Mode */
    body.dark-mode .auth-card {
        background: #16213e;
    }

    body.dark-mode .form-control {
        background: #1a1a2e;
        border-color: rgba(85, 0, 0, 0.3);
        color: #e5e7eb;
    }

    body.dark-mode .form-control::placeholder {
        color: #9ca3af;
    }

    body.dark-mode .form-control:focus {
        background: #1a1a2e;
        border-color: #550000;
        color: #e5e7eb;
    }

    body.dark-mode .input-icon {
        color: #9ca3af;
    }
</style>
@endsection

