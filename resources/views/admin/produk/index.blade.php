@extends('layouts.admin')

@section('content')
<div class="container-fluid px-3 px-md-4 py-3">
    {{-- ALERT NOTIFIKASI --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-1"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <div>
            <h3 class="fw-bold mb-0" style="color: #550000;">
                <i class="bi bi-box-seam me-2"></i>Kelola Produk & Stok Sembako
            </h3>
            <small class="text-muted">Kelola harga, nama barang, dan stok satuan warung (kg, liter, pcs, tabung, galon)</small>
        </div>
        <a href="{{ route('admin.produk.create') }}" class="btn text-white fw-semibold px-3 py-2" style="background-color: #550000;">
            <i class="bi bi-plus-lg me-1"></i> Tambah Produk
        </a>
    </div>

    {{-- KARTU DAFTAR PRODUK --}}
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-3">
            {{-- FORM PENCARIAN --}}
            <div class="row mb-3">
                <div class="col-md-5">
                    <form action="{{ route('admin.produk') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari nama sembako..." value="{{ request('search') }}">
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                            @if(request('search'))
                                <a href="{{ route('admin.produk') }}" class="btn btn-outline-danger">
                                    <i class="bi bi-x-lg"></i>
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            {{-- TABEL DATA PRODUK --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr class="small text-muted">
                            <th style="width: 60px;" class="text-center">No</th>
                            <th style="width: 80px;" class="text-center">Foto</th>
                            <th>Nama Barang</th>
                            <th>Harga Jual (Isi)</th>
                            <th style="min-width: 190px;">Sisa Stok & Status Wadah</th>
                            <th style="width: 130px;" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($produks as $index => $item)
                            @php
                                preg_match('/^(\d+(?:\.\d+)?)/', (string)$item->stok_barang, $m);
                                $stokAngka = isset($m[1]) ? floatval($m[1]) : 0;
                            @endphp
                            <tr>
                                <td class="text-center fw-semibold text-muted">
                                    {{ $produks->firstItem() + $index }}
                                </td>
                                <td class="text-center">
                                    @if($item->gambar_barang)
                                        <img src="{{ asset('storage/' . $item->gambar_barang) }}" alt="{{ $item->nama_barang }}"
                                             class="rounded border" style="width: 50px; height: 50px; object-fit: contain; background: #fafafa;">
                                    @else
                                        <div class="rounded border d-flex align-items-center justify-content-center mx-auto"
                                             style="width: 50px; height: 50px; background: #f8f9fa;">
                                            <i class="bi bi-box-seam text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $item->nama_barang }}</div>
                                    <small class="text-muted">ID: #{{ $item->id_barang }}</small>
                                </td>
                                <td>
                                    <span class="fw-bold text-danger fs-6">
                                        Rp {{ number_format($item->harga_barang, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td>
                                    {{-- KONDISI 1: JIKA PRODUK TUKAR WADAH (GAS/GALON) --}}
                                    @if($item->is_tukar_wadah)
                                        <div class="d-flex flex-column gap-1">
                                            <span class="badge {{ $stokAngka > 5 ? 'bg-success' : ($stokAngka > 0 ? 'bg-warning text-dark' : 'bg-danger') }} px-2 py-1 text-start">
                                                <i class="bi bi-box-seam me-1"></i>Isi Siap Jual: <strong>{{ $item->stok_barang }}</strong>
                                            </span>
                                            <span class="badge bg-warning-subtle text-dark border border-warning-subtle px-2 py-1 text-start" title="Jumlah wadah kosong yang tersedia di warung">
                                                <i class="bi bi-arrow-repeat me-1"></i>Wadah Kosong: <strong>{{ $item->stok_kosong ?? 0 }} unit</strong>
                                            </span>
                                            <small class="text-muted" style="font-size: 0.72rem;">
                                                <i class="bi bi-tag me-1"></i>Beli Wadah Baru: +Rp {{ number_format($item->harga_wadah ?? 0, 0, ',', '.') }}
                                            </small>
                                        </div>
                                    {{-- KONDISI 2: PRODUK UMUM (SEMBAKO BIASA) --}}
                                    @else
                                        <span class="badge {{ $stokAngka > 5 ? 'bg-success' : ($stokAngka > 0 ? 'bg-warning text-dark' : 'bg-danger') }} px-2 py-1">
                                            {{ $item->stok_barang }}
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        {{-- Tombol Edit --}}
                                        <a href="{{ route('admin.produk.edit', $item->id_barang) }}" class="btn btn-sm btn-outline-primary" title="Edit Produk">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        {{-- Tombol Hapus --}}
                                        <form action="{{ route('admin.produk.destroy', $item->id_barang) }}" method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus produk {{ $item->nama_barang }}?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Produk">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    Belum ada produk yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            @if($produks->hasPages())
                <div class="d-flex justify-content-end mt-3">
                    {{ $produks->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
