@extends('layouts.auth-admin')

@section('title', 'Login Admin - Warung Sembako CPM')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-sm-10 col-md-8 col-lg-5">
        <div class="auth-card">
            {{-- LOGO --}}
            <div class="text-center mb-4">
                <img src="{{ asset('logo/logo baru.jpeg') }}" alt="Logo CPM" class="logo-img">
                <h2 class="fw-bold auth-title">Login Admin</h2>
                <span class="admin-badge">Warung Sembako Cahaya Putri Maulana (CPM)</span>
            </div>

            {{-- ALERT MESSAGES --}}
            @if(session('success'))
                <div class="alert alert-success mb-3">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger mb-3">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
                </div>
            @endif

            {{-- FORM LOGIN --}}
            <form action="{{ route('admin.login.submit') }}" method="POST">
                @csrf

                {{-- EMAIL --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Email Admin</label>
                    <div class="input-group">
                        <span class="input-icon">
                            <i class="bi bi-envelope"></i>
                        </span>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                               placeholder="Masukkan email admin" value="{{ old('email') }}" required autofocus>
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
                               placeholder="Masukkan password" required>
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
                    <i></i>Login Admin
                </button>

                {{-- LINK TO REGISTER --}}
                <div class="text-center mt-3">
                    <p class="text-muted mb-0 register-text">Belum punya akun admin? <a href="{{ route('admin.register') }}" class="link-register">Daftar di sini</a></p>
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

    .register-text {
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

        .register-text {
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

