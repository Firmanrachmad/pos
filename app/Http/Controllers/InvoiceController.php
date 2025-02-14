<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Customer;
use App\Models\Product;

class InvoiceController extends Controller
{
    public function generateInvoice(Request $request)
    {
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

        $customer = $validated['customer_id'] ? Customer::find($validated['customer_id']) : null;

        $cartItems = collect($validated['cart'])->map(function ($item) {
            $product = Product::find($item['product_id']);

            return [
                'product_name' => $product->name,
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'total' => $item['price'] * $item['quantity'],
            ];
        });

        $subtotal = $cartItems->sum('total');
        $payment = $validated['payment'];
        $balance = $payment - $subtotal;

        $invoiceData = [ 
            'transaction_date' => $validated['transaction_date'],
            'due_date' => $validated['due_date'] ?? null,
            'payment_method' => $validated['payment_method'] ?? 'N/A',
            'payment_status' => $validated['payment_status'],
            'customer' => $customer,
            'cart' => $cartItems,
            'subtotal' => $subtotal,
            'payment' => $payment,
            'balance' => $balance,
            'note' => $validated['note'] ?? '',
        ];

        $pdf = Pdf::loadView('invoice.invoice', $invoiceData);

        return $pdf->stream('invoice.pdf');
    }
}
