@extends('layouts.app')

@section('content')
<style>
    .hero-banner-section {
        padding: 2rem 0 1rem;
        background: #f8f9fa;
        width: 100%;
    }

    .hero-banner-card {
        background: linear-gradient(135deg, #550000 0%, #7b0000 100%);
        border-radius: 24px;
        box-shadow: 0 10px 30px rgba(85, 0, 0, 0.2);
        position: relative;
        overflow: hidden;
        border: none;
    }

    /* Aksen lingkaran dekoratif di latar belakang */
    .hero-banner-card::before {
        content: "";
        position: absolute;
        top: -60px;
        right: -60px;
        width: 220px;
        height: 220px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
        pointer-events: none;
    }

    .hero-banner-card::after {
        content: "";
        position: absolute;
        bottom: -70px;
        left: -50px;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.04);
        border-radius: 50%;
        pointer-events: none;
    }

  .logo-container {
    width: 110px;
    height: 110px;
    background: #ffffff;
    border-radius: 50%; /* Ubah ke 20px jika ingin bentuk kotak melengkung */
    border: 3px solid #ffffff; /* Garis border tegas membingkai logo */
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.25rem;
    overflow: hidden; /* Memotong gambar agar mengikuti lekukan border */
    transition: transform 0.3s ease;
}

.logo-container img {
    width: 100%;
    height: 100%;
    object-fit: cover; /* Mengisi penuh bingkai tanpa distorsi */
    display: block;
}

    .logo-container:hover {
        transform: scale(1.05);
    }

    .hero-title {
        font-size: 2.3rem;
        font-weight: 800;
        letter-spacing: 1.5px;
        color: #ffffff;
        margin-bottom: 0.5rem;
    }

    .hero-subtitle {
        font-size: 1rem;
        color: rgba(255, 255, 255, 0.85);
        max-width: 580px;
        margin: 0 auto 1.5rem;
        line-height: 1.6;
    }

    .feature-badge {
        background: rgba(255, 255, 255, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(4px);
        color: #ffffff;
        font-weight: 500;
        font-size: 0.85rem;
        padding: 6px 16px;
        border-radius: 30px;
    }

    @media (max-width: 768px) {
        .hero-banner-section {
            padding: 1rem 0;
        }

        .hero-title {
            font-size: 1.7rem;
        }

        .hero-subtitle {
            font-size: 0.9rem;
        }

        .logo-container {
            width: 90px;
            height: 90px;
        }
    }
</style>

<!-- HERO BANNER IDENTITAS WAROENG 86 -->
<section class="hero-banner-section">
    <div class="container">
        <div class="card hero-banner-card py-5 px-3 px-md-4 text-center">
            <div class="position-relative" style="z-index: 2;">

                {{-- Logo Waroeng 86 --}}
                <div class="logo-container">
                    @if(file_exists(public_path('logo/logo home.png')))
                        <img src="{{ asset('logo/logo home.png') }}" alt="Logo Waroeng 86">
                    @else
                        <i class="bi bi-shop" style="font-size: 3rem; color: #550000;"></i>
                    @endif
                </div>

                {{-- Judul & Deskripsi --}}
                <h1 class="hero-title">WAROENG 86</h1>
                <p class="hero-subtitle">
                    Pusat Belanja Sembako & Kebutuhan Pokok Terlengkap, Berkualitas, dan Selalu Terjangkau untuk Warga Sekitar.
                </p>

                {{-- Badge Keunggulan --}}
                <div class="d-flex justify-content-center gap-2 flex-wrap">
                    <span class="feature-badge">
                        <i class="bi bi-tag-fill me-1 text-warning"></i> Harga Bersahabat
                    </span>
                    <span class="feature-badge">
                        <i class="bi bi-box-seam me-1 text-warning"></i> Sembako Lengkap
                    </span>
                    <span class="feature-badge">
                        <i class="bi bi-shield-check me-1 text-warning"></i> Belanja Nyaman
                    </span>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection
