<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function pay(Request $request)
    {
        $validated = $request->validate([
            'payment_method' => 'required|string',
            'payment' => 'required|numeric|min:0',
            'note' => 'nullable|string',
        ]);
    }
}
