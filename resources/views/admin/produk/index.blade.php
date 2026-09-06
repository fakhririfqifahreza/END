@extends('layouts.admin')

@section('content')
<div class="container-fluid px-3 px-md-4 py-3">
    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <div>
            <h3 class="fw-bold mb-0" style="color: #550000;">
                <i class="bi bi-box-seam me-2"></i>Kelola Produk & Stok Sembako
            </h3>
            <small class="text-muted">Kelola harga, nama barang, dan stok satuan warung (kg, liter, pcs, dll)</small>
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
                            <th>Harga Jual</th>
                            <th>Sisa Stok & Satuan</th>
                            <th style="width: 140px;" class="text-center">Aksi</th>
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
                                <td class="fw-bold text-danger">
                                    Rp {{ number_format($item->harga_barang, 0, ',', '.') }}
                                </td>
                               <td>
                                <span class="badge {{ $stokAngka > 5 ? 'bg-success' : ($stokAngka > 0 ? 'bg-warning text-dark' : 'bg-danger') }} px-2 py-1">
                                    Isi: {{ $item->stok_barang }}
                                </span>
                                @if($item->is_tukar_wadah)
                                    <span class="badge bg-warning text-dark px-2 py-1 d-block mt-1" title="Tabung/Galon Kosong">
                                        <i class="bi bi-arrow-repeat me-1"></i>Kosong: {{ $item->stok_kosong ?? 0 }}
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
