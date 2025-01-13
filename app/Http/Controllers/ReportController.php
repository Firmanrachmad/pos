<?php

namespace App\Http\Controllers;

use App\Exports\TransactionExport;
use App\Models\Customer;
use App\Models\Transactions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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

        try {
            $format = $request->input('format');
            $reportType = $request->input('reportType');
            $dateRange = explode(' - ', $request->input('dateRange'));
            $startDate = Carbon::createFromFormat('d/m/Y', $dateRange[0])->startOfDay();
            $endDate = Carbon::createFromFormat('d/m/Y', $dateRange[1])->endOfDay();
            $paymentStatus = $request->input('paymentStatus', []);
            $customerId = $request->input('customer', 'all');

            $query = Transactions::with('customer');

            $query->whereBetween('transaction_date', [$startDate, $endDate]);

            if (!empty($paymentStatus)) {
                $query->whereIn('payment_status', $paymentStatus);
            }

            if ($customerId !== 'all') {
                $query->where('customer_id', $customerId);
            }

            if ($reportType === 'transactions') {
                $query->select('id', 'transaction_date', 'transaction_number', 'due_date', 'total_amount', 'payment_status', 'customer_id');
            } elseif ($reportType === 'payments') {
                $query->select('id', 'payment_date', 'payment_method', 'payment', 'change', 'note');
            }

            $data = $query->get();

            if ($data->isEmpty()) {
                return back()->withErrors(['No data available for the selected criteria.']);
            }

            if ($format === 'csv' || $format === 'xlsx') {
                $customerName = $customerId !== 'all'
                    ? Customer::where('id', $customerId)->value('name') ?? 'Unknown Customer'
                    : 'All Customers';

                return $this->generateExcel($data, $format, $startDate, $endDate, $customerName);
            } elseif ($format === 'pdf') {
                return $this->generatePdf($data);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function generateExcel($data, $format, $startDate, $endDate, $customerName)
    {
        $fileName = 'report.' . $format;

        return Excel::download(new TransactionExport($data, $startDate, $endDate, $customerName), $fileName);
    }
}
