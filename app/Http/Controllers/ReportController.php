<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportController extends Controller
{
    public function generateReport(Request $request)
    {

        $request->validate([
            'format' => 'required|in:csv,xlsx,pdf',
            'reportType' => 'required|in:transactions,payments,receivables,sales_per_customer,revenue',
            'dateRange' => 'required',
            'paymentStatus' => 'array',
            'customer' => 'required',
        ]);

        // return response()->json($request->all());

        $format = $request->input('format');
        $reportType = $request->input('reportType');
        $dateRange = explode(' - ', $request->input('dateRange'));
        $startDate = $dateRange[0];
        $endDate = $dateRange[1];
        $paymentStatus = $request->input('paymentStatus', []);
        $customerId = $request->input('customer', 'all');

        $query = DB::table('transactions'); 
        if ($reportType === 'transactions') {
            $query->select('id', 'transaction_date', 'transaction_number', 'due_date', 'total_amount', 'payment_status', 'customer_id');
        }
        if ($reportType === 'payments') {
            $query->select('id', 'payment_date', 'payment_method', 'payment', 'change', 'note');
        }

        $query->whereBetween('transaction_date', [
            Carbon::createFromFormat('d/m/Y', $startDate)->startOfDay(),
            Carbon::createFromFormat('d/m/Y', $endDate)->endOfDay(),
        ]);
        
        if (!empty($paymentStatus)) {
            $query->whereIn('payment_status', $paymentStatus);
        }
        if ($customerId !== 'all') {
            $query->where('customer_id', $customerId);
        }

        $data = $query->get();
        if ($data->isEmpty()) {
            return back()->withErrors(['No data available for the selected criteria.']);
        }
        

        if ($format === 'csv' || $format === 'xlsx') {
            $customerName = DB::table('customers')
                ->where('id', $customerId)
                ->value('name') ?? 'All Customers';
            return $this->generateExcel($data, $format, $startDate, $endDate, $customerName);
        } elseif ($format === 'pdf') {
            return $this->generatePdf($data);
        }
    }

    private function generateExcel($data, $format, $startDate, $endDate, $customerName)
    {
        $fileName = 'report.' . $format;
    
        return Excel::download(new class($data, $startDate, $endDate, $customerName) implements 
            \Maatwebsite\Excel\Concerns\FromCollection, 
            WithHeadings, 
            WithStyles, 
            WithEvents {
    
            private $data;
            private $startDate;
            private $endDate;
            private $customerName;
    
            public function __construct($data, $startDate, $endDate, $customerName)
            {
                $this->data = $data;
                $this->startDate = $startDate;
                $this->endDate = $endDate;
                $this->customerName = $customerName;
            }
    
            public function collection()
            {
                $header = [
                    ['', 'Transaction Report'],
                    ['Date Range:', $this->startDate . ' - ' . $this->endDate], 
                    ['Customer:', $this->customerName],
                    ['ID', 'Transaction Date', 'Transaction Number', 'Due Date', 'Total Amount', 'Payment Status', 'Customer ID'] 
                ];
    
                $dataRows = $this->data->map(function ($item) {
                    return [
                        $item->id,
                        $item->transaction_date,
                        $item->transaction_number,
                        $item->due_date,
                        $item->total_amount,
                        $item->payment_status,
                        $item->customer_id,
                    ];
                });
    
                return collect($header)->merge($dataRows);
            }
    
            public function headings(): array
            {
                return [];
            }
    
            public function styles(Worksheet $sheet)
            {
                return [
                    1 => ['font' => ['bold' => true, 'size' => 14]],
                    2 => ['font' => ['italic' => true, 'size' => 10]], 
                    3 => ['font' => ['italic' => true, 'size' => 10]], 
                    4 => ['font' => ['bold' => true, 'size' => 12]], 
                ];
            }
    
            public function registerEvents(): array
            {
                return [
                    AfterSheet::class => function (AfterSheet $event) {
                        $sheet = $event->sheet;
    
                        $sheet->mergeCells('A1:G1');
                        $sheet->getStyle('A1')->applyFromArray([
                            'font' => ['bold' => true, 'size' => 14],
                            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
                        ]);
    
                        foreach (range('A', 'G') as $column) {
                            $sheet->getColumnDimension($column)->setAutoSize(true);
                        }
    
                        $sheet->getStyle('A4:G4')->applyFromArray([
                            'borders' => [
                                'allBorders' => [
                                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                ],
                            ],
                        ]);
                    },
                ];
            }
        }, $fileName);
    }
    
    
}
