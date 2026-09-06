@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="page-header mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-bold" style="color: #550000;">Mengelola Produk</h2>
            <button class="btn btn-success btn-add-product" data-bs-toggle="modal" data-bs-target="#modalTambahProduk">
                <i class="bi bi-plus-circle me-2 me-md-2 me-sm-0"></i><span class="d-none d-md-inline">Tambah Produk</span>
            </button>
        </div>
    </div>

    {{-- SEARCH BAR --}}
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0">
                    <i class="bi bi-search text-muted"></i>
                </span>
                <input type="text" 
                       id="searchInput" 
                       class="form-control border-start-0 border-end-0" 
                       placeholder="Cari produk..."
                       autocomplete="off">
            </div>
        </div>
    </div>

    {{-- TABLE PRODUK --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="tableProduk">
                    <thead style="background: #f8f9fa;">
                        <tr>
                            <th class="px-4 py-3">No</th>
                            <th class="py-3">Gambar</th>
                            <th class="py-3">Nama Produk</th>
                            <th class="py-3">Stok</th>
                            <th class="py-3">Harga</th>
                            <th class="py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="produkTableBody">
                        @forelse($produk as $index => $item)
                            <tr class="produk-row" data-nama="{{ strtolower($item->nama_barang) }}">
                                <td class="px-4 py-3">{{ $index + 1 }}</td>
                                <td class="py-3">
                                    <img src="{{ $item->gambar_barang ? asset('storage/gambar/'.$item->gambar_barang) : asset('noimage.jpg') }}" 
                                         alt="{{ $item->nama_barang }}" 
                                         style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                                </td>
                                <td class="py-3 fw-semibold">{{ $item->nama_barang }}</td>
                                <td class="py-3">
                                    @php
                                        preg_match('/^(\d+(?:\.\d+)?)/', trim($item->stok_barang), $matches);
                                        $stokAngka = isset($matches[1]) ? floatval($matches[1]) : 0;
                                    @endphp
                                    <span class="badge {{ $stokAngka <= 0 ? 'bg-danger' : ($stokAngka < 10 ? 'bg-warning' : 'bg-success') }}">
                                        {{ $item->stok_barang }}
                                    </span>
                                </td>
                                <td class="py-3 text-success fw-bold">Rp {{ number_format($item->harga_barang, 0, ',', '.') }}</td>
                                <td class="py-3 text-center">
                                    <button class="btn btn-sm btn-warning me-1" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->id_barang }}">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" onclick="showDeleteModal({{ $item->id_barang }}, '{{ $item->nama_barang }}')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>

                            {{-- Modal Edit --}}
                            <div class="modal fade" id="modalEdit{{ $item->id_barang }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header" style="background: #550000; color: white;">
                                            <h5 class="modal-title"><i class="bi bi-pencil me-2"></i>Edit Produk</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="{{ route('produk.updateStok', $item->id_barang) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Nama Produk</label>
                                                    <input type="text" name="nama_barang" class="form-control" value="{{ $item->nama_barang }}" required>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Stok</label>
                                                            <input type="text" name="stok_barang" class="form-control" value="{{ $item->stok_barang }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Harga</label>
                                                            <input type="number" name="harga_barang" class="form-control" value="{{ $item->harga_barang }}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Gambar Produk</label>
                                                    <input type="file" name="gambar_barang" class="form-control" accept="image/*">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-success">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr id="emptyRow">
                                <td colspan="6" class="text-center py-4">
                                    <i class="bi bi-inbox" style="font-size: 3rem; color: #d1d5db;"></i>
                                    <p class="text-muted mt-2">Belum ada produk</p>
                                </td>
                            </tr>
                        @endforelse
                        <tr id="noResultRow" style="display: none;">
                            <td colspan="6" class="text-center py-4">
                                <i class="bi bi-search" style="font-size: 3rem; color: #d1d5db;"></i>
                                <p class="text-muted mt-2">Produk tidak ditemukan</p>
                                <small class="text-muted">Coba kata kunci lain</small>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Modal Tambah Produk --}}
<div class="modal fade" id="modalTambahProduk" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: #550000; color: white;">
                <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Tambah Produk Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Produk <span class="text-danger">*</span></label>
                        <input type="text" name="nama_barang" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Stok <span class="text-danger">*</span></label>
                                <input type="text" name="stok_barang" class="form-control" placeholder="Contoh: 50 kg" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Harga <span class="text-danger">*</span></label>
                                <input type="number" name="harga_barang" class="form-control" placeholder="Contoh: 15000" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Gambar Produk</label>
                        <input type="file" name="gambar_barang" class="form-control" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Tambah Produk</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Konfirmasi Hapus --}}
<div class="modal fade" id="modalHapusProduk" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: #dc3545; color: white;">
                <h5 class="modal-title"><i class="bi bi-exclamation-triangle me-2"></i>Konfirmasi Hapus</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center py-3">
                    <i class="bi bi-trash" style="font-size: 4rem; color: #dc3545;"></i>
                    <h5 class="mt-3 mb-2">Apakah Anda yakin ingin menghapus produk</h5>
                    <p class="fw-bold text-danger mb-1" id="namaProdukHapus"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>Batal
                </button>
                <button type="button" class="btn btn-danger" id="btnKonfirmasiHapus">
                    <i class="bi bi-trash me-1"></i>Hapus
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .page-header {
        padding: 1.5rem 0;
    }

    .input-group-text {
        border-radius: 8px 0 0 8px;
    }

    .form-control {
        border-radius: 0 8px 8px 0;
    }

    .form-control:focus {
        border-color: #550000;
        box-shadow: 0 0 0 0.2rem rgba(85, 0, 0, 0.15);
    }

    .table th {
        font-weight: 600;
        color: #4b5563;
        border-bottom: 2px solid #e9ecef;
    }

    .table td {
        vertical-align: middle;
    }

    .table tbody tr:hover {
        background: #f8f9fa;
    }

    /* Highlight search result */
    .highlight {
        background-color: #fef3c7;
        transition: background-color 0.3s ease;
    }

    body.dark-mode .highlight {
        background-color: rgba(251, 191, 36, 0.2);
    }

    body.dark-mode .table {
        color: #e5e7eb;
    }

    body.dark-mode .table thead {
        background: #1a1a2e !important;
    }

    body.dark-mode .table tbody tr:hover {
        background: #1a1a2e;
    }

    body.dark-mode .modal-content {
        background: #16213e;
        color: #e5e7eb;
    }

    body.dark-mode .form-control {
        background: #1a1a2e;
        border-color: rgba(85, 0, 0, 0.3);
        color: #e5e7eb;
    }

    body.dark-mode .form-control:focus {
        background: #1a1a2e;
        border-color: #550000;
        color: #e5e7eb;
    }

    body.dark-mode .input-group-text {
        background: #1a1a2e;
        border-color: rgba(85, 0, 0, 0.3);
        color: #e5e7eb;
    }

    body.dark-mode .card {
        background: #16213e;
    }

    /* MOBILE RESPONSIVE TABLE */
    @media (max-width: 768px) {
        .page-header {
            padding: 1rem 0;
            margin-bottom: 1rem !important;
        }

        .page-header h2 {
            font-size: 1.3rem;
        }

        /* Hide kolom No dan ubah padding */
        .table th:first-child,
        .table td:first-child {
            display: none;
        }

        .table th,
        .table td {
            padding: 0.75rem 0.5rem !important;
            font-size: 0.85rem;
        }

        /* Gambar lebih kecil di mobile */
        .table td img {
            width: 40px !important;
            height: 40px !important;
        }

        /* Nama produk lebih kecil */
        .table td.fw-semibold {
            font-size: 0.8rem !important;
        }

        /* Badge stok lebih kecil */
        .table .badge {
            font-size: 0.7rem !important;
            padding: 0.25rem 0.4rem !important;
        }

        /* Harga lebih kecil */
        .table td.text-success {
            font-size: 0.8rem !important;
        }

        /* Tombol aksi lebih kecil */
        .table .btn-sm {
            padding: 0.35rem 0.5rem !important;
            font-size: 0.75rem !important;
        }

        .table .btn-sm i {
            font-size: 0.85rem;
        }

        /* Header tabel */
        .table thead th {
            font-size: 0.75rem !important;
            padding: 0.65rem 0.5rem !important;
        }

        /* Search bar lebih compact */
        .card.mb-3 {
            margin-bottom: 0.75rem !important;
        }

        .card-body {
            padding: 0.75rem !important;
        }

        .input-group-text {
            padding: 0.5rem 0.75rem;
        }

        .form-control {
            padding: 0.5rem 0.75rem;
            font-size: 0.85rem;
        }
    }

    @media (max-width: 576px) {
        .page-header h2 {
            font-size: 1.15rem;
        }

        /* Kolom gambar lebih kecil lagi */
        .table td img {
            width: 35px !important;
            height: 35px !important;
            border-radius: 6px !important;
        }

        /* Nama produk */
        .table td.fw-semibold {
            font-size: 0.75rem !important;
            max-width: 100px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Badge stok */
        .table .badge {
            font-size: 0.65rem !important;
            padding: 0.2rem 0.35rem !important;
        }

        /* Harga */
        .table td.text-success {
            font-size: 0.75rem !important;
        }

        /* Tombol aksi lebih kecil */
        .table .btn-sm {
            padding: 0.3rem 0.45rem !important;
            font-size: 0.7rem !important;
        }

        .table .btn-sm i {
            font-size: 0.8rem;
        }

        .table .btn-sm.me-1 {
            margin-right: 0.25rem !important;
        }

        /* Header tabel */
        .table thead th {
            font-size: 0.7rem !important;
            padding: 0.6rem 0.4rem !important;
        }

        .table th,
        .table td {
            padding: 0.6rem 0.4rem !important;
        }

        /* Search bar */
        .input-group-text {
            padding: 0.45rem 0.65rem;
        }

        .form-control {
            padding: 0.45rem 0.65rem;
            font-size: 0.8rem;
        }

        ::placeholder {
            font-size: 0.75rem;
        }
    }

    @media (max-width: 400px) {
        .page-header h2 {
            font-size: 1.05rem;
        }

        /* Gambar sangat kecil */
        .table td img {
            width: 32px !important;
            height: 32px !important;
        }

        /* Nama produk */
        .table td.fw-semibold {
            font-size: 0.7rem !important;
            max-width: 80px;
        }

        /* Badge stok */
        .table .badge {
            font-size: 0.6rem !important;
            padding: 0.15rem 0.3rem !important;
        }

        /* Harga */
        .table td.text-success {
            font-size: 0.7rem !important;
        }

        /* Tombol aksi stack vertikal */
        .table td.text-center {
            white-space: nowrap;
        }

        .table .btn-sm {
            padding: 0.25rem 0.4rem !important;
            font-size: 0.65rem !important;
        }

        .table .btn-sm i {
            font-size: 0.75rem;
        }
    }
</style>

@push('scripts')
<script>
    // Realtime Search Function
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase().trim();
        const rows = document.querySelectorAll('.produk-row');
        const noResultRow = document.getElementById('noResultRow');
        const emptyRow = document.getElementById('emptyRow');
        const searchResult = document.getElementById('searchResult');
        const foundCount = document.getElementById('foundCount');
        
        let visibleCount = 0;

        rows.forEach(row => {
            const namaProduk = row.getAttribute('data-nama');
            
            if (namaProduk.includes(searchTerm)) {
                row.style.display = '';
                visibleCount++;
                
                // Add highlight effect
                if (searchTerm !== '') {
                    row.classList.add('highlight');
                    setTimeout(() => row.classList.remove('highlight'), 300);
                }
            } else {
                row.style.display = 'none';
            }
        });

        // Show/hide search result info
        if (searchTerm === '') {
            searchResult.style.display = 'none';
            noResultRow.style.display = 'none';
        } else {
            searchResult.style.display = 'inline';
            foundCount.textContent = visibleCount;
            
            // Show "no result" message if no products found
            if (visibleCount === 0) {
                noResultRow.style.display = '';
            } else {
                noResultRow.style.display = 'none';
            }
        }

        // Hide empty row when searching
        if (emptyRow) {
            emptyRow.style.display = 'none';
        }
    });

    // Clear search on Escape key
    document.getElementById('searchInput').addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            this.value = '';
            this.dispatchEvent(new Event('keyup'));
            this.blur();
        }
    });

    function showDeleteModal(id, nama) {
        const modal = new bootstrap.Modal(document.getElementById('modalHapusProduk'));
        document.getElementById('namaProdukHapus').textContent = nama;
        const btnKonfirmasiHapus = document.getElementById('btnKonfirmasiHapus');

        btnKonfirmasiHapus.onclick = function() {
            fetch(`/produk/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert(data.message || 'Gagal menghapus produk');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menghapus produk');
            });
        };

        modal.show();
    }
</script>
@endpush
@endsection

