@extends('layouts.auth-admin')

@section('title', 'Registrasi Admin - Warung Sembako CPM')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-sm-10 col-md-8 col-lg-6">
        <div class="auth-card">
            {{-- LOGO --}}
            <div class="text-center mb-4">
                <img src="{{ asset('logo/logo baru.jpeg') }}" alt="Logo CPM" class="logo-img">
                <h2 class="fw-bold auth-title">Daftar Admin</h2>
                <span class="admin-badge">Warung Sembako Cahaya Putri Maulana (CPM)</span>
            </div>

            {{-- ALERT MESSAGES --}}
            @if(session('error'))
                <div class="alert alert-danger mb-3">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
                </div>
            @endif

            {{-- FORM REGISTER --}}
            <form action="{{ route('admin.register.submit') }}" method="POST">
                @csrf

                {{-- NAMA --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Lengkap</label>
                    <div class="input-group">
                        <span class="input-icon">
                            <i class="bi bi-person"></i>
                        </span>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               placeholder="Masukkan nama lengkap" value="{{ old('name') }}" required autofocus>
                    </div>
                    @error('name')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                {{-- EMAIL --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Email Admin</label>
                    <div class="input-group">
                        <span class="input-icon">
                            <i class="bi bi-envelope"></i>
                        </span>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                               placeholder="Masukkan email admin" value="{{ old('email') }}" required>
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
                    <p class="text-muted mb-0">Sudah punya akun admin? <a href="{{ route('admin.login') }}" class="link-login">Login di sini</a></p>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    .logo-img {
        width: 80px;
        height: 80px;
        object-fit: contain;
        margin-bottom: 1rem;
    }

    .auth-title {
        color: #550000;
        font-size: 1.75rem;
    }

    .auth-subtitle {
        font-size: 0.9rem;
    }

    .login-text {
        font-size: 0.9rem;
    }

    /* Responsive untuk tablet */
    @media (max-width: 768px) {
        .logo-img {
            width: 70px;
            height: 70px;
        }

        .auth-title {
            font-size: 1.5rem;
        }

        .auth-subtitle {
            font-size: 0.85rem;
        }

        .admin-badge {
            font-size: 0.7rem;
            padding: 0.35rem 0.9rem;
        }
    }

    /* Responsive untuk mobile */
    @media (max-width: 576px) {
        .logo-img {
            width: 60px;
            height: 60px;
        }

        .auth-title {
            font-size: 1.3rem;
        }

        .auth-subtitle {
            font-size: 0.8rem;
        }

        .admin-badge {
            font-size: 0.65rem;
            padding: 0.3rem 0.8rem;
        }

        .login-text {
            font-size: 0.85rem;
        }

        .form-label {
            font-size: 0.9rem;
        }

        .form-control {
            font-size: 0.9rem;
        }
    }
</style>
@endpush
@endsection

