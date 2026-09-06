@extends('layouts.app')

@section('content')
<style>
    body {
        background: #f5f5f5;
        background-attachment: fixed;
    }

    /* ===== Header Section ===== */
    .page-header {
        text-align: center;
        margin-bottom: 35px;
    }

    .page-header h2 {
        font-weight: 700;
        color: #550000;
    }

    /* ===== Search Bar di Halaman Produk ===== */
    .search-container {
        max-width: 600px;
        margin: 0 auto 30px auto;
        padding: 0 15px;
    }

    .search-form-produk {
        position: relative;
        width: 100%;
    }

    .search-form-produk input {
        width: 100%;
        padding: 0.75rem 3rem 0.75rem 1rem;
        border: 2px solid #e5e7e9;
        border-radius: 8px;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .search-form-produk input:focus {
        outline: none;
        border-color: #550000;
        box-shadow: 0 0 0 3px rgba(85, 0, 0, 0.1);
    }

    .search-form-produk button {
        position: absolute;
        right: 0;
        top: 0;
        height: 100%;
        padding: 0 1.2rem;
        background: #550000;
        color: white;
        border: none;
        border-radius: 0 8px 8px 0;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .search-form-produk button:hover {
        background: #3d0000;
    }

    /* HIDE search container di desktop (gunakan search di navbar) */
    @media (min-width: 993px) {
        .search-container {
            display: none !important;
        }
    }

    /* SHOW search container di mobile (sembunyikan search navbar) */
    @media (max-width: 992px) {
        .search-container {
            display: block;
        }
    }

    /* ===== Search & Button ===== */
    .toolbar {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 15px;
        margin-bottom: 40px;
        flex-wrap: wrap;
    }

    .btn-add {
        background: linear-gradient(135deg, #550000, #3d0000);
        color: #fff;
        border-radius: 50px;
        padding: 12px 22px;
        border: none;
        box-shadow: 0 4px 15px rgba(85, 0, 0, 0.3);
        transition: 0.3s;
        font-weight: 600;
    }

    .btn-add:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(85, 0, 0, 0.5);
        background: linear-gradient(135deg, #3d0000, #550000);
    }

    /* ===== Product Card ===== */
    .product-card {
        transition: all 0.3s ease;
        border-radius: 16px;
        overflow: hidden;
        border: 3px solid #d0d0d0;
        background: #ffffff;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
    }

    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 25px 50px rgba(85, 0, 0, 0.25);
        border-color: #550000;
        z-index: 10;
    }

    .product-card img {
        height: 160px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .product-card:hover img {
        transform: scale(1.1);
    }

    .product-card h5 {
        font-weight: 600;
        margin-bottom: 8px;
        color: #212529;
        font-size: 0.95rem;
        min-height: 45px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .product-card p {
        margin-bottom: 6px;
        font-size: 0.85rem;
    }

    /* Stok Habis Styles */
    .product-card.stok-habis {
        opacity: 0.7;
        filter: grayscale(0.5);
    }

    .product-card.stok-habis:hover {
        transform: translateY(-5px) scale(1.02);
        box-shadow: 0 10px 20px rgba(220, 53, 69, 0.3);
    }

    .stok-habis-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background: linear-gradient(135deg, #dc3545, #c82333);
        color: white;
        padding: 5px 12px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 0.75rem;
        box-shadow: 0 2px 8px rgba(220, 53, 69, 0.5);
        z-index: 10;
    }

    .product-card .btn-outline-success:disabled {
        background: #6c757d;
        border-color: #6c757d;
        color: white;
        cursor: not-allowed;
        opacity: 0.8;
    }

    .product-card .btn-outline-success:disabled:hover {
        transform: none;
        box-shadow: none;
    }

    .card-body {
        padding: 14px;
        display: flex;
        flex-direction: column;
    }

    .card-price-info {
        min-height: 65px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .card-body .btn-outline-success {
        border-color: #550000;
        color: #550000;
        font-weight: 600;
        background: transparent;
        transition: all 0.3s ease;
        padding: 8px 12px;
        font-size: 0.85rem;
    }

    .card-body .btn-outline-success:hover {
        background: linear-gradient(135deg, #550000, #3d0000);
        border-color: #550000;
        color: #fff;
        box-shadow: 0 4px 15px rgba(85, 0, 0, 0.5);
        transform: translateY(-2px);
    }

    .text-success {
        color: #550000 !important;
        font-size: 0.95rem;
    }

    .text-muted {
        color: #666 !important;
    }

    /* ===== Modal Light Theme ===== */
    .modal-content {
        background: #ffffff;
        border: 1px solid rgba(85, 0, 0, 0.3);
        color: #212529;
    }

    .modal-header {
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    }

    .modal-title {
        color: #550000;
    }

    .modal-footer {
        border-top: 1px solid rgba(0, 0, 0, 0.1);
    }

    .form-label {
        color: #212529;
    }

    .form-control {
        background: #ffffff;
        border: 1px solid rgba(0, 0, 0, 0.2);
        color: #212529;
    }

    .form-control:focus {
        background: #ffffff;
        border-color: #550000;
        box-shadow: 0 0 10px rgba(85, 0, 0, 0.2);
        color: #212529;
    }

    .btn-close {
        filter: none;
    }

    /* ===== Floating Alert ===== */
    .alert-fixed {
        position: fixed;
        top: 80px;
        right: 30px;
        z-index: 99999;
        min-width: 320px;
        max-width: 450px;
        background: #ffffff;
        color: #2d3748;
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-left: 4px solid #550000;
        border-radius: 8px;
        padding: 1rem 1.5rem;
        font-weight: 500;
        font-size: 0.95rem;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        animation: slideInRight 0.4s ease-out;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .alert-fixed i {
        font-size: 1.4rem;
        color: #550000;
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(100px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* ===== RESPONSIVE STYLES ===== */
    @media (max-width: 991px) {
        .page-header h2 {
            font-size: 1.8rem;
        }

        .toolbar {
            gap: 10px;
            margin-bottom: 30px;
        }

        .btn-add {
            width: 100%;
            max-width: 360px;
        }
    }

    @media (max-width: 768px) {
        .container.mt-5 {
            margin-top: 2rem !important;
            padding: 0 15px;
        }

        .page-header {
            margin-bottom: 25px;
        }

        .page-header h2 {
            font-size: 1.5rem;
        }

        .product-card h5 {
            font-size: 0.85rem;
            min-height: 38px;
        }

        .product-card p {
            font-size: 0.75rem;
        }

        .text-success {
            font-size: 0.85rem;
        }

        .card-body {
            padding: 10px;
        }

        .card-price-info {
            min-height: 55px;
        }

        .card-body .btn-outline-success {
            padding: 6px 10px;
            font-size: 0.75rem;
        }

        .product-card img {
            height: 140px;
        }

        .modal-dialog {
            margin: 10px;
        }

        .modal-title {
            font-size: 1.1rem;
        }

        .form-label {
            font-size: 0.9rem;
        }

        .form-control {
            font-size: 0.9rem;
        }
    }

    @media (max-width: 576px) {
        .page-header h2 {
            font-size: 1.3rem;
        }

        .btn-add {
            padding: 10px 18px;
            font-size: 0.9rem;
        }

        .product-card {
            border-radius: 12px;
        }

        .product-card img {
            height: 120px;
        }

        .product-card h5 {
            font-size: 0.8rem;
            min-height: 35px;
        }

        .product-card p {
            font-size: 0.7rem;
        }

        .text-success {
            font-size: 0.8rem;
        }

        .card-body {
            padding: 8px;
        }

        .card-body .btn-outline-success {
            padding: 5px 8px;
            font-size: 0.7rem;
        }

        .alert-fixed {
            top: 70px;
            right: 15px;
            min-width: 280px;
            font-size: 0.9rem;
            padding: 12px 16px;
        }
    }

    @media (min-width: 577px) and (max-width: 991px) {
        .product-card img {
            height: 150px;
        }

        .product-card h5 {
            font-size: 0.9rem;
        }
    }
</style>

<div class="container mt-5">

    <div class="page-header">
        <h2>Daftar Produk</h2>
    </div>

    {{-- SEARCH BAR --}}
    <div class="search-container">
        <form class="search-form-produk" id="searchFormMobile">
            <input type="text"
                   name="search"
                   id="searchInputMobile"
                   placeholder="Cari produk di CPM..."
                   value="{{ request('search') }}">
            <button type="submit">
                <i class="bi bi-search"></i>
            </button>
        </form>
    </div>

    {{-- Notifikasi sudah ditangani oleh app.blade.php, jadi hapus dari sini --}}

    {{-- Toolbar dengan tombol Tambah Produk dihilangkan --}}
    {{--
    <div class="toolbar">
        <button class="btn-add" data-bs-toggle="modal" data-bs-target="#modalTambahProduk">
            + Tambah Produk
        </button>
    </div>
    --}}


    {{-- DAFTAR PRODUK --}}
    <div class="row g-3" id="produk-list">
        @forelse($barang as $index => $item)
            @php
                // Ekstrak angka dari stok
                preg_match('/^(\d+(?:\.\d+)?)/', trim($item->stok_barang), $matches);
                $stokAngka = isset($matches[1]) ? floatval($matches[1]) : 0;
                $stokHabis = $stokAngka <= 0;
            @endphp
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6 mb-3">
                <div class="card product-card shadow-sm border-0 rounded-4 h-100 {{ $stokHabis ? 'stok-habis' : '' }}">
                    <div style="overflow: hidden; border-top-left-radius: 1rem; border-top-right-radius: 1rem; position: relative;">
                        <img src="{{ $item->gambar_barang ? asset('storage/gambar/'.$item->gambar_barang) : asset('noimage.jpg') }}"
                             class="card-img-top"
                             alt="{{ $item->nama_barang }}"
                             style="height:160px; object-fit:cover;">
                        @if($stokHabis)
                            <div class="stok-habis-badge">HABIS</div>
                        @endif
                    </div>
                    <div class="card-body text-center d-flex flex-column">
                        <h5 class="card-title fw-bold">{{ $item->nama_barang }}</h5>
                        <div class="card-price-info">
                            <p class="text-muted mb-1 {{ $stokHabis ? 'text-danger fw-bold' : '' }}">
                                Stok: {{ $item->stok_barang }}
                            </p>
                            <p class="text-success fw-bold mb-2">
                                Rp {{ number_format($item->harga_barang, 0, ',', '.') }}
                            </p>
                        </div>
                        

                        @auth
                            <form action="{{ route('keranjang.tambah', ['id' => $item->id_barang]) }}" method="POST" class="mt-auto">
                                @csrf
                                <button type="submit"
                                        class="btn btn-outline-success w-100 rounded-pill btn-sm"
                                        {{ $stokHabis ? 'disabled' : '' }}>
                                    {{ $stokHabis ? 'Stok Habis' : 'Keranjang' }}
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline-success w-100 rounded-pill btn-sm mt-auto" style="display: inline-block; text-decoration: none; padding: 8px 12px;">
                                Keranjang
                            </a>
                        @endauth
                    </div>
                </div>
            </div>

            {{-- Modal Edit Stok --}}
            <div class="modal fade" id="modalEditStok{{ $item->id_barang }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content rounded-4 shadow-lg">
                        <div class="modal-header">
                            <h5 class="modal-title fw-semibold">
                                <i class="bi bi-pencil-square"></i> Edit Produk
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="{{ route('produk.updateStok', $item->id_barang) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-success">Nama Produk <span class="text-danger">*</span></label>
                                    <input type="text"
                                           name="nama_barang"
                                           class="form-control form-control-lg"
                                           value="{{ $item->nama_barang }}"
                                           required>
                                </div>

                                {{-- Gambar Produk --}}
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-success">Gambar Produk</label>
                                    <div class="text-center mb-2">
                                        <img src="{{ $item->gambar_barang ? asset('storage/gambar/'.$item->gambar_barang) : asset('noimage.jpg') }}"
                                             alt="{{ $item->nama_barang }}"
                                             class="img-thumbnail"
                                             id="previewImg{{ $item->id_barang }}"
                                             style="max-height: 150px; object-fit: cover; border-radius: 12px;">
                                    </div>
                                    <input type="file"
                                           name="gambar_barang"
                                           class="form-control"
                                           accept="image/*"
                                           onchange="previewImage(event, {{ $item->id_barang }})">
                                    <small class="text-muted">Pilih gambar baru jika ingin mengubah gambar produk</small>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Stok Saat Ini</label>
                                            <input type="text" class="form-control" value="{{ $item->stok_barang }}" readonly style="background: rgba(108, 117, 125, 0.1);">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Harga Saat Ini</label>
                                            <input type="text" class="form-control" value="Rp {{ number_format($item->harga_barang, 0, ',', '.') }}" readonly style="background: rgba(108, 117, 125, 0.1);">
                                        </div>
                                    </div>
                                </div>

                                <hr style="border-color: rgba(85, 0, 0, 0.3); margin: 20px 0;">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold text-success">Stok Baru <span class="text-danger">*</span></label>
                                            <input type="text"
                                                   name="stok_barang"
                                                   class="form-control form-control-lg"
                                                   placeholder="Contoh: 50 kg"
                                                   value="{{ $item->stok_barang }}"
                                                   required>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold text-success">Harga Baru <span class="text-danger">*</span></label>
                                            <input type="number"
                                                   name="harga_barang"
                                                   class="form-control form-control-lg"
                                                   placeholder="Contoh: 15000"
                                                   value="{{ $item->harga_barang }}"
                                                   required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-success rounded-pill px-4" style="background: linear-gradient(135deg, #550000, #3d0000); border: none;">
                                    <i class="bi bi-check-circle"></i> SIMPAN
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted">Belum ada produk yang tersedia</div>
        @endforelse
    </div>
</div>

{{-- MODAL TAMBAH PRODUK --}}
<div class="modal fade" id="modalTambahProduk" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title fw-semibold">Tambah Produk Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

            </div>
            <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Produk</label>
                            <input type="text" name="nama_barang" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Stok</label>
                            <input type="text" name="stok_barang" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Harga</label>
                            <input type="number" name="harga_barang" class="form-control" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Gambar Produk</label>
                            <input type="file" name="gambar_barang" class="form-control" accept="image/*">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success rounded-pill px-4" style="background: linear-gradient(135deg, #550000, #3d0000); border: none; box-shadow: 0 4px 15px rgba(85, 0, 0, 0.5);">Simpan Produk</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        console.log('âœ… jQuery berhasil dimuat');

        // AJAX untuk tambah ke keranjang tanpa redirect
        $(document).on('submit', 'form[action*="keranjang/tambah"]', function(e) {
            e.preventDefault();

            var form = $(this);
            var url = form.attr('action');
            var button = form.find('button[type="submit"]');
            var originalText = button.html();

            // Cek jika button disabled (stok habis)
            if (button.prop('disabled')) {
                return false;
            }

            // Disable button dan ubah text
            button.prop('disabled', true).html('Menambah...');

            $.ajax({
                url: url,
                type: 'POST',
                data: form.serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Update badge keranjang
                    if (response.cart_count !== undefined && typeof window.updateCartBadge === 'function') {
                        window.updateCartBadge(response.cart_count);
                    }

                    // Tampilkan notifikasi
                    showNotification(response.message, 'success');

                    // Kembalikan tombol ke keadaan semula
                    button.prop('disabled', false).html(originalText);

                    // REDIRECT DIHAPUS - Tidak ada redirect ke halaman keranjang
                },
                error: function(xhr) {
                    console.error('Error:', xhr);

                    // Jika status 401 atau 419 (Unauthenticated), redirect langsung ke login
                    if (xhr.status === 401 || xhr.status === 419) {
                        window.location.href = "{{ route('login') }}";
                        return;
                    }

                    var errorMessage = 'Gagal menambahkan ke keranjang!';

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }

                    showNotification(errorMessage, 'error');
                    button.prop('disabled', false).html(originalText);
                }
            });
        });

        // Fungsi untuk menampilkan notifikasi
        function showNotification(message, type = 'success') {
            var iconClass = 'bi-check-circle-fill';
            var alertClass = 'alert-success';

            if (type === 'error') {
                iconClass = 'bi-x-circle-fill';
                alertClass = 'alert-error';
            } else if (type === 'warning') {
                iconClass = 'bi-exclamation-triangle-fill';
                alertClass = 'alert-warning';
            }

            var notification = $('<div class="alert-fixed ' + alertClass + '"><i class="bi ' + iconClass + '"></i><div class="alert-fixed-text">' + message + '</div></div>');
            $('body').append(notification);

            setTimeout(function() {
                notification.css({
                    'transition': 'opacity 0.5s ease',
                    'opacity': '0'
                });
                setTimeout(function() {
                    notification.remove();
                }, 500);
            }, 3000);
        }

        // Fungsi untuk melakukan pencarian
        function performSearch(query) {
            console.log('ðŸ” Mencari:', query);

            $.ajax({
                url: "{{ route('produk.search') }}",
                type: "GET",
                data: { query: query },
                success: function (data) {
                    console.log('âœ… Data ditemukan:', data.length);
                    console.log('Data:', data); // Debug: lihat data yang dikembalikan
                    $('#produk-list').html('');

                    if (data.length > 0) {
                        $.each(data, function (index, item) {
                            // Debug: log gambar untuk setiap item
                            console.log('Gambar item:', item.gambar_barang);

                            // Cek stok habis
                            var stokMatch = item.stok_barang.match(/^(\d+(?:\.\d+)?)/);
                            var stokAngka = stokMatch ? parseFloat(stokMatch[1]) : 0;
                            var stokHabis = stokAngka <= 0;
                            var stokHabisClass = stokHabis ? 'stok-habis' : '';
                            var stokHabisBadge = stokHabis ? '<div class="stok-habis-badge">HABIS</div>' : '';
                            var stokTextClass = stokHabis ? 'text-danger fw-bold' : '';
                            var buttonDisabled = stokHabis ? 'disabled' : '';
                            var buttonText = stokHabis ? 'Stok Habis' : 'Keranjang';

                            // Generate image URL - PERBAIKAN PATH
                            var imageUrl;
                            if (item.gambar_barang && item.gambar_barang != null && item.gambar_barang != '') {
                                imageUrl = '{{ asset("storage/gambar") }}/' + item.gambar_barang;
                            } else {
                                imageUrl = '{{ asset("noimage.jpg") }}';
                            }

                            console.log('Image URL:', imageUrl); // Debug URL gambar

                            $('#produk-list').append(`
                                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6 mb-3">
                                    <div class="card product-card shadow-sm border-0 rounded-4 h-100 ${stokHabisClass}">
                                        <div style="overflow: hidden; border-top-left-radius: 1rem; border-top-right-radius: 1rem; position: relative;">
                                            <img src="${imageUrl}"
                                                 class="card-img-top"
                                                 alt="${item.nama_barang}"
                                                 style="height:160px; object-fit:cover;"
                                                 onerror="this.src='{{ asset("noimage.jpg") }}'">
                                            ${stokHabisBadge}
                                        </div>
                                        <div class="card-body text-center d-flex flex-column">
                                            <h5 class="card-title fw-bold">${item.nama_barang}</h5>
                                            <div class="card-price-info">
                                                <p class="text-muted mb-1 ${stokTextClass}">Stok: ${item.stok_barang}</p>
                                                <p class="text-success fw-bold mb-2">
                                                    Rp ${parseInt(item.harga_barang).toLocaleString('id-ID')}
                                                </p>
                                            </div>
                                            <form action="{{ url('keranjang/tambah') }}/${item.id_barang}" method="POST" class="mt-auto">
                                                <input type="hidden" name="_token" value="${$('meta[name="csrf-token"]').attr('content')}">
                                                <button type="submit" class="btn btn-outline-success w-100 rounded-pill btn-sm" ${buttonDisabled}>
                                                    ${buttonText}
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            `);
                        });
                    } else {
                        $('#produk-list').html('<div class="col-12 text-center text-muted">Produk tidak ditemukan</div>');
                    }
                },
                error: function (xhr) {
                    console.error('âŒ Gagal ambil data:', xhr.responseText);
                    console.error('Status:', xhr.status);
                    console.error('Error:', xhr.statusText);
                }
            });
        }

        // Event handler untuk form submit MOBILE
        $('#searchFormMobile').on('submit', function(e) {
            e.preventDefault();
            var query = $('#searchInputMobile').val();
            performSearch(query);
        });

        // Event handler untuk keyup pada input pencarian MOBILE
        $('#searchInputMobile').on('keyup', function() {
            var query = $(this).val();
            performSearch(query);
        });

        // Event handler untuk form submit NAVBAR (Desktop)
        $('#searchForm').on('submit', function(e) {
            e.preventDefault();
            var query = $('#searchInput').val();
            performSearch(query);
        });

        // Event handler untuk keyup pada input pencarian NAVBAR (Desktop)
        $('#searchInput').on('keyup', function() {
            var query = $(this).val();
            performSearch(query);
        });

        // Auto hide alert
        setTimeout(function () {
            $(".alert").delay(2500).slideUp(500, function () {
                $(this).remove();
            });
        }, 3000);
    });

    // Preview image function
    function previewImage(event, id) {
        var reader = new FileReader();
        reader.onload = function () {
            var output = document.getElementById('previewImg' + id);
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endpush

