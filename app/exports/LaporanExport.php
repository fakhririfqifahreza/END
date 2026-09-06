<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class LaporanExport implements FromView, ShouldAutoSize, WithEvents
{
    protected $transaksis;
    protected $startDate;
    protected $endDate;
    protected $totalPendapatan;
    protected $totalBarangTerjual;

    public function __construct($transaksis, $startDate, $endDate, $totalPendapatan, $totalBarangTerjual)
    {
        $this->transaksis = $transaksis;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->totalPendapatan = $totalPendapatan;
        $this->totalBarangTerjual = $totalBarangTerjual;
    }

    public function view(): View
    {
        return view('admin.laporan.excel', [
            'transaksis' => $this->transaksis,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'totalPendapatan' => $this->totalPendapatan,
            'totalBarangTerjual' => $this->totalBarangTerjual,
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow();

                // 1. Styling Judul Laporan (Baris 1 - 3)
                $sheet->getStyle('A1:J1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => '550000']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                $sheet->getStyle('A2:J2')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => '333333']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                $sheet->getStyle('A3:J3')->applyFromArray([
                    'font' => ['italic' => true, 'size' => 10, 'color' => ['rgb' => '666666']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // 2. Styling Kotak Ringkasan (Baris 5 - 10)
                $sheet->getStyle('A5:C10')->applyFromArray([
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'D0D0D0']]],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F8F9FA']],
                    'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
                ]);
                $sheet->getStyle('A5:B10')->getFont()->setBold(true);
                $sheet->getStyle('A10:C10')->getFont()->setBold(true);

                // Format Rupiah Nilai Ringkasan di Kolom C (Baris 7 - 10)
                $sheet->getStyle('C7:C10')->getNumberFormat()->setFormatCode('"Rp "#,##0');
                $sheet->getStyle('C5:C10')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

                // 3. Header Tabel Transaksi (BARIS 12)
                $tableHeaderRow = 12;
                $sheet->getStyle("A{$tableHeaderRow}:J{$tableHeaderRow}")->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '550000']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                ]);
                $sheet->getRowDimension($tableHeaderRow)->setRowHeight(26);

                // 4. Grid Border Tabel Data (Baris 12 s/d Baris Terakhir)
                $sheet->getStyle("A12:J{$highestRow}")->applyFromArray([
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'D0D0D0']]],
                    'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
                ]);

                // 5. Perataan Kolom Data
                $dataStartRow = 13;
                if ($highestRow >= $dataStartRow) {
                    $sheet->getStyle("A{$dataStartRow}:C{$highestRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle("E{$dataStartRow}:E{$highestRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                    // Kolom H (Jumlah Qty) -> Format General & Rata Tengah
                    $sheet->getStyle("H{$dataStartRow}:H{$highestRow}")->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_GENERAL);
                    $sheet->getStyle("H{$dataStartRow}:H{$highestRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                    // Format Rupiah HANYA untuk Kolom G (Harga Satuan), I (Subtotal), dan J (Total Belanja)
                    $sheet->getStyle("G{$dataStartRow}:G{$highestRow}")->getNumberFormat()->setFormatCode('"Rp "#,##0');
                    $sheet->getStyle("I{$dataStartRow}:J{$highestRow}")->getNumberFormat()->setFormatCode('"Rp "#,##0');
                }

                // 6. Baris Total Akhir
                $sheet->getStyle("A{$highestRow}:J{$highestRow}")->applyFromArray([
                    'font' => ['bold' => true, 'size' => 11],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E9ECEF']],
                    'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
                ]);
                $sheet->getStyle("J{$highestRow}")->getNumberFormat()->setFormatCode('"Rp "#,##0');
            },
        ];
    }
}
