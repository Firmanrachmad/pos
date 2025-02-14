<!DOCTYPE html>
<html>
<head>
    <title>Receivables Report</title>
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
        <h1>Receivables Report</h1>
        <p>Customer: {{ $customerName }}</p>
        <p>Date Range: {{ $startDate }} - {{ $endDate }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Transaction Date</th>
                <th>Transaction Number</th>
                <th>Customer</th>
                <th>Total Transactions</th>
                <th>Total Payments</th>
                <th>Remaining Receivables</th>
                <th>Due Date</th>
                <th>Transaction Status</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalRemaining = 0;
            @endphp
            @foreach ($data as $receivable)
                <tr>
                    @php
                        $remaining = $receivable->total_amount - $receivable->payment->sum('payment');
                        $totalRemaining += $remaining;
                    @endphp
                    <td>{{ \Carbon\Carbon::parse($receivable->transaction_date)->format('d/m/Y') }}</td>
                    <td>{{ $receivable->transaction_number }}</td>
                    <td>{{ $receivable->customer ? $receivable->customer->name : '-' }} </td>
                    <td>{{ number_format($receivable->total_amount, 2) }}</td>
                    <td>{{ number_format($receivable->payment->sum('payment'), 2) }}</td>
                    <td>{{ number_format($remaining, 2) }}</td>
                    <td>{{ $receivable->due_date ? Carbon\Carbon::parse($receivable->due_date)->format('d/m/Y') : '-' }}</td>
                    <td>{{ $receivable->payment_status }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5">Total</th>
                <th>{{ number_format($totalRemaining, 2) }}</th>
                <th colspan="2"></th>
            </tr>
        </tfoot>
    </table>
</body>
</html>