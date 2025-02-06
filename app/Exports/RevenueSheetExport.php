<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RevenueSheetExport implements FromCollection, WithHeadings, WithStyles, WithEvents
{
    private $data;
    private $month;

    public function __construct(Collection $data, $month)
    {
        $this->data = $data;
        $this->month = $month;
    }

    public function collection()
    {
        $header = [
            ["Revenue Report - {$this->month}"],
            ["No", "Date", "Total Transactions", "Total Revenue"],
        ];

        $groupedByDate = $this->data->groupBy(function ($item) {
            return \Carbon\Carbon::parse($item->transaction_date)->format('Y-m-d');
        });

        $dataRows = $groupedByDate->map(function ($items, $date) use (&$index) {
            $index = $index ?? 0;
            $index++;
    
            return [
                $index,
                \Carbon\Carbon::parse($date)->format('d/m/Y'),
                $items->count(),
                $items->sum(function ($item) {
                    return $item->payment->sum('payment');
                }),
            ];
        });

        // Hitung total transaksi dan total revenue
        $totalTransactions = $groupedByDate->sum(function ($items) {
            return $items->count(); // Jumlah transaksi keseluruhan
        });

        $totalRevenue = $groupedByDate->sum(function ($items) {
            return $items->sum(function ($item) {
                return $item->payment->sum('payment'); // Total revenue keseluruhan
            });
        });

        $footer = [
            ['', 'Total', $totalTransactions, $totalRevenue],
        ];

        return collect($header)->merge($dataRows)->merge($footer);
    }

    public function headings(): array
    {
        return [];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow();

                // Merge judul laporan
                $sheet->mergeCells("A1:D1");

                // Styling header
                $headerRange = 'A2:D2';
                $sheet->getStyle($headerRange)->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => 'solid',
                        'startColor' => ['argb' => 'D9D9D9'],
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                // Styling border seluruh tabel
                $tableRange = "A2:D{$highestRow}";
                $sheet->getStyle($tableRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                // Styling total row
                $totalRowRange = "A{$highestRow}:D{$highestRow}";
                $sheet->getStyle($totalRowRange)->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => 'solid',
                        'startColor' => ['argb' => 'D9D9D9'],
                    ],
                ]);

                // Auto resize kolom
                foreach (range('A', 'D') as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }
            },
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 14]],
        ];
    }
}
