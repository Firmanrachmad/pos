<?php

namespace App\Http\Controllers;

use App\Models\TransactionDetail;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionsController extends Controller
{
    public function checkout(Request $request){

        // return response()->json([
        //     'all_data' => $request->all()
        // ]);

        $validated = $request->validate([
            'transaction_date' => 'required|date',
            'payment_method' => 'required|string',
            'cart' => 'required|array',
            'cart.*.product_id' => 'required|exists:products,id',
            'cart.*.quantity' => 'required|integer|min:1',
            'cart.*.price' => 'required|numeric|min:0',
            'cart.*.subtotal' => 'required|numeric|min:0',
            'total_price' => 'required|numeric|min:0',
            'payment' => 'required|numeric|min:0',
            'change' => 'required|numeric|min:0',
            'note' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {

            $transaction = Transactions::create([
                'transaction_date' => $validated['transaction_date'],
                'total_amount' => $validated['total_price'],
                'payment_status' => 'pending',
                'payment_method' => $validated['payment_method'],
                'payment' => $validated['payment'],
                'change' => $validated['change'],
                'note' => $validated['note'],
            ]);

            foreach ($validated['cart'] as $item) {
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['subtotal'],
                ]);
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Checkout completed successfully.',
                'data' => $transaction
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Checkout failed. Please try again later.',
                'error' => $e->getMessage(),
            ], 500);
        }

    }
}
