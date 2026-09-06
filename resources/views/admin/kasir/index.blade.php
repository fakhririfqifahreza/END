@extends('layouts.admin')

@section('content')
<div class="container-fluid px-3 px-md-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold" style="color: #550000; margin: 0;"><i class="bi bi-calculator me-2"></i>Mesin Kasir (POS)</h3>
        <span class="badge bg-light text-dark border p-2"><i class="bi bi-clock me-1"></i> {{ date('d M Y') }}</span>
    </div>

    <div class="row g-3">
        {{-- BAGIAN KIRI: DAFTAR BARANG --}}
        <div class="col-lg-7">
            <div class="card shadow-sm border-0 rounded-3 h-100">
                <div class="card-body p-3">
                    <div class="mb-3">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" id="posSearch" class="form-control border-start-0" placeholder="Ketik nama sembako (beras, telur, mie, minyak)...">
                        </div>
                    </div>

                    <div class="row g-2 overflow-auto" style="max-height: 68vh;" id="productGrid">
                        @forelse($produks as $produk)
                            @php
                                $harga = $produk->harga_barang ?? 0;
                                preg_match('/^(\d+(?:\.\d+)?)\s*(.*)$/', trim($produk->stok_barang), $m);
                                $stokAngka = isset($m[1]) ? floatval($m[1]) : 0;
                                $satuan = isset($m[2]) && !empty($m[2]) ? strtolower(trim($m[2])) : 'pcs';
                                $isTimbang = in_array($satuan, ['kg', 'liter', 'gram', 'ml']);
                                $stokDisplay = $isTimbang ? round($stokAngka, 2) : round($stokAngka);
                            @endphp

                            <div class="card h-100 border rounded-3 p-2 text-center product-card {{ $stokAngka <= 0 ? 'out-of-stock' : '' }}"
                                onclick="addToCart({{ $produk->id_barang }}, '{{ addslashes($produk->nama_barang) }}', {{ $harga }}, {{ $stokAngka }}, '{{ $satuan }}', {{ $produk->is_tukar_wadah ? 1 : 0 }}, {{ $produk->harga_wadah ?? 0 }})">

                                @if($produk->gambar_barang)
                                    <img src="{{ asset('storage/' . $produk->gambar_barang) }}" alt="{{ $produk->nama_barang }}"
                                        class="img-fluid rounded mb-2" style="height: 80px; width: 100%; object-fit: contain; background: #fafafa;">
                                @else
                                    <div class="rounded mb-2 d-flex align-items-center justify-content-center" style="height: 80px; background: #f1f5f9;">
                                        <i class="bi bi-box-seam text-muted" style="font-size: 1.8rem;"></i>
                                    </div>
                                @endif

                                <div class="fw-semibold text-truncate mb-1" title="{{ $produk->nama_barang }}">{{ $produk->nama_barang }}</div>
                                <div class="text-danger fw-bold mb-1">Rp {{ number_format($harga, 0, ',', '.') }} <small class="text-muted">/ {{ $satuan }}</small></div>

                                <div class="d-flex justify-content-center gap-1 flex-wrap">
                                    <small class="text-muted">Isi: <span class="badge {{ $stokAngka > 0 ? 'bg-secondary' : 'bg-danger' }}">{{ $stokDisplay }} {{ $satuan }}</span></small>
                                    @if($produk->is_tukar_wadah)
                                        <small class="text-muted">Kosong: <span class="badge bg-warning text-dark">{{ $produk->stok_kosong ?? 0 }}</span></small>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center py-5 text-muted">Belum ada barang yang terdaftar.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- BAGIAN KANAN: RINCIAN KERANJANG & CHECKOUT --}}
        <div class="col-lg-5">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="fw-bold mb-0" style="color: #550000;"><i class="bi bi-cart3 me-2"></i>Keranjang Kasir</h5>
                </div>
                <div class="card-body p-3">
                    <form action="{{ route('admin.kasir.store') }}" method="POST" id="formKasir">
                        @csrf

                        <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-dark">Nama Pembeli</label>
                            <input type="text" name="nama_pelanggan" class="form-control form-control-sm" placeholder="Pembeli Langsung (Opsional)">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-dark">
                                <i class="bi bi-whatsapp text-success me-1"></i>No. WhatsApp Pelanggan
                            </label>
                            <input type="tel" name="no_wa_pelanggan" class="form-control form-control-sm" placeholder="Contoh: 08123456789 (Opsional)">
                            <small class="text-muted" style="font-size: 0.75rem;">Struk digital dikirim ke nomor ini.</small>
                        </div>
                    </div>

                        {{-- Tabel Keranjang --}}
                        <div class="table-responsive mb-3" style="max-height: 200px; overflow-y: auto;">
                            <table class="table table-sm align-middle mb-0">
                                <thead class="table-light small">
                                    <tr>
                                        <th>Barang</th>
                                        <th style="width: 140px;" class="text-center">Jumlah</th>
                                        <th class="text-end">Subtotal</th>
                                        <th style="width: 30px;"></th>
                                    </tr>
                                </thead>
                                <tbody id="cartTableBody">
                                    <tr id="emptyCartRow">
                                        <td colspan="4" class="text-center text-muted py-4">Belum ada barang yang dipilih</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        {{-- Total Belanja --}}
                        <div class="bg-light p-3 rounded-3 mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-semibold">Total Tagihan:</span>
                                <span class="h4 fw-bold text-danger mb-0" id="displayTotal">Rp 0</span>
                            </div>
                            <hr class="my-2">

                            {{-- Pilihan Metode Pembayaran --}}
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-dark d-block">Pilih Metode Pembayaran:</label>
                                <div class="btn-group w-100" role="group">
                                    <input type="radio" class="btn-check" name="metode_pembayaran" id="metodeTunai" value="tunai" checked onchange="switchPaymentMethod('tunai')">
                                    <label class="btn btn-outline-danger btn-sm fw-semibold" for="metodeTunai">
                                        <i class="bi bi-cash me-1"></i>Tunai (Cash)
                                    </label>

                                    <input type="radio" class="btn-check" name="metode_pembayaran" id="metodeQris" value="qris" onchange="switchPaymentMethod('qris')">
                                    <label class="btn btn-outline-danger btn-sm fw-semibold" for="metodeQris">
                                        <i class="bi bi-qr-code-scan me-1"></i>QRIS
                                    </label>

                                    <input type="radio" class="btn-check" name="metode_pembayaran" id="metodeTransfer" value="transfer_bank" onchange="switchPaymentMethod('transfer_bank')">
                                    <label class="btn btn-outline-danger btn-sm fw-semibold" for="metodeTransfer">
                                        <i class="bi bi-bank me-1"></i>Transfer Bank
                                    </label>
                                </div>
                            </div>

                            {{-- KONDISI 1: FORM PEMBAYARAN TUNAI (CASH) --}}
                            <div id="sectionTunai">
                                <div class="mb-2">
                                    <label class="form-label small fw-bold">Uang Diterima (Rp):</label>
                                    <input type="number" name="bayar" id="inputBayar" class="form-control form-control-lg fw-bold text-end" placeholder="0" min="0" oninput="calculateChange()">
                                </div>

                                <div class="d-flex gap-1 mb-2 flex-wrap">
                                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="setExactAmount()">Uang Pas</button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="addCash(10000)">+10k</button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="addCash(20000)">+20k</button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="addCash(50000)">+50k</button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="addCash(100000)">+100k</button>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <span class="fw-bold">Kembalian:</span>
                                    <span class="h5 fw-bold text-success mb-0" id="displayKembalian">Rp 0</span>
                                </div>
                            </div>

                            {{-- KONDISI 2: TAMPILAN QRIS --}}
                            <div id="sectionQris" style="display: none;">
                                <div class="alert alert-warning border-warning p-2 small mb-0 rounded-3">
                                    <div class="fw-bold mb-1"><i class="bi bi-info-circle-fill me-1"></i>Prosedur Pembayaran QRIS:</div>
                                    <ol class="ps-3 mb-1">
                                        <li>Tunjukkan barcode QRIS Waroeng 86 ke pembeli.</li>
                                        <li>Tunggu sampai pembeli memperlihatkan <strong>bukti pembayaran berhasil</strong> di layar ponselnya.</li>
                                        <li>Jika nominal sudah sesuai, klik tombol <strong>Sudah Dibayar</strong> di bawah.</li>
                                    </ol>
                                </div>
                            </div>

                            {{-- KONDISI 3: TAMPILAN TRANSFER BANK --}}
                            <div id="sectionTransfer" style="display: none;">
                                <div class="alert alert-info border-info p-2 small mb-0 rounded-3">
                                    <div class="fw-bold mb-1"><i class="bi bi-bank2 me-1"></i>Rekening Resmi Waroeng 86:</div>
                                    <div class="p-2 bg-white rounded border mb-2">
                                        <div class="fw-bold text-dark">BCA: 8820-192-888</div>
                                        <small class="text-muted">Atas Nama: <strong>Waroeng 86</strong></small>
                                    </div>
                                    <small class="text-dark d-block">
                                        <i class="bi bi-check2-circle text-success me-1"></i>Berikan nomor rekening ke pembeli, cek mutasi/bukti transfer, lalu tekan tombol <strong>Sudah Dibayar</strong>.
                                    </small>
                                </div>
                            </div>
                        </div>

                        {{-- Tombol Konfirmasi Selesai --}}
                        <button type="submit" id="btnSubmit" class="btn btn-danger w-100 py-2 fw-bold" style="background-color: #550000; border-color: #550000;" disabled>
                            <i class="bi bi-check-circle me-1"></i> Selesaikan Pembayaran (Tunai)
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .product-card {
        cursor: pointer;
        transition: all 0.2s ease;
        background: #ffffff;
    }
    .product-card:hover {
        border-color: #550000 !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    }
    .product-card.out-of-stock {
        opacity: 0.5;
        cursor: not-allowed;
        background: #f8f9fa;
    }
</style>

@push('scripts')
<script>
    let cart = [];
    let grandTotal = 0;
    let selectedMethod = 'tunai';

    function isTimbangan(unit) {
        const timbangan = ['kg', 'liter', 'gram', 'ml'];
        return timbangan.includes((unit || '').toLowerCase().trim());
    }

    // Filter Pencarian
    document.getElementById('posSearch').addEventListener('input', function() {
        const query = this.value.toLowerCase();
        document.querySelectorAll('.product-item').forEach(item => {
            const name = item.getAttribute('data-name');
            item.style.display = name.includes(query) ? 'block' : 'none';
        });
    });

    // Tambah Barang ke Keranjang
    function addToCart(id, name, price, stock, unit, isTukarWadah = 0, hargaWadah = 0) {
        if (stock <= 0) {
            alert('Stok barang ini habis!');
            return;
        }

        const existing = cart.find(item => item.id === id);
        const timbang = isTimbangan(unit);

        if (existing) {
            if (existing.qty + 1 > stock) {
                alert('Jumlah melebihi stok yang tersedia (' + stock + ' ' + unit + ')');
                return;
            }
            existing.qty = timbang ? parseFloat((existing.qty + 1).toFixed(2)) : parseInt(existing.qty) + 1;
        } else {
            cart.push({
                id: id,
                name: name,
                price: price,
                stock: stock,
                unit: unit,
                qty: 1,
                isTukarWadah: isTukarWadah,
                hargaWadah: hargaWadah,
                tukarWadah: 1 // Default: Tukar wadah (hanya bayar isi)
            });
        }
        renderCart();
    }

    function toggleWadah(id, value) {
        const item = cart.find(i => i.id === id);
        if (item) {
            item.tukarWadah = parseInt(value);
            renderCart();
        }
    }

    function stepQty(id, delta) {
        const item = cart.find(i => i.id === id);
        if (!item) return;

        const timbang = isTimbangan(item.unit);
        let newQty = timbang ? parseFloat((item.qty + delta).toFixed(2)) : parseInt(item.qty) + delta;

        if (newQty <= 0) {
            removeFromCart(id);
        } else if (newQty > item.stock) {
            alert('Jumlah melebihi stok yang tersedia!');
        } else {
            item.qty = newQty;
            renderCart();
        }
    }

    function updateQty(id, newQty) {
        const item = cart.find(i => i.id === id);
        if (!item) return;

        const timbang = isTimbangan(item.unit);
        let parsed = timbang ? parseFloat(newQty) : parseInt(newQty);

        if (isNaN(parsed) || parsed <= 0) return;

        if (parsed > item.stock) {
            alert('Jumlah melebihi stok (' + item.stock + ' ' + item.unit + ')');
            item.qty = item.stock;
        } else {
            item.qty = timbang ? parseFloat(parsed.toFixed(2)) : parsed;
        }
        renderCart();
    }

    function removeFromCart(id) {
        cart = cart.filter(i => i.id !== id);
        renderCart();
    }

    function renderCart() {
        const tbody = document.getElementById('cartTableBody');
        tbody.innerHTML = '';
        grandTotal = 0;

        if (cart.length === 0) {
            tbody.innerHTML = '<tr id="emptyCartRow"><td colspan="4" class="text-center text-muted py-4">Belum ada barang yang dipilih</td></tr>';
            document.getElementById('displayTotal').innerText = 'Rp 0';
            validateCheckoutButton();
            return;
        }

        cart.forEach((item, index) => {
            const hargaEfektif = item.price + (item.isTukarWadah && item.tukarWadah === 0 ? item.hargaWadah : 0);
            const subtotal = Math.round(hargaEfektif * item.qty);
            grandTotal += subtotal;
            const timbang = isTimbangan(item.unit);

            let wadahSelector = '';
            if (item.isTukarWadah) {
                wadahSelector = `
                    <div class="mt-1">
                        <select class="form-select form-select-sm py-0 ps-1 pe-3" style="font-size: 0.72rem;" onchange="toggleWadah(${item.id}, this.value)">
                            <option value="1" ${item.tukarWadah === 1 ? 'selected' : ''}>🔁 Tukar Wadah (Isi Saja)</option>
                            <option value="0" ${item.tukarWadah === 0 ? 'selected' : ''}>➕ Beli + Wadah Baru (+Rp ${item.hargaWadah.toLocaleString('id-ID')})</option>
                        </select>
                        <input type="hidden" name="items[${index}][tukar_wadah]" value="${item.tukarWadah}">
                    </div>
                `;
            }

            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>
                    <div class="fw-semibold small text-truncate" style="max-width: 140px;">${item.name}</div>
                    <small class="text-muted">@ Rp ${hargaEfektif.toLocaleString('id-ID')} / ${item.unit}</small>
                    ${wadahSelector}
                    <input type="hidden" name="items[${index}][id]" value="${item.id}">
                </td>
                <td>
                    <div class="input-group input-group-sm justify-content-center">
                        <button type="button" class="btn btn-outline-secondary px-2" onclick="stepQty(${item.id}, ${timbang ? -0.5 : -1})">-</button>
                        <input type="number"
                               step="any"
                               min="${timbang ? '0.01' : '1'}"
                               name="items[${index}][qty]"
                               class="form-control text-center p-0"
                               style="max-width: 50px;"
                               value="${item.qty}"
                               onchange="updateQty(${item.id}, this.value)">
                        <button type="button" class="btn btn-outline-secondary px-2" onclick="stepQty(${item.id}, ${timbang ? 0.5 : 1})">+</button>
                    </div>
                </td>
                <td class="text-end fw-bold small">Rp ${subtotal.toLocaleString('id-ID')}</td>
                <td class="text-end">
                    <button type="button" class="btn btn-sm text-danger p-0 border-0" onclick="removeFromCart(${item.id})">
                        <i class="bi bi-x-circle"></i>
                    </button>
                </td>
            `;
            tbody.appendChild(tr);
        });

        document.getElementById('displayTotal').innerText = 'Rp ' + grandTotal.toLocaleString('id-ID');
        validateCheckoutButton();
    }

    function switchPaymentMethod(method) {
        selectedMethod = method;
        document.getElementById('sectionTunai').style.display = (method === 'tunai') ? 'block' : 'none';
        document.getElementById('sectionQris').style.display = (method === 'qris') ? 'block' : 'none';
        document.getElementById('sectionTransfer').style.display = (method === 'transfer_bank') ? 'block' : 'none';

        const btn = document.getElementById('btnSubmit');
        if (method === 'tunai') {
            btn.innerHTML = '<i class="bi bi-check-circle me-1"></i> Selesaikan Pembayaran (Tunai)';
            calculateChange();
        } else if (method === 'qris') {
            btn.innerHTML = '<i class="bi bi-qr-code me-1"></i> Konfirmasi Pembayaran QRIS (Sudah Dibayar)';
            btn.disabled = grandTotal <= 0;
        } else if (method === 'transfer_bank') {
            btn.innerHTML = '<i class="bi bi-check2-all me-1"></i> Konfirmasi Transfer Bank (Sudah Dibayar)';
            btn.disabled = grandTotal <= 0;
        }
    }

    function calculateChange() {
        if (selectedMethod !== 'tunai') return;

        const payVal = parseFloat(document.getElementById('inputBayar').value) || 0;
        const change = payVal - grandTotal;
        const displayKembalian = document.getElementById('displayKembalian');
        const btnSubmit = document.getElementById('btnSubmit');

        if (payVal >= grandTotal && grandTotal > 0) {
            displayKembalian.innerText = 'Rp ' + change.toLocaleString('id-ID');
            displayKembalian.className = 'h5 fw-bold text-success mb-0';
            btnSubmit.disabled = false;
        } else {
            displayKembalian.innerText = payVal > 0 ? 'Kurang Rp ' + Math.abs(change).toLocaleString('id-ID') : 'Rp 0';
            displayKembalian.className = 'h5 fw-bold text-danger mb-0';
            btnSubmit.disabled = true;
        }
    }

    function validateCheckoutButton() {
        if (selectedMethod === 'tunai') {
            calculateChange();
        } else {
            document.getElementById('btnSubmit').disabled = grandTotal <= 0;
        }
    }

    function setExactAmount() {
        document.getElementById('inputBayar').value = grandTotal;
        calculateChange();
    }

    function addCash(amount) {
        const current = parseFloat(document.getElementById('inputBayar').value) || 0;
        document.getElementById('inputBayar').value = current + amount;
        calculateChange();
    }
</script>
@endpush
@endsection
