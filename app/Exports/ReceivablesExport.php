<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReceivablesExport implements FromCollection, WithHeadings, WithStyles, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $data;
    private $startDate;
    private $endDate;
    private $customerName;

    public function __construct(Collection $data, $startDate, $endDate, $customerName)
    {
        $this->data = $data;
        $this->startDate = \Carbon\Carbon::parse($startDate)->format('d/m/Y H:i');
        $this->endDate = \Carbon\Carbon::parse($endDate)->format('d/m/Y H:i');;
        $this->customerName = $customerName;
    }

    public function collection()
    {
        $header = [
            ['Receivables Report'],
            ['Date Range:', $this->startDate . ' - ' . $this->endDate],
            ['Customer:', $this->customerName],
            ['No', 'Transaction Date', 'Transaction Number', 'Customer Name', 'Total Transactions', 'Total Payments', 'Remaining Receivables', 'Due Date', 'Transaction Status'],
        ];

        $sortedData = $this->data->sortBy('transaction_date')->values();

        $totalRemaining = 0;

        $dataRows = $sortedData->map(function ($item, $index) use (&$totalRemaining) {
            $totalPaid = $item->payment->sum('payment');
            $remaining = $item->total_amount - $totalPaid;

            if ($remaining === 0 || $remaining === null){
                $remaining = 0;
            }

            $totalRemaining += $remaining;

            return [
                $index + 1,
                $item->transaction_date ? \Carbon\Carbon::parse($item->transaction_date)->format('d/m/Y H:i') : '-',
                $item->transaction_number,
                $item->customer ? $item->customer->name : '-',
                sprintf('%.2f', $item->total_amount), 
                sprintf('%.2f', $item->payment->sum('payment')),
                sprintf('%.2f', $remaining),
                $item->due_date ? \Carbon\Carbon::parse($item->due_date)->format('d/m/Y H:i') : '-',
                $item->payment_status,
            ];            
        });

        $footer = [
            ['', '', '', '', '', 'Total', sprintf('%.2f', $totalRemaining), '', '']
        ];

        return collect($header)
            ->merge($dataRows)
            ->merge($footer);

    }

    public function headings(): array
    {
        return [];
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();

        return [
            1 => ['font' => ['bold' => true, 'size' => 14], 'alignment' => ['horizontal' => 'center']],
            2 => ['font' => ['italic' => true, 'size' => 10]],
            3 => ['font' => ['italic' => true, 'size' => 10]],
            4 => ['font' => ['bold' => true, 'size' => 12]],
            $highestRow => ['font' => ['bold' => true], 'alignment' => ['horizontal' => 'right']],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $sheet->getStyle('G')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER);

                $highestRow = $sheet->getHighestRow();

                $sheet->mergeCells('A1:I1');
                $sheet->mergeCells('B2:I2');
                $sheet->mergeCells('B3:I3');

                $totalRowRange = "A{$highestRow}:I{$highestRow}";

                $headerRange = 'A4:I4';
                $borderStyle = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];
                $sheet->getStyle($headerRange)->applyFromArray($borderStyle);

                $sheet->getStyle($headerRange)->getFill()->setFillType('solid')->getStartColor()->setARGB('D9D9D9');

                $highestRow = $sheet->getHighestRow();
                $outerBorderRange = "A4:I{$highestRow}";
                $outerBorderStyle = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];
                $sheet->getStyle($outerBorderRange)->applyFromArray($outerBorderStyle);

                $verticalBorderStyle = [
                    'borders' => [
                        'right' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];
                $sheet->getStyle("A4:A{$highestRow}")->applyFromArray($verticalBorderStyle);

                $sheet->getStyle($totalRowRange)->applyFromArray([
                    'borders' => [
                        'top' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                    'fill' => [
                        'fillType' => 'solid',
                        'startColor' => ['argb' => 'D9D9D9'],
                    ],
                    'font' => [
                        'bold' => true,
                    ],
                ]);

                foreach (range('A', 'I') as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }

                $startDataRow = 5;
                $endDataRow = $highestRow - 1;

                $sheet->getStyle("D{$startDataRow}:D{$endDataRow}")->getAlignment()->setHorizontal('center');
                $sheet->getStyle("I{$startDataRow}:I{$endDataRow}")->getAlignment()->setHorizontal('center');
            },
        ];
    }
}
