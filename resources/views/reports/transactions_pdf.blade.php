<!DOCTYPE html>
<html>
<head>
    <title>Transactions Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
            word-wrap: break-word;
        }
        th {
            background-color: #f2f2f2;
        }
        thead {
            display: table-header-group;
        }
        tfoot {
            display: table-row-group;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
        }
        .header p {
            margin: 5px 0;
            font-size: 12px;
        }
        tr {
            page-break-inside: avoid;
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
                <th>Customer Name</th>
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
                    <td>{{ $transaction->customer ? $transaction->customer->name : '-' }}</td>
                    <td>{{ $transaction->due_date ? Carbon\Carbon::parse($transaction->due_date)->format('d/m/Y') : '-' }} </td>
                    <td>{{ number_format($transaction->total_amount, 2) }}</td>
                    <td>{{ ucfirst($transaction->payment_status) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4">Total</th>
                <th>{{ number_format($data->sum('total_amount'), 2) }}</th>
                <th></th>
            </tr>
        </tfoot>
    </table>
</body>
</html>