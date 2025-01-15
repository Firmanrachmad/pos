<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .table th { background-color: #f4f4f4; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <h2>Transaction History</h2>
    <p><strong>Transaction Number:</strong> {{ $transaction->transaction_number }}</p>
    <p><strong>Customer:</strong> {{ $customer->name ?? 'Guest' }}</p>
    <p><strong>Transaction Date:</strong> {{ $transaction->transaction_date }}</p>
    <p><strong>Due Date:</strong> {{ $transaction->due_date }}</p>

    <h3>Transaction Details</h3>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($details as $index => $detail)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $detail->product->name }}</td>
                    <td class="text-right">{{ number_format($detail->price, 2) }}</td>
                    <td class="text-center">{{ $detail->quantity }}</td>
                    <td class="text-right">{{ number_format($detail->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" class="text-right">Total Amount</th>
                <th class="text-right">{{ number_format($transaction->total_amount, 2) }}</th>
            </tr>
        </tfoot>
    </table>

    <h3>Payment History</h3>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Payment Date</th>
                <th>Method</th>
                <th>Amount</th>
                <th>Change</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($payments as $index => $payment)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $payment->payment_date }}</td>
                    <td>{{ $payment->payment_method }}</td>
                    <td class="text-right">{{ number_format($payment->payment, 2) }}</td>
                    <td class="text-right">{{ number_format($payment->change, 2) }}</td>
                    <td class="text-center">{{ ucfirst($payment->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p><strong>Payment Status:</strong> {{ ucfirst($transaction->payment_status) }}</p>
</body>
</html>
