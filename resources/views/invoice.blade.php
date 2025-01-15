<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
        }
        .invoice {
            max-width: 800px;
            margin: auto;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
        }
        .details, .totals {
            margin-top: 20px;
        }
        .details table, .totals table {
            width: 100%;
            border-collapse: collapse;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .totals table td {
            text-align: right;
        }
    </style> 
</head>
<body>
    <div class="invoice">
        <div class="header">
            <h1>Invoice</h1>
            <p>Transaction Date: {{ $transaction_date }}</p>
            @if($due_date)
                <p>Due Date: {{ $due_date }}</p>
            @endif
        </div>

        <div class="customer">
            <h3>Customer Details</h3>
            @if($customer)
                <p>Name: {{ $customer->name }}</p>
            @else
                <p>Guest Customer</p>
            @endif
        </div>

        <div class="payment">
            <h3>Payment Details</h3>
            <p>Payment Method: {{ $payment_method }}</p>
            <p>Payment Status: {{ $payment_status }}</p>
        </div>

        <div class="details">
            <h3>Order Details</h3>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $item)
                        <tr>
                            <td>{{ $item['product_name'] }}</td>
                            <td>{{ number_format($item['price'], 2) }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>{{ number_format($item['total'], 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="totals">
            <h3>Summary</h3>
            <table>
                <tr>
                    <td>Subtotal</td>
                    <td>{{ number_format($subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td>Payment</td>
                    <td>{{ number_format($payment, 2) }}</td>
                </tr>
                <tr>
                    <td>Balance</td>
                    <td>{{ number_format($balance, 2) }}</td>
                </tr>
            </table>
        </div>

        @if($note)
            <div class="note">
                <h3>Note</h3>
                <p>{{ $note }}</p>
            </div>
        @endif
    </div>
</body>
</html>
