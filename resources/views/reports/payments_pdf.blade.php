<!DOCTYPE html>
<html>
<head>
    <title>Payments Report</title>
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
        <h1>Payments Report</h1>
        <p>Customer: {{ $customerName }}</p>
        <p>Date Range: {{ $startDate }} - {{ $endDate }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Customer</th>
                <th>Transaction Number</th>
                <th>Payment Date</th>
                <th>Payment Method</th>
                <th>Payment</th>
                <th>Change</th>
                <th>Transaction Status</th>
                <th>Note</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $payment)
                <tr>
                    <td>{{ $payment->transaction->customer ? $payment->transaction->customer->name : '-' }}</td>
                    <td>{{ $payment->transaction->transaction_number }}</td>
                    <td>{{ $payment->payment_date ? Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y') : '-' }} </td>
                    <td>{{ $payment->payment_method ? $payment->payment_method : '-' }}</td>
                    <td>{{ number_format($payment->payment, 2) }}</td>
                    <td>{{ number_format($payment->change, 2) }}</td>
                    <td>{{ $payment->status }}</td>
                    <td>{{ $payment->note ? $payment->note : '-' }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4">Total</th>
                <th>{{ number_format($data->sum('payment'), 2) }}</th>
                <th colspan="3"></th>
            </tr>
        </tfoot>
    </table>
</body>
</html>