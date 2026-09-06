@extends('layouts.app')

@section('content')
<style>
    .contact-card {
        transition: all 0.3s ease;
    }
    
    .contact-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(85, 0, 0, 0.2) !important;
    }
    
    .contact-icon {
        width: 70px;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: linear-gradient(135deg, #550000, #3d0000);
        color: white;
        font-size: 2rem;
        margin: 0 auto 1.5rem;
        box-shadow: 0 4px 15px rgba(85, 0, 0, 0.3);
    }
    
    .contact-value {
        color: #550000;
        font-weight: 600;
        font-size: 1.2rem;
    }

    /* Responsive Styles untuk Kontak */
    @media (max-width: 991.98px) {
        .card-body {
            padding: 2.5rem !important;
        }

        h2 {
            font-size: 1.75rem;
        }

        .contact-icon {
            width: 60px;
            height: 60px;
            font-size: 1.75rem;
        }

        .contact-value {
            font-size: 1.1rem;
        }
    }

    @media (max-width: 767.98px) {
        .container.my-5 {
            margin-top: 2rem !important;
            margin-bottom: 2rem !important;
        }

        .card-body {
            padding: 2rem !important;
        }

        h2 {
            font-size: 1.5rem;
        }

        .text-muted {
            font-size: 0.9rem;
        }

        .contact-icon {
            width: 55px;
            height: 55px;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .contact-card {
            padding: 1.25rem !important;
        }

        h5 {
            font-size: 1.1rem;
        }

        .contact-value {
            font-size: 1rem;
        }

        .text-secondary {
            font-size: 0.9rem;
        }
    }

    @media (max-width: 575.98px) {
        .card-body {
            padding: 1.5rem !important;
        }

        h2 {
            font-size: 1.3rem;
        }

        .text-muted {
            font-size: 0.85rem;
        }

        .contact-icon {
            width: 50px;
            height: 50px;
            font-size: 1.3rem;
        }

        .contact-card {
            padding: 1rem !important;
        }

        h5 {
            font-size: 1rem;
        }

        .contact-value {
            font-size: 0.95rem;
        }

        .text-secondary {
            font-size: 0.85rem;
        }

        .badge {
            font-size: 0.8rem;
            padding: 0.4rem 0.8rem !important;
        }
    }

    /* Dark Mode */
    body.dark-mode .card {
        background: #16213e;
    }

    body.dark-mode h2,
    body.dark-mode h5 {
        color: #e5e7eb !important;
    }

    body.dark-mode .text-dark {
        color: #e5e7eb !important;
    }

    body.dark-mode .text-muted {
        color: #9ca3af !important;
    }

    body.dark-mode .text-secondary {
        color: #cbd5e0 !important;
    }

    body.dark-mode .contact-card {
        background: rgba(85, 0, 0, 0.1) !important;
    }

    body.dark-mode .contact-value {
        color: #550000;
    }

    body.dark-mode .text-success {
        color: #550000 !important;
    }
</style>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-body p-5">

                    <div class="text-center mb-5">
                        <h2 class="fw-bold">
                            <span class="text-success">Kontak</span> <span class="text-dark">Kami</span>
                        </h2>
                        <p class="text-muted mt-2">
                            Hubungi Warung Sembako CPM untuk informasi
                        </p>
                    </div>

                    <div class="row g-4 mb-5">
                        {{-- TELEPON --}}
                        <div class="col-md-6">
                            <div class="contact-card p-4 rounded-4 bg-light h-100 text-center shadow-sm">
                                <div class="contact-icon">
                                    <i class="bi bi-telephone-fill"></i>
                                </div>
                                <h5 class="fw-bold mb-3">Telepon</h5>
                                <p class="contact-value mb-2">0821-1094-5498</p>
                                <p class="text-success mb-0">
                                    <i class="bi bi-whatsapp me-1"></i>WhatsApp
                                </p>
                            </div>
                        </div>

                        {{-- JAM OPERASIONAL --}}
                        <div class="col-md-6">
                            <div class="contact-card p-4 rounded-4 bg-light h-100 text-center shadow-sm">
                                <div class="contact-icon">
                                    <i class="bi bi-clock-fill"></i>
                                </div>
                                <h5 class="fw-bold mb-3">Jam Operasional</h5>
                                <p class="text-secondary mb-2">
                                    <strong>Minggu - Jumat:</strong><br>07.00 â€“ 21.00 WIB
                                </p>
                                <p class="text-secondary mb-3">
                                    <strong>Sabtu:</strong><br>07.00 â€“ 22.00 WIB
                                </p>
                                <span class="badge bg-success px-3 py-2 rounded-pill">
                                    <i class="bi bi-check-circle-fill me-1"></i>Buka Sekarang
                                </span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection

