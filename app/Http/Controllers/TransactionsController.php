<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Product;
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
            'customer_id' => 'nullable|exists:customers,id',
            'due_date' => 'nullable|date',
            'payment_method' => 'nullable|string',
            'payment_status' => 'required|string',
            'cart' => 'required|array',
            'cart.*.product_id' => 'required|exists:products,id',
            'cart.*.price' => 'required|numeric|min:0',
            'cart.*.quantity' => 'required|integer|min:1',
            'payment' => 'required|numeric|min:0',
            'note' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {

            $total_price = 0;

            $transaction = Transactions::create([
                'transaction_date' => $validated['transaction_date'],
                'due_date' => $validated['due_date'],
                'total_amount' => 0,
                'payment_status' => $validated['payment_status'],
                'customer_id' => $validated['customer_id'],
            ]);

            foreach ($validated['cart'] as $item) {
                $product = Product::find($item['product_id']);
                if (!$product) {
                    throw new \Exception("Product with ID {$item['product_id']} not found.");
                }

                $subtotal = $product->price * $item['quantity'];
                $total_price += $subtotal;


                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $product->id,
                    'price' => $product->price,
                    'quantity' => $item['quantity'],
                    'subtotal' => $subtotal,
                ]);
            }

            $transaction->update([
                'total_amount' => $total_price,
            ]);

            $payment = Payment::create([
                'transaction_id' => $transaction->id,
                'payment_date' => $validated['transaction_date'],
                'payment_method' => $validated['payment_method'],
                'payment' => $validated['payment'],
                'change' => $validated['payment'] - $total_price,
                'note' => $validated['note'],
                'status' => $validated['payment_status'],
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Checkout completed successfully.',
                'data' => [
                    'transaction' => $transaction,
                    'payment' => $payment,
                ],
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
