@extends('layouts.app')

@section('content')
<div class="container my-5 py-4">
    <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="col-md-6">
            <div class="auth-card">
                {{-- LOGO --}}
                <div class="text-center mb-4">
                    <img src="{{ asset('logo/logo 2.png') }}" alt="Logo CPM" style="width: 80px; height: 80px; object-fit: contain; margin-bottom: 1rem;">
                    <h2 class="fw-bold" style="color: #03AC0E;">Daftar</h2>
                    <p class="text-muted">Warung Sembako Cahaya Putri Maulana (CPM)</p>
                </div>

                {{-- FORM REGISTER --}}
                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    
                    {{-- NAMA --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Lengkap</label>
                        <div class="input-group">
                            <span class="input-icon">
                                <i class="bi bi-person"></i>
                            </span>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   placeholder="Masukkan nama lengkap Anda" value="{{ old('name') }}" required>
                        </div>
                        @error('name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

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

                    {{-- PASSWORD --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Password</label>
                        <div class="input-group">
                            <span class="input-icon">
                                <i class="bi bi-lock"></i>
                            </span>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                                   placeholder="Minimal 6 karakter" required>
                        </div>
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- KONFIRMASI PASSWORD --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Konfirmasi Password</label>
                        <div class="input-group">
                            <span class="input-icon">
                                <i class="bi bi-lock-fill"></i>
                            </span>
                            <input type="password" name="password_confirmation" class="form-control" 
                                   placeholder="Ulangi password Anda" required>
                        </div>
                    </div>

                    {{-- BUTTON REGISTER --}}
                    <button type="submit" class="btn-register">
                        <i></i>Daftar Sekarang
                    </button>

                    {{-- LINK TO LOGIN --}}
                    <div class="text-center mt-3">
                        <p class="text-muted mb-0">Sudah punya akun? <a href="{{ route('login') }}" class="link-login">Login di sini</a></p>
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
        border-color: #03AC0E;
        box-shadow: 0 0 0 4px rgba(3, 172, 14, 0.1);
    }

    .form-control.is-invalid {
        border-color: #dc3545;
    }

    .btn-register {
        width: 100%;
        padding: 0.85rem;
        background: linear-gradient(135deg, #03AC0E 0%, #028A0F 100%);
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(3, 172, 14, 0.3);
    }

    .btn-register:hover {
        background: linear-gradient(135deg, #028A0F 0%, #026D0B 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(3, 172, 14, 0.4);
    }

    .link-login {
        color: #03AC0E;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .link-login:hover {
        color: #028A0F;
        text-decoration: underline;
    }

    /* Dark Mode */
    body.dark-mode .auth-card {
        background: #16213e;
    }

    body.dark-mode .form-control {
        background: #1a1a2e;
        border-color: rgba(3, 172, 14, 0.3);
        color: #e5e7eb;
    }

    body.dark-mode .form-control::placeholder {
        color: #9ca3af;
    }

    body.dark-mode .form-control:focus {
        background: #1a1a2e;
        border-color: #03AC0E;
        color: #e5e7eb;
    }

    body.dark-mode .input-icon {
        color: #9ca3af;
    }
</style>
@endsection
