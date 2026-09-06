@extends('layouts.admin')

@section('content')
<div class="container-fluid px-3 px-md-4 py-3">
    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h3 class="fw-bold mb-0" style="color: #550000;">
                <i class="bi bi-receipt me-2"></i>Mengelola Transaksi
            </h3>
            <small class="text-muted">Pantau dan kelola seluruh riwayat transaksi kasir dan pesanan Waroeng 86</small>
        </div>
    </div>

    {{-- KARTU FILTER TRANSAKSI --}}
    <div class="card shadow-sm border-0 rounded-3 mb-4">
        <div class="card-body p-3">
            <form action="{{ route('admin.transaksi') }}" method="GET" class="row g-2 align-items-end">
                {{-- Input Pencarian Nama / Kode --}}
                <div class="col-md-4 col-sm-12">
                    <label class="form-label small fw-semibold text-muted mb-1">Cari Transaksi</label>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" name="search" class="form-control"
                               placeholder="Kode trx atau nama pelanggan..." value="{{ request('search') }}">
                    </div>
                </div>

                {{-- Tanggal Mulai --}}
                <div class="col-md-3 col-sm-6">
                    <label class="form-label small fw-semibold text-muted mb-1">Tanggal Mulai</label>
                    <input type="date" name="start_date" class="form-control form-control-sm"
                           value="{{ request('start_date') }}">
                </div>

                {{-- Tanggal Akhir --}}
                <div class="col-md-3 col-sm-6">
                    <label class="form-label small fw-semibold text-muted mb-1">Tanggal Akhir</label>
                    <input type="date" name="end_date" class="form-control form-control-sm"
                           value="{{ request('end_date') }}">
                </div>

                {{-- Tombol Aksi --}}
                <div class="col-md-2 col-sm-12 d-flex gap-1">
                    <button type="submit" class="btn btn-sm text-white w-100 fw-semibold" style="background-color: #550000;">
                        <i class="bi bi-filter me-1"></i> Filter
                    </button>
                    @if(request('search') || request('start_date') || request('end_date'))
                        <a href="{{ route('admin.transaksi') }}" class="btn btn-sm btn-outline-secondary" title="Reset Filter">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- KARTU TABEL TRANSAKSI --}}
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr class="small text-muted">
                            <th class="text-center" style="width: 50px;">No</th>
                            <th>Kode Trx</th>
                            <th>Nama Pelanggan</th>
                            <th>Tanggal Transaksi</th>
                            <th class="text-end">Total Belanja</th>
                            <th class="text-center">Status</th>
                            <th class="text-center" style="width: 90px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksis as $index => $trx)
                            @php
                                $namaTampil = $trx->nama_pelanggan ?: ($trx->user->name ?? 'Pembeli Langsung');
                            @endphp
                            <tr>
                                <td class="text-center text-muted fw-semibold">
                                    {{ $transaksis->firstItem() + $index }}
                                </td>
                                <td class="fw-bold text-dark">
                                    {{ $trx->kode_transaksi ?? 'TRX-' . $trx->id }}
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-person-circle fs-5 text-secondary"></i>
                                        <div>
                                            <span class="fw-semibold text-dark">{{ $namaTampil }}</span>
                                            @if($trx->user && $trx->user->email)
                                                <small class="d-block text-muted">{{ $trx->user->email }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="small">
                                    {{ date('d M Y, H:i', strtotime($trx->created_at)) }} WIB
                                </td>
                                <td class="text-end fw-bold text-danger">
                                    Rp {{ number_format($trx->total_harga, 0, ',', '.') }}
                                </td>
                                <td class="text-center">
                                    @if(($trx->metode_pembayaran ?? 'tunai') === 'qris')
                                        <span class="badge bg-primary px-2 py-1 rounded-pill small">
                                            <i class="bi bi-qr-code me-1"></i>QRIS
                                        </span>
                                    @elseif(($trx->metode_pembayaran ?? 'tunai') === 'transfer_bank')
                                        <span class="badge bg-info text-dark px-2 py-1 rounded-pill small">
                                            <i class="bi bi-bank me-1"></i>Transfer
                                        </span>
                                    @else
                                        <span class="badge bg-secondary px-2 py-1 rounded-pill small">
                                            <i class="bi bi-cash me-1"></i>Tunai
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-outline-primary px-2 py-1"
                                            onclick="showDetail({{ json_encode($trx) }})" title="Lihat Detail Transaksi">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-receipt fs-1 d-block mb-2 text-secondary"></i>
                                    Tidak ada data transaksi yang cocok dengan filter.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            @if($transaksis->hasPages())
                <div class="d-flex justify-content-end mt-3">
                    {{ $transaksis->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>

{{-- MODAL DETAIL TRANSAKSI --}}
<div class="modal fade" id="detailTransaksiModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 overflow-hidden shadow">
            <div class="modal-header text-white" style="background-color: #550000;">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-card-text me-2"></i>Detail Transaksi
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4 bg-light">
                {{-- INFORMASI PELANGGAN --}}
                <div class="bg-white p-3 rounded-3 shadow-sm mb-3">
                    <h6 class="fw-bold mb-3 d-flex align-items-center text-dark">
                        <i class="bi bi-person me-2 fs-5"></i>Informasi Pelanggan
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <small class="text-muted d-block">Nama Pelanggan</small>
                            <span class="fw-semibold text-dark" id="modalNamaPelanggan">-</span>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block">Email Penjaga</small>
                            <span class="fw-semibold text-dark" id="modalEmail">-</span>
                        </div>
                    </div>
                </div>

                {{-- INFORMASI TRANSAKSI --}}
                <div class="bg-white p-3 rounded-3 shadow-sm mb-3">
                    <h6 class="fw-bold mb-3 d-flex align-items-center text-dark">
                        <i class="bi bi-calendar-event me-2 fs-5"></i>Informasi Transaksi
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-4 col-sm-6">
                            <small class="text-muted d-block">Tanggal Transaksi</small>
                            <span class="fw-semibold text-dark" id="modalTanggal">-</span>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <small class="text-muted d-block">Metode Pembayaran</small>
                            <span class="badge bg-secondary px-2 py-1 mt-1" id="modalMetode">
                                <i class="bi bi-cash me-1"></i>Tunai
                            </span>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <small class="text-muted d-block">Total Item</small>
                            <span class="badge bg-primary px-2 py-1 mt-1" id="modalTotalItem">0 Item</span>
                        </div>
                    </div>
                </div>

                {{-- DETAIL PRODUK --}}
                <div class="bg-white p-3 rounded-3 shadow-sm mb-3">
                    <h6 class="fw-bold mb-3 d-flex align-items-center text-dark">
                        <i class="bi bi-box-seam me-2 fs-5"></i>Detail Produk
                    </h6>
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle mb-0">
                            <thead class="border-bottom">
                                <tr class="text-muted small">
                                    <th>Produk</th>
                                    <th class="text-center">Jumlah</th>
                                    <th>Harga</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody id="modalDetailProdukBody"></tbody>
                        </table>
                    </div>
                </div>

                {{-- TOTAL PEMBAYARAN --}}
                <div class="bg-white p-3 rounded-3 shadow-sm d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-cash-stack fs-4 text-secondary"></i>
                        <span class="fw-bold text-dark fs-5">Total Pembayaran</span>
                    </div>
                    <span class="h4 fw-bold mb-0" style="color: #550000;" id="modalTotalBayar">Rp 0</span>
                </div>
            </div>

            <div class="modal-footer border-0 bg-white">
                <button type="button" class="btn btn-secondary px-4 fw-semibold" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function showDetail(trx) {
    // 1. Info Pelanggan
    const namaPembeli = trx.nama_pelanggan ? trx.nama_pelanggan : (trx.user ? trx.user.name : 'Pembeli Langsung (Kasir)');
    const emailPembeli = (trx.user && trx.user.email) ? trx.user.email : 'Transaksi Langsung (Tanpa Akun)';

    document.getElementById('modalNamaPelanggan').innerText = namaPembeli;
    document.getElementById('modalEmail').innerText = emailPembeli;

    // 2. Tanggal Transaksi
    const tgl = new Date(trx.created_at);
    const optionsTgl = { day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' };
    document.getElementById('modalTanggal').innerText = tgl.toLocaleDateString('id-ID', optionsTgl) + ' WIB';

    // === TARUH KODE TERSEBUT DI SINI ===
    const metode = (trx.metode_pembayaran || 'tunai').toLowerCase();
    let badgeHtml = '<span class="badge bg-secondary px-2 py-1"><i class="bi bi-cash me-1"></i>Tunai</span>';

    if (metode === 'qris') {
        badgeHtml = '<span class="badge bg-primary px-2 py-1"><i class="bi bi-qr-code me-1"></i>QRIS</span>';
    } else if (metode === 'transfer_bank') {
        badgeHtml = '<span class="badge bg-info text-dark px-2 py-1"><i class="bi bi-bank me-1"></i>Transfer Bank</span>';
    }

    document.getElementById('modalMetode').innerHTML = badgeHtml;
    // ===================================

    // 3. Rincian Item Belanjaan
    const items = trx.transaksi_detail || trx.transaksiDetail || [];
    const tbody = document.getElementById('modalDetailProdukBody');
    tbody.innerHTML = '';

    let totalQty = 0;

    if (items.length > 0) {
        items.forEach(item => {
            const qty = parseFloat(item.qty) || 1;
            totalQty += qty;
            const subtotal = Math.round(parseFloat(item.subtotal || (item.harga * qty)));
            const displayQty = (qty % 1 === 0) ? parseInt(qty) : qty;

            const tr = document.createElement('tr');
            tr.className = 'border-bottom';
            tr.innerHTML = `
                <td class="fw-semibold text-dark">${item.nama_barang || (item.barang ? item.barang.nama_barang : 'Barang')}</td>
                <td class="text-center fw-semibold">${displayQty}</td>
                <td>Rp ${Math.round(item.harga).toLocaleString('id-ID')}</td>
                <td class="text-end fw-bold">Rp ${subtotal.toLocaleString('id-ID')}</td>
            `;
            tbody.appendChild(tr);
        });
    } else {
        tbody.innerHTML = `
            <tr>
                <td colspan="4" class="text-center text-muted py-3">Rincian produk tidak ditemukan.</td>
            </tr>
        `;
    }

    // 4. Total Item & Total Bayar
    const displayTotalItem = (totalQty % 1 === 0) ? parseInt(totalQty) : totalQty;
    document.getElementById('modalTotalItem').innerText = `${displayTotalItem} Item`;
    document.getElementById('modalTotalBayar').innerText = `Rp ${Math.round(trx.total_harga).toLocaleString('id-ID')}`;

    // Tampilkan Modal
    const modal = new bootstrap.Modal(document.getElementById('detailTransaksiModal'));
    modal.show();
}
</script>
@endpush
@endsection
