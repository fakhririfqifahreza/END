@extends('layouts.app')

@section('content')
<style>
    .about-section {
        line-height: 2;
        text-align: justify;
    }
    
    .about-section p {
        margin-bottom: 1.5rem;
        color: #4a5568;
        font-size: 1.05rem;
    }
    
    .about-section strong {
        color: #03AC0E;
        font-weight: 600;
    }

    /* Responsive Styles untuk Tentang Kami */
    @media (max-width: 991.98px) {
        .card-body {
            padding: 2.5rem !important;
        }

        h2 {
            font-size: 1.75rem;
        }

        .about-section p {
            font-size: 1rem;
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

        .about-section {
            line-height: 1.8;
        }

        .about-section p {
            font-size: 0.95rem;
            margin-bottom: 1.25rem;
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

        .about-section {
            line-height: 1.7;
            text-align: justify;
        }

        .about-section p {
            font-size: 0.9rem;
            margin-bottom: 1rem;
            text-align: justify;
        }
    }

    /* Dark Mode */
    body.dark-mode .card {
        background: #16213e;
    }

    body.dark-mode h2 {
        color: #e5e7eb !important;
    }

    body.dark-mode .text-dark {
        color: #e5e7eb !important;
    }

    body.dark-mode .text-muted {
        color: #9ca3af !important;
    }

    body.dark-mode .about-section p {
        color: #cbd5e0;
    }

    body.dark-mode .about-section strong {
        color: #03AC0E;
    }
</style>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">

            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-body p-5">

                    <div class="text-center mb-5">
                        <h2 class="fw-bold">
                            <span class="text-success">Tentang</span> <span class="text-dark">Kami</span>
                        </h2>
                        <p class="text-muted mt-2">
                            Warung Sembako Cahaya Putri Maulana (CPM)
                        </p>
                    </div>

                    <div class="about-section">
                        <p>
                            <strong>Warung Sembako Cahaya Putri Maulana (CPM)</strong> merupakan usaha mikro yang bergerak di bidang perdagangan kebutuhan pokok sehari-hari seperti beras, telur, minyak goreng, tepung terigu, gula, sabun, dan berbagai produk rumah tangga lainnya. Warung ini berdiri pada tanggal 31 Agustus 2025 dan berlokasi di Kabupaten Bekasi, Kecamatan Sukatani, Perumahan Grand Sukatani Residence.
                        </p>

                        <p>
                            Warung Sembako Cahaya Putri Maulana (CPM) berperan penting dalam memenuhi kebutuhan dasar masyarakat sekitar perumahan dan lingkungan sekitarnya. Sistem operasional yang digunakan selama ini masih dilakukan secara manual, baik dalam pencatatan produk, pengelolaan stok, perhitungan transaksi, maupun penambahan produk baru.
                        </p>

                        <p>
                            Warung ini telah beroperasi selama lebih dari tiga bulan dan memiliki kapasitas transaksi harian yang cukup tinggi, terutama pada jam-jam ramai seperti pagi dan sore hari. Namun, karena belum adanya sistem penjualan berbasis digital, proses pelayanan sering kali berjalan lambat dan masih kurang efisien. Pemilik warung masih mengandalkan buku catatan fisik untuk menyimpan data produk dan transaksi, serta menggunakan kalkulator manual untuk menghitung total harga setiap pembelian.
                        </p>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
