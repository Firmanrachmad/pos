<!DOCTYPE html>
<html>
<head>
    <title>Sales Per Customer Report</title>
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
        <h1>Sales Per Customer Report</h1>
        <p>Customer: {{ $customerName }}</p>
        <p>Date Range: {{ $startDate }} - {{ $endDate }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Customer Name</th>
                <th>Total Transactions</th>
                <th>Total Amount</th>
                <th>Total Payments</th>
                <th>Remaining Receivables</th>
                <th>Last Transaction Date</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalAmount = 0;
                $totalPayments = 0;
                $totalRemaining = 0;
            @endphp
            @foreach ($data as $customer)
                <tr>
                    @php
                        $customerTotalAmount = $customer->transactions->sum('total_amount');
                        $totalPaid = $customer->transactions->flatMap->payment->sum('payment');
                        $remaining = $customerTotalAmount - $totalPaid;

                        $totalAmount += $customerTotalAmount;
                        $totalPayments += $totalPaid;
                        $totalRemaining += $remaining;
                    @endphp
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->transactions->count() }}</td>
                    <td>{{ number_format($customerTotalAmount, 2) }}</td>
                    <td>{{ number_format($totalPaid, 2) }}</td>
                    <td>{{ number_format($remaining, 2) }}</td>
                    <td>{{ $customer->transactions->last() ? \Carbon\Carbon::parse($customer->transactions->last()->transaction_date)->format('d/m/Y H:i') : '-' }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2">Total</th>
                <th>{{ number_format($totalAmount, 2) }}</th>
                <th>{{ number_format($totalPayments, 2) }}</th>
                <th>{{ number_format($totalRemaining, 2) }}</th>
                <th colspan="1"></th>
            </tr>
        </tfoot>
    </table>
</body>
</html>