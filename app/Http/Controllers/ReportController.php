<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

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

        $query->whereBetween('date', [$startDate, $endDate]);
        if (!empty($paymentStatus)) {
            $query->whereIn('status', $paymentStatus);
        }
        if ($customerId !== 'all') {
            $query->where('customer_id', $customerId);
        }

        $data = $query->get();

        if ($format === 'csv' || $format === 'xlsx') {
            return $this->generateExcel($data, $format);
        } elseif ($format === 'pdf') {
            return $this->generatePdf($data);
        }
    }

    private function generateExcel($data, $format)
    {
        $fileName = 'report.' . $format;

        return Excel::download(new class($data) implements \Maatwebsite\Excel\Concerns\FromCollection {
            private $data;
            public function __construct($data)
            {
                $this->data = $data;
            }
            public function collection()
            {
                return $this->data;
            }
        }, $fileName);
    }
}
