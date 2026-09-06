@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-body p-4 p-md-5">

                    <div class="text-center mb-4">
                        <h2 class="fw-bold text-success">
                            Lokasi <span class="text-dark">Kami</span>
                        </h2>
                        <p class="text-muted mt-2">
                            Kunjungi langsung Warung Sembako CPM di lokasi berikut
                        </p>
                    </div>

                    <div class="row align-items-center g-4">
                        <div class="col-md-5">
                            <div class="p-3 p-md-4 rounded-4 bg-success bg-opacity-10 h-100">
                                <h5 class="fw-semibold text-success mb-3">
                                    ðŸª Warung Sembako CPM
                                </h5>
                                <p class="text-secondary mb-2">
                                    ðŸ“ Alamat:
                                </p>
                                <p class="text-secondary">
                                    Sukadarma<br>
                                    Kec. Sukatani, Kabupaten Bekasi<br>
                                    Jawa Barat 17630
                                </p>
                                <p class="text-secondary mb-2" style="font-size: 0.9rem;">
                                    <i class="bi bi-building me-1"></i>
                                    Berlokasi di: <strong>Perumahan Grand Sukatani Residance</strong>
                                </p>
                                
                            </div>
                        </div>

                        <div class="col-md-7">
                            <div class="ratio ratio-16x9 rounded-4 overflow-hidden shadow-sm">
                                <iframe 
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4023.484011076084!2d107.182985!3d-6.1749513!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6987004319c3db%3A0xdcb9eb667d75d3eb!2sWarung%20Sembako%20Cahaya%20Putri%20Maulana%20(CPM)!5e1!3m2!1sen!2sid!4v1767530864189!5m2!1sen!2sid"
                                    style="border:0;"
                                    allowfullscreen
                                    loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade">
                                </iframe>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<style>
    /* Responsive Styles untuk Maps */
    @media (max-width: 991.98px) {
        .card-body {
            padding: 2rem !important;
        }

        h2 {
            font-size: 1.5rem;
        }

        h5 {
            font-size: 1.1rem;
        }
    }

    @media (max-width: 767.98px) {
        .container.my-5 {
            margin-top: 2rem !important;
            margin-bottom: 2rem !important;
        }

        .card-body {
            padding: 1.5rem !important;
        }

        h2 {
            font-size: 1.3rem;
        }

        h5 {
            font-size: 1rem;
        }

        .text-muted {
            font-size: 0.9rem;
        }

        .text-secondary {
            font-size: 0.85rem;
        }

        .ratio {
            margin-top: 1rem;
        }
    }

    @media (max-width: 575.98px) {
        .card-body {
            padding: 1rem !important;
        }

        h2 {
            font-size: 1.2rem;
        }

        h5 {
            font-size: 0.95rem;
        }

        .text-secondary {
            font-size: 0.8rem;
        }

        .bg-success.bg-opacity-10 {
            padding: 1rem !important;
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

    body.dark-mode .bg-success.bg-opacity-10 {
        background: rgba(85, 0, 0, 0.15) !important;
    }
</style>
@endsection

