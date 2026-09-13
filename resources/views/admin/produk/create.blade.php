@extends('layouts.admin')

@section('content')
<div class="container-fluid px-3 px-md-4 py-3">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-white py-3">
                    <h5 class="fw-bold mb-0" style="color: #550000;">
                        <i class="bi bi-plus-circle-fill me-2"></i>Tambah Produk Baru
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- NAMA BARANG --}}
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Nama Barang</label>
                            <input type="text" name="nama_barang" class="form-control form-control-sm" placeholder="Contoh: Beras Ramos, Minyak Goreng Tropical, Telur Ayam" value="{{ old('nama_barang') }}" required>
                        </div>

                        {{-- HARGA JUAL & JUMLAH STOK --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Harga Jual (Rp)</label>
                                <input type="number" name="harga_barang" class="form-control form-control-sm" placeholder="15000" value="{{ old('harga_barang') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Jumlah Stok</label>
                                <input type="text" name="stok_barang" class="form-control form-control-sm" placeholder="Contoh: 50 atau 10.5" value="{{ old('stok_barang') }}" required>
                            </div>
                        </div>

                        {{-- SATUAN BARANG (SELECT NORMAL) --}}
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Satuan Barang</label>
                            <select name="satuan" class="form-select form-select-sm" required>
                                <option value="" disabled selected>-- Pilih Satuan --</option>
                                <optgroup label="Gas Elpiji & Bahan Bakar">
                                    <option value="tabung (3kg)">tabung (3kg) - Gas Melon</option>
                                    <option value="tabung (5.5kg)">tabung (5.5kg) - Bright Gas</option>
                                    <option value="tabung (12kg)">tabung (12kg) - Elpiji Biru / Bright</option>
                                    <option value="tabung (Umum)">tabung (Umum)</option>
                                </optgroup>
                                <optgroup label="Galon Air Minum">
                                    <option value="galon (19 liter)">galon (19 liter) - Aqua / Vit</option>
                                    <option value="galon (15 liter)">galon (15 liter) - Le Minerale</option>
                                    <option value="galon (Umum)">galon (Umum)</option>
                                </optgroup>
                                <optgroup label="Eceran & Kemasan">
                                    <option value="pcs">pcs (Satuan umum)</option>
                                    <option value="bungkus">bungkus</option>
                                    <option value="botol">botol</option>
                                    <option value="sachet">sachet</option>
                                    <option value="renceng">renceng</option>
                                    <option value="dus / karton">dus / karton</option>
                                </optgroup>
                                <optgroup label="Timbang & Takar (Bisa Desimal)">
                                    <option value="kg">kg (kilogram)</option>
                                    <option value="gram">gram</option>
                                    <option value="liter">liter</option>
                                </optgroup>
                            </select>
                        </div>

                        {{-- FOTO PRODUK --}}
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Foto Produk (Opsional)</label>
                            <input type="file" name="gambar_barang" class="form-control form-control-sm" accept="image/*">
                            <small class="text-muted" style="font-size: 0.72rem;">Format gambar: JPG, PNG, WEBP. Maksimal 2MB.</small>
                        </div>

                        {{-- FITUR TUKAR WADAH --}}
                        <div class="card bg-light border-0 rounded-3 p-3 mb-4">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" name="is_tukar_wadah" id="is_tukar_wadah" value="1"
                                    {{ old('is_tukar_wadah') ? 'checked' : '' }} onchange="toggleWadahFields()">
                                <label class="form-check-label fw-bold text-dark" for="is_tukar_wadah" style="cursor: pointer;">
                                    <i class="bi bi-arrow-repeat text-danger me-1"></i> Produk Menggunakan Sistem Tukar Wadah (Gas / Galon)
                                </label>
                            </div>
                            <small class="text-muted d-block mb-3" style="font-size: 0.78rem;">
                                Aktifkan opsi ini jika penjualan barang melibatkan sirkulasi fisik tabung atau galon kosong.
                            </small>

                            <div class="row g-2" id="wadahFields" style="{{ old('is_tukar_wadah') ? '' : 'display: none;' }}">
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold">Biaya Tambahan Wadah Baru (Rp)</label>
                                    <input type="number" name="harga_wadah" class="form-control form-control-sm"
                                        placeholder="Contoh: 150000" value="{{ old('harga_wadah', 0) }}">
                                    <small class="text-muted" style="font-size: 0.72rem;">Dikenakan jika pembeli tidak membawa wadah kosong.</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold">Stok Wadah Kosong Awal</label>
                                    <input type="number" name="stok_kosong" class="form-control form-control-sm"
                                        placeholder="Jumlah tabung/galon kosong" value="{{ old('stok_kosong', 0) }}">
                                    <small class="text-muted" style="font-size: 0.72rem;">Jumlah tabung/galon kosong saat ini di warung.</small>
                                </div>
                            </div>
                        </div>

                        {{-- TOMBOL AKSI --}}
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.produk') }}" class="btn btn-sm btn-secondary px-3">Batal</a>
                            <button type="submit" class="btn btn-sm text-white px-4 fw-semibold" style="background-color: #550000;">
                                Simpan Produk
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleWadahFields() {
        const checkbox = document.getElementById('is_tukar_wadah');
        const container = document.getElementById('wadahFields');
        container.style.display = checkbox.checked ? 'flex' : 'none';
    }
</script>
@endsection
