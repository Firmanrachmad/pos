<?php

namespace App\Http\Controllers;

use App\Exports\PaymentExport;
use App\Exports\ReceivablesExport;
use App\Exports\SalesPerCustomerExport;
use App\Exports\TransactionExport;
use App\Models\Customer;
use App\Models\Payment;
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

            $query = null;

            switch($reportType){
                case 'transactions':
                    $query = Transactions::with('customer')
                        ->whereBetween('transaction_date', [$startDate, $endDate]);

                    if (!empty($paymentStatus)) {
                        $query->whereIn('payment_status', $paymentStatus);
                    }
        
                    if ($customerId !== 'all') {
                        $query->where('customer_id', $customerId);
                    }

                    $query->select('id', 'transaction_date', 'transaction_number', 'due_date', 'total_amount', 'payment_status', 'customer_id');
                    break;
                    
                case 'payments':
                    $query = Payment::with([
                        'transaction.customer'
                    ])->whereBetween('payment_date', [$startDate, $endDate]);

                    if (!empty($paymentStatus)) {
                        $query->whereIn('status', $paymentStatus);
                    }
        
                    if ($customerId !== 'all') {
                        $query->whereHas('transaction', function ($query) use ($customerId) {
                            $query->where('customer_id', $customerId);
                        });
                    }

                    $query->select('id', 'payment_date', 'payment_method', 'payment', 'change', 'note', 'status', 'transaction_id');
                    break;

                case 'receivables':
                    $query = Transactions::with(['customer', 'payment'])
                        ->whereBetween('transaction_date', [$startDate, $endDate]);
                    if (!empty($paymentStatus)) {
                        $query->whereIn('payment_status', $paymentStatus);
                    }
        
                    if ($customerId !== 'all') {
                        $query->where('customer_id', $customerId);
                    }

                    $query->select('id', 'transaction_date', 'transaction_number', 'due_date', 'total_amount', 'payment_status', 'customer_id');
                    break;
                case 'sales_per_customer':
                    // $query = Customer::with(['transactions.payments'])
                    //     ->whereBetween('transactions.transaction_date', [$startDate, $endDate]);

                    // if(!empty($paymentStatus)){
                    //     $query->whereIn('transactions.payment_status', $paymentStatus);
                    // }

                    // if ($customerId !== 'all') {
                    //     $query->where('customer_id', $customerId);
                    // }

                    // $query->select('id', 'name', 'transactions.id', 'transactions.')

                    // $query = Transactions::with(['customer', 'payment'])
                    //     ->whereBetween('transaction_date', [$startDate, $endDate]);
                    // if (!empty($paymentStatus)) {
                    //     $query->whereIn('payment_status', $paymentStatus);
                    // }

                    $query = Customer::with(['transactions.payment'])
                        ->whereHas('transactions', function ($q) use ($startDate, $endDate) {
                            $q->whereBetween('transaction_date', [$startDate, $endDate]);
                        });

                    if (!empty($paymentStatus)) {
                        $query->whereHas('transactions', function ($q) use ($paymentStatus) {
                            $q->whereIn('payment_status', $paymentStatus);
                        });
                    }
        
                    if ($customerId !== 'all') {
                        $query->where('customer_id', $customerId);
                    }

                    $query->select('id', 'name');
                    break;
                default:
                    throw new \Exception("Invalid report type");    
            }

            $data = $query->get();

            if ($data->isEmpty()) {
                return back()->withErrors(['No data available for the selected criteria.']);
            }

            if ($format === 'csv' || $format === 'xlsx') {
                $customerName = $customerId !== 'all'
                    ? Customer::where('id', $customerId)->value('name') ?? 'Unknown Customer'
                    : 'All Customers';

                return $this->generateExcel($data, $format, $reportType, $startDate, $endDate, $customerName);
            } elseif ($format === 'pdf') {
                return $this->generatePdf($data);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }  
    }

    private function generateExcel($data, $format, $reportType, $startDate, $endDate, $customerName)
    {
        $fileName = 'report.' . $format;

        switch($reportType){
            case 'transactions':
                return Excel::download(new TransactionExport($data, $startDate, $endDate, $customerName), $fileName);
            case 'payments':
                return Excel::download(new PaymentExport($data, $startDate, $endDate, $customerName), $fileName);
            case 'receivables':
                return Excel::download(new ReceivablesExport($data, $startDate, $endDate, $customerName), $fileName);
            case 'sales_per_customer':
                return Excel::download(new SalesPerCustomerExport($data, $startDate, $endDate, $customerName), $fileName);
            default:
                throw new \Exception("Invalid report type");  

        }

    }
}
