@extends('layouts.app')

@section('content')
<style>
    * {
        box-sizing: border-box;
    }

    /* ===== PROMO SLIDER / BANNER CAROUSEL ===== */
    .promo-slider-section {
        padding: 2rem 0;
        background: #f8f9fa;
        width: 100%;
        overflow: hidden;
    }

    .promo-carousel {
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        width: 100%;
    }

    .promo-slide {
        position: relative;
        height: 450px;
        display: flex;
        align-items: center;
        width: 100%;
    }

    .promo-slide::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, rgba(0,0,0,0.4) 0%, rgba(0,0,0,0.1) 100%);
        z-index: 1;
    }

    .promo-content {
        position: relative;
        z-index: 2;
        padding: 0 60px;
        max-width: 60%;
    }

    .promo-badge {
        display: inline-block;
        background: rgba(0, 0, 0, 0.8);
        color: white;
        padding: 8px 20px;
        border-radius: 25px;
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 15px;
    }

    .promo-title {
        font-size: 2.8rem;
        font-weight: 700;
        color: white;
        margin-bottom: 15px;
        text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);
        line-height: 1.2;
    }

    .promo-discount {
        font-size: 3.5rem;
        font-weight: 900;
        color: #fff;
        text-shadow: 3px 3px 10px rgba(0, 0, 0, 0.6);
        margin-bottom: 20px;
        line-height: 1;
    }

    .promo-description {
        font-size: 1.1rem;
        color: white;
        margin-bottom: 25px;
        text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.5);
        line-height: 1.5;
    }

    .btn-promo {
        display: inline-block;
        background: rgba(0, 0, 0, 0.9);
        color: white;
        padding: 12px 30px;
        border-radius: 25px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        border: 2px solid white;
    }

    .btn-promo:hover {
        background: white;
        color: #000;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }

    /* Carousel Controls */
    .carousel-control-prev,
    .carousel-control-next {
        width: 50px;
        height: 50px;
        background: rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        top: 50%;
        transform: translateY(-50%);
        opacity: 0.8;
        transition: all 0.3s ease;
    }

    .carousel-control-prev {
        left: 20px;
    }

    .carousel-control-next {
        right: 20px;
    }

    .carousel-control-prev:hover,
    .carousel-control-next:hover {
        background: rgba(255, 255, 255, 0.9);
        opacity: 1;
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        width: 25px;
        height: 25px;
    }

    .carousel-indicators {
        bottom: 20px;
    }

    .carousel-indicators button {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        margin: 0 5px;
        background-color: rgba(255, 255, 255, 0.5);
        border: none;
    }

    .carousel-indicators button.active {
        background-color: white;
        width: 35px;
        border-radius: 6px;
    }

    /* Slide Backgrounds */
    .slide-1,
    .slide-2,
    .slide-3,
    .slide-4 {
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }
    
    /* Fallback gradient jika gambar belum diupload */
    .slide-1:not([style*="background-image"]) {
        background: linear-gradient(135deg, #d946ef 0%, #10b981 100%);
    }

    .slide-2:not([style*="background-image"]) {
        background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
    }

    .slide-3:not([style*="background-image"]) {
        background: linear-gradient(135deg, #f59e0b 0%, #ef4444 100%);
    }

    .slide-4:not([style*="background-image"]) {
        background: linear-gradient(135deg, #06b6d4 0%, #3b82f6 100%);
    }

    /* Product Images in Slider */
    .promo-product-img {
        position: absolute;
        right: 80px;
        bottom: 0;
        max-height: 380px;
        z-index: 2;
        filter: drop-shadow(0 10px 20px rgba(0, 0, 0, 0.3));
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }

    /* ===== RESPONSIVE DESIGN ===== */
    @media (max-width: 992px) {
        .promo-slide {
            height: 350px;
        }

        .promo-content {
            max-width: 85%;
            padding: 0 40px;
        }

        .promo-title {
            font-size: 2rem;
        }

        .promo-discount {
            font-size: 2.8rem;
        }

        .promo-description {
            font-size: 1rem;
        }

        .promo-product-img {
            max-height: 300px;
            right: 40px;
        }
    }

    @media (max-width: 768px) {
        .promo-slider-section {
            padding: 1rem 0;
        }

        .promo-carousel {
            border-radius: 12px;
        }

        .promo-slide {
            height: 280px;
        }

        .promo-content {
            padding: 0 25px;
            max-width: 100%;
        }

        .promo-badge {
            font-size: 0.7rem;
            padding: 5px 12px;
            margin-bottom: 10px;
        }

        .promo-title {
            font-size: 1.4rem;
            margin-bottom: 8px;
        }

        .promo-discount {
            font-size: 2.2rem;
            margin-bottom: 12px;
        }

        .promo-description {
            font-size: 0.85rem;
            margin-bottom: 12px;
            line-height: 1.4;
        }

        .btn-promo {
            padding: 8px 20px;
            font-size: 0.8rem;
        }

        .promo-product-img {
            display: none;
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: 40px;
            height: 40px;
        }

        .carousel-control-prev {
            left: 15px;
        }

        .carousel-control-next {
            right: 15px;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            width: 20px;
            height: 20px;
        }

        .carousel-indicators {
            bottom: 15px;
        }

        .carousel-indicators button {
            width: 10px;
            height: 10px;
            margin: 0 4px;
        }

        .carousel-indicators button.active {
            width: 28px;
        }
    }

    @media (max-width: 576px) {
        .promo-slider-section {
            padding: 0.75rem 0;
        }

        .promo-carousel {
            border-radius: 10px;
        }

        .promo-slide {
            height: 220px;
        }

        .promo-content {
            padding: 0 18px;
        }

        .promo-badge {
            font-size: 0.65rem;
            padding: 4px 10px;
            margin-bottom: 8px;
        }

        .promo-title {
            font-size: 1.1rem;
            margin-bottom: 6px;
        }

        .promo-discount {
            font-size: 1.8rem;
            margin-bottom: 10px;
        }

        .promo-description {
            font-size: 0.75rem;
            margin-bottom: 10px;
            line-height: 1.3;
        }

        .btn-promo {
            padding: 7px 16px;
            font-size: 0.75rem;
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: 35px;
            height: 35px;
        }

        .carousel-control-prev {
            left: 10px;
        }

        .carousel-control-next {
            right: 10px;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            width: 16px;
            height: 16px;
        }

        .carousel-indicators {
            bottom: 10px;
        }

        .carousel-indicators button {
            width: 8px;
            height: 8px;
            margin: 0 3px;
        }

        .carousel-indicators button.active {
            width: 22px;
        }
    }

    @media (max-width: 400px) {
        .promo-slide {
            height: 200px;
        }

        .promo-content {
            padding: 0 15px;
        }

        .promo-badge {
            font-size: 0.6rem;
            padding: 3px 8px;
        }

        .promo-title {
            font-size: 1rem;
            margin-bottom: 5px;
        }

        .promo-discount {
            font-size: 1.5rem;
            margin-bottom: 8px;
        }

        .promo-description {
            font-size: 0.7rem;
            margin-bottom: 8px;
        }

        .btn-promo {
            padding: 6px 14px;
            font-size: 0.7rem;
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: 30px;
            height: 30px;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            width: 14px;
            height: 14px;
        }

        .carousel-indicators button {
            width: 6px;
            height: 6px;
        }

        .carousel-indicators button.active {
            width: 18px;
        }
    }

    /* ===== DARK MODE STYLES ===== */
    body.dark-mode .promo-slider-section {
        background: #1a1a2e;
    }

    body.dark-mode .promo-carousel {
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.8);
    }
</style>

<!-- PROMO SLIDER / BANNER CAROUSEL -->
<section class="promo-slider-section">
    <div class="container">
        <div id="promoCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#promoCarousel" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#promoCarousel" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#promoCarousel" data-bs-slide-to="2"></button>
                <button type="button" data-bs-target="#promoCarousel" data-bs-slide-to="3"></button>
            </div>
            <div class="carousel-inner promo-carousel">
                <!-- Slide 1 -->
                <div class="carousel-item active">
                    <div class="promo-slide slide-1" style="background-image: url('{{ asset("images/promo-1.jpg") }}');">
                        <div class="promo-content">
                            <span class="promo-badge">Warung sembako CPM</span>
                            <h2 class="promo-title">Warung sembako CPM</h2>
                            <p class="promo-description">Warung sembako CPM</p>
                        </div>
                    </div>
                </div>

                <!-- Slide 2 -->
                <div class="carousel-item">
                    <div class="promo-slide slide-2" style="background-image: url('{{ asset("images/promo-2.jpg") }}');">
                        <div class="promo-content">
                            <span class="promo-badge">Warung sembako CPM</span>
                            <h2 class="promo-title">Warung sembako CPM</h2>
                            <p class="promo-description">Warung sembako CPM</p>
                        </div>
                    </div>
                </div>

                <!-- Slide 3 -->
                <div class="carousel-item">
                    <div class="promo-slide slide-3" style="background-image: url('{{ asset("images/promo-3.jpg") }}');">
                        <div class="promo-content">
                            <span class="promo-badge">Warung sembako CPM</span>
                            <h2 class="promo-title">Warung sembako CPM</h2>
                            <p class="promo-description">Warung sembako CPM</p>
                        </div>
                    </div>
                </div>

                <!-- Slide 4 -->
                <div class="carousel-item">
                    <div class="promo-slide slide-4" style="background-image: url('{{ asset("images/promo-4.jpg") }}');">
                        <div class="promo-content">
                            <span class="promo-badge">Warung sembako CPM</span>
                            <h2 class="promo-title">Warung sembako CPM</h2>
                            <p class="promo-description">Warung sembako CPM</p>
                        </div>
                    </div>
                </div>
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#promoCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#promoCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </div>
</section>

@endsection
