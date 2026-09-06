@extends('layouts.admin')

@section('content')
<div class="container py-3">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-white py-3">
                    <h5 class="fw-bold mb-0" style="color: #550000;"><i class="bi bi-plus-circle me-2"></i>Tambah Produk Baru</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Nama Barang --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Barang</label>
                            <input type="text" name="nama_barang" class="form-control" placeholder="Contoh: Beras Ramos, Minyak Goreng Tropical, Telur Ayam" required>
                        </div>

                        <div class="row">
                            {{-- Harga Satuan --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Harga Jual (Rp)</label>
                                <input type="number" name="harga_barang" class="form-control" placeholder="15000" min="0" required>
                            </div>

                            {{-- Jumlah Stok & Satuan Sembako --}}
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-semibold">Jumlah Stok</label>
                                <input type="number" step="any" name="jumlah_stok" class="form-control" placeholder="50" min="0" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-semibold text-dark">Satuan Barang</label>
                                <select name="satuan" class="form-select form-select-sm" required>
                                    <option value="" disabled selected>-- Pilih Satuan --</option>

                                    {{-- KHUSUS GAS & WADAH --}}
                                    <optgroup label="Gas Elpiji & Bahan Bakar">
                                        <option value="tabung (3kg)">tabung (3kg) - Gas Melon</option>
                                        <option value="tabung (5.5kg)">tabung (5.5kg) - Bright Gas</option>
                                        <option value="tabung (12kg)">tabung (12kg) - Elpiji Biru / Bright</option>
                                        <option value="tabung">tabung (Umum)</option>
                                    </optgroup>

                                    {{-- KHUSUS AIR GALON --}}
                                    <optgroup label="Galon Air Minum">
                                        <option value="galon (19 liter)">galon (19 liter) - Aqua / Vit</option>
                                        <option value="galon (15 liter)">galon (15 liter) - Le Minerale</option>
                                        <option value="galon">galon (Umum)</option>
                                    </optgroup>

                                    {{-- SATUAN ECERAN UMUM --}}
                                    <optgroup label="Eceran & Kemasan">
                                        <option value="pcs">pcs (Satuan umum)</option>
                                        <option value="bungkus">bungkus</option>
                                        <option value="botol">botol</option>
                                        <option value="sachet">sachet</option>
                                        <option value="renceng">renceng</option>
                                        <option value="dus">dus / karton</option>
                                    </optgroup>

                                    {{-- SATUAN TIMBANG / CURAH --}}
                                    <optgroup label="Timbang & Takar (Bisa Desimal)">
                                        <option value="kg">kg (Kilogram)</option>
                                        <option value="gram">gram</option>
                                        <option value="liter">liter</option>
                                    </optgroup>
                                </select>
                            </div>

                        {{-- Upload Gambar --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Foto Produk (Opsional)</label>
                            <input type="file" name="gambar_barang" class="form-control" accept="image/*">
                            <small class="text-muted">Format gambar: JPG, PNG, WEBP. Maksimal 2MB.</small>
                        </div>
                        {{-- PENGATURAN TUKAR WADAH (GAS / GALON) --}}
                                    <div class="card border-0 bg-light p-3 rounded-3 mb-3">
                                        <div class="form-check form-switch mb-2">
                                            <input class="form-check-input" type="checkbox" role="switch" id="is_tukar_wadah" name="is_tukar_wadah" value="1"
                                                {{ old('is_tukar_wadah', $barang->is_tukar_wadah ?? false) ? 'checked' : '' }}
                                                onchange="toggleWadahFields(this.checked)">
                                            <label class="form-check-label fw-bold text-dark" for="is_tukar_wadah">
                                                <i class="bi bi-arrow-repeat me-1 text-danger"></i>Produk Sistem Tukar Wadah (Gas / Galon)
                                            </label>
                                        </div>
                                        <small class="text-muted d-block mb-2" style="font-size: 0.8rem;">
                                            Aktifkan jika produk ini memiliki sirkulasi fisik wadah isi dan kosong.
                                        </small>

                                        <div id="wadahFields" style="{{ old('is_tukar_wadah', $barang->is_tukar_wadah ?? false) ? 'display: block;' : 'display: none;' }}">
                                            <div class="row g-2 mt-1">
                                                <div class="col-md-6">
                                                    <label class="form-label small fw-semibold text-dark">Harga Pembelian Wadah Baru (Rp)</label>
                                                    <input type="number" name="harga_wadah" class="form-control form-control-sm"
                                                        placeholder="Contoh: 150000"
                                                        value="{{ old('harga_wadah', $barang->harga_wadah ?? 0) }}">
                                                    <small class="text-muted" style="font-size: 0.72rem;">Biaya tambahan jika pelanggan membeli wadah baru (tanpa membawa wadah kosong).</small>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label small fw-semibold text-dark">Stok Wadah Kosong Saat Ini</label>
                                                    <input type="number" name="stok_kosong" class="form-control form-control-sm"
                                                        placeholder="Contoh: 5"
                                                        value="{{ old('stok_kosong', $barang->stok_kosong ?? 0) }}">
                                                    <small class="text-muted" style="font-size: 0.72rem;">Jumlah tabung atau galon kosong yang ada di gudang/toko.</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <script>
                                        function toggleWadahFields(isChecked) {
                                            document.getElementById('wadahFields').style.display = isChecked ? 'block' : 'none';
                                        }
                                    </script>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.produk') }}" class="btn btn-light border px-4">Batal</a>
                            <button type="submit" class="btn text-white px-4 fw-semibold" style="background-color: #550000;">Simpan Produk</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
