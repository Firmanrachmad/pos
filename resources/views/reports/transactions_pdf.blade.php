<!DOCTYPE html>
<html>
<head>
    <title>Transactions Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Transactions Report</h1>
        <p>Customer: {{ $customerName }}</p>
        <p>Date Range: {{ $startDate }} - {{ $endDate }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Transaction Date</th>
                <th>Transaction Number</th>
                <th>Due Date</th>
                <th>Total Amount</th>
                <th>Payment Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $transaction)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d/m/Y') }}</td>
                    <td>{{ $transaction->transaction_number }}</td>
                    <td>{{ $transaction->due_date ? Carbon\Carbon::parse($transaction->due_date)->format('d/m/Y') : '-' }} </td>
                    <td>{{ number_format($transaction->total_amount, 2) }}</td>
                    <td>{{ ucfirst($transaction->payment_status) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3">Total</th>
                <th>{{ number_format($totalAmount, 2) }}</th>
                <th></th>
            </tr>
        </tfoot>
    </table>
</body>
</html>