<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentController extends Controller
{
    public function index()
    {
        $payment = Payment::with([
            'transaction',
            'transaction.customer'
        ])->orderBy('payment_date', 'desc')
        ->get();

        return response()->json([
            'status' => 'success',
            'data' => $payment
        ]);
    }
    public function pay(Request $request, $id)
    {
        $validated = $request->validate([
            'payment_date' => 'required|date',
            'payment_method' => 'required|string',
            'payment' => 'required|numeric|min:0',
            'change' => 'required|numeric',
            'note' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            
            $transaction = Transactions::find($id);
            if (!$transaction) {
                return response()->json([
                    'message' => 'Transaction not found',
                ], 404);
            }

            $payment = Payment::create([
                'transaction_id' => $transaction->id,
                'payment_date' => $validated['payment_date'],
                'payment_method' => $validated['payment_method'],
                'payment' => $validated['payment'],
                'change' => $validated['change'],
                'status' => 'pending',
                'note' => $validated['note'],
            ]);

            $totalPayment = Payment::where('transaction_id', $transaction->id)->sum('payment');

            if ($totalPayment >= $transaction->total_amount) {
                $transactionStatus = 'paid';
            } else {
                $transactionStatus = 'pending';
            }

            $transaction->payment_status = $transactionStatus;
            $transaction->save();

            $payment->status = $transactionStatus;
            $payment->save();

            DB::commit();

            return response()->json([
                'message' => 'Payment success',
                'data' => $payment,
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'message' => 'Payment failed',
                'error' => $e->getMessage(),
            ], 500);

        }
    }

    
    public function generateHistory($id)
    {
        
        $transaction = Transactions::with([
            'transactionDetails.product', 
            'payment' => function($query) {
                $query->orderBy('payment_date', 'asc');
            },
            'customer'
        ])->find($id);

        if (!$transaction) {
            return response()->json(['error' => 'Transaction not found'], 404);
        }

        $data = [
            'transaction' => $transaction,
            'customer' => $transaction->customer,
            'details' => $transaction->transactionDetails,
            'payments' => $transaction->payment,
        ];

        $pdf = Pdf::loadView('reports.transaction-history', $data);

        return $pdf->stream('transaction_history.pdf');
    }

}
