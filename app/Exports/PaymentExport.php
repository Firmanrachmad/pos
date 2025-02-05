<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\FromCollection;

class PaymentExport implements FromCollection, WithHeadings, WithStyles, WithEvents
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
            ['Payment Report'],
            ['Date Range:', $this->startDate . ' - ' . $this->endDate],
            ['Customer:', $this->customerName],
            ['No', 'Payment Date', 'Payment Method', 'Payment', 'Change', 'Transaction Status', 'Note', 'Customer'],
        ];

        $dataRows = $this->data->map(function ($item, $index) {
            return [
                $index + 1,
                $item->payment_date ? \Carbon\Carbon::parse($item->payment_date)->format('d/m/Y H:i') : '-',
                $item->payment_method ? $item->payment_method : '-',
                $item->payment,
                $item->change,
                $item->status,
                $item->note ? $item->note : '-',
                isset($item->transaction->customer) ? $item->transaction->customer->name : '-',
            ];            
        });

        $totalAmount = $this->data->sum('payment');
    
        $footer = [
            ['', '', 'Total', $totalAmount, '', '', ''],
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

                $highestRow = $sheet->getHighestRow();

                $sheet->mergeCells('A1:H1');
                $sheet->mergeCells('B2:H2');
                $sheet->mergeCells('B3:H3');

                $totalRowRange = "A{$highestRow}:H{$highestRow}";

                $headerRange = 'A4:H4';
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
                $outerBorderRange = "A4:H{$highestRow}";
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

                foreach (range('A', 'G') as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }
            },
        ];
    }
}
