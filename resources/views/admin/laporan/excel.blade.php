<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
    <table>
        <tbody>
            {{-- HEADER TOKO --}}
            <tr>
                <td colspan="10" style="text-align: center; font-weight: bold; font-size: 16pt; color: #550000;">
                    WAROENG 86
                </td>
            </tr>
            <tr>
                <td colspan="10" style="text-align: center; font-weight: bold; font-size: 12pt;">
                    LAPORAN KEUANGAN DAN PENJUALAN BARANG
                </td>
            </tr>
            <tr>
                <td colspan="10" style="text-align: center; font-size: 10pt; color: #555555;">
                    Periode: {{ date('d F Y', strtotime($startDate)) }} s/d {{ date('d F Y', strtotime($endDate)) }}
                </td>
            </tr>
            <tr><td colspan="10"></td></tr>

            {{-- KOTAK RINGKASAN DATA (BARIS 5 - 10) --}}
            <tr>
                <td colspan="2" style="font-weight: bold; background-color: #f8f9fa;">Total Transaksi Selesai</td>
                <td style="font-weight: bold; text-align: right;">{{ $transaksis->count() }} Transaksi</td>
                <td colspan="7"></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold; background-color: #f8f9fa;">Total Barang Terjual</td>
                <td style="font-weight: bold; text-align: right;">{{ $totalBarangTerjual }} Item</td>
                <td colspan="7"></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold; background-color: #f8f9fa;">Pemasukan Tunai (Cash)</td>
                <td style="font-weight: bold; text-align: right;">{{ $transaksis->where('metode_pembayaran', 'tunai')->sum('total_harga') }}</td>
                <td colspan="7"></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold; background-color: #f8f9fa;">Pemasukan QRIS</td>
                <td style="font-weight: bold; text-align: right;">{{ $transaksis->where('metode_pembayaran', 'qris')->sum('total_harga') }}</td>
                <td colspan="7"></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold; background-color: #f8f9fa;">Pemasukan Transfer Bank</td>
                <td style="font-weight: bold; text-align: right;">{{ $transaksis->where('metode_pembayaran', 'transfer_bank')->sum('total_harga') }}</td>
                <td colspan="7"></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold; background-color: #f8f9fa;">Total Omzet / Pendapatan</td>
                <td style="font-weight: bold; text-align: right;">{{ $totalPendapatan }}</td>
                <td colspan="7"></td>
            </tr>
            <tr><td colspan="10"></td></tr>

            {{-- HEADER TABEL DATA (BARIS 12) --}}
            <tr style="background-color: #550000; color: #ffffff; font-weight: bold;">
                <th style="text-align: center; font-weight: bold;">No</th>
                <th style="text-align: center; font-weight: bold;">Kode Transaksi</th>
                <th style="text-align: center; font-weight: bold;">Waktu Transaksi</th>
                <th style="text-align: center; font-weight: bold;">Nama Pembeli</th>
                <th style="text-align: center; font-weight: bold;">Metode Bayar</th>
                <th style="text-align: center; font-weight: bold;">Barang yang Dibeli</th>
                <th style="text-align: center; font-weight: bold;">Harga Satuan</th>
                <th style="text-align: center; font-weight: bold;">Jumlah (Qty)</th>
                <th style="text-align: center; font-weight: bold;">Subtotal</th>
                <th style="text-align: center; font-weight: bold;">Total Belanja</th>
            </tr>

            {{-- BARIS DATA TRANSAKSI --}}
            @php $no = 1; @endphp
            @forelse($transaksis as $trx)
                @php
                    $details = $trx->transaksiDetail;
                    $detailCount = $details ? $details->count() : 0;
                    $metodeTeks = strtoupper(str_replace('_', ' ', $trx->metode_pembayaran ?? 'tunai'));
                @endphp

                @if($detailCount > 0)
                    @foreach($details as $index => $detail)
                        @php
                            $qtyClean = isset($detail->qty) ? ($detail->qty + 0) : 1;
                        @endphp
                        <tr>
                            @if($index === 0)
                                <td rowspan="{{ $detailCount }}" style="text-align: center; vertical-align: middle;">{{ $no++ }}</td>
                                <td rowspan="{{ $detailCount }}" style="text-align: center; vertical-align: middle;">{{ $trx->kode_transaksi ?? '-' }}</td>
                                <td rowspan="{{ $detailCount }}" style="text-align: center; vertical-align: middle;">{{ date('d/m/Y H:i', strtotime($trx->created_at)) }}</td>
                                <td rowspan="{{ $detailCount }}" style="vertical-align: middle;">{{ $trx->nama_pelanggan ?? 'Pembeli Langsung' }}</td>
                                <td rowspan="{{ $detailCount }}" style="text-align: center; vertical-align: middle; font-weight: bold;">{{ $metodeTeks }}</td>
                            @endif

                            <td>{{ $detail->nama_barang ?? ($detail->barang->nama_barang ?? 'Produk') }}</td>
                            <td style="text-align: right;">{{ $detail->harga ?? 0 }}</td>
                            <td style="text-align: center;">{{ $qtyClean }}</td>
                            <td style="text-align: right;">{{ ($detail->harga ?? 0) * ($detail->qty ?? 1) }}</td>

                            @if($index === 0)
                                <td rowspan="{{ $detailCount }}" style="text-align: right; vertical-align: middle; font-weight: bold;">
                                    {{ $trx->total_harga }}
                                </td>
                            @endif
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td style="text-align: center;">{{ $no++ }}</td>
                        <td style="text-align: center;">{{ $trx->kode_transaksi ?? '-' }}</td>
                        <td style="text-align: center;">{{ date('d/m/Y H:i', strtotime($trx->created_at)) }}</td>
                        <td>{{ $trx->nama_pelanggan ?? 'Pembeli Langsung' }}</td>
                        <td style="text-align: center; font-weight: bold;">{{ $metodeTeks }}</td>
                        <td>Transaksi Kasir</td>
                        <td style="text-align: right;">{{ $trx->total_harga }}</td>
                        <td style="text-align: center;">1</td>
                        <td style="text-align: right;">{{ $trx->total_harga }}</td>
                        <td style="text-align: right; font-weight: bold;">{{ $trx->total_harga }}</td>
                    </tr>
                @endif
            @empty
                <tr>
                    <td colspan="10" style="text-align: center; color: #888888;">Tidak ada data transaksi pada periode ini.</td>
                </tr>
            @endforelse

            {{-- TOTAL AKHIR --}}
            <tr style="background-color: #e9ecef; font-weight: bold;">
                <td colspan="9" style="font-weight: bold; text-align: right;">TOTAL OMZET KESELURUHAN</td>
                <td style="font-weight: bold; text-align: right;">{{ $totalPendapatan }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
