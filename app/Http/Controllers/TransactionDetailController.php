<?php

namespace App\Http\Controllers;

use App\Models\TransactionDetail;
use App\Models\Transactions;
use Illuminate\Http\Request;

class TransactionDetailController extends Controller
{
    public function index(){
        
        $transaction = Transactions::with('customer')
            ->orderBy('transaction_date', 'desc') 
            ->get();
        return response()->json([
            'status' => 'success',
            'data' => $transaction
        ]);
    }

    public function show($id){

        $transaction = Transactions::with([
            'transactionDetails',
            'transactionDetails.product', 
            'payment',
            'customer'
        ])->find($id);

        if (!$transaction) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Transaction not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $transaction
        ]);
    }
}
