<!DOCTYPE html>
<html>
<head>
    <title>Revenue Report</title>
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
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Revenue Report</h1>
        <p>Customer: {{ $customerName }}</p>
        <p>Date Range: {{ $startDate }} - {{ $endDate }}</p>
    </div>

    @foreach ($groupedData as $month => $transactions)
        <h2>{{ $month }}</h2>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Total Transactions</th>
                    <th>Total Revenue</th>
                </tr>
            </thead>
            <tbody>
                @php $index = 1; $totalTransactions = 0; $total=0;@endphp
                @foreach ($transactions->groupBy(fn($item) => \Carbon\Carbon::parse($item->transaction_date)->format('Y-m-d')) as $date => $items)
                    @php 
                        $totalTransactions += $items->count();
                        $totalRevenue = $items->sum(fn($item) => $item->payment->sum('payment'));
                        $total += $totalRevenue;
                    @endphp
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</td>
                        <td>{{ $items->count() }}</td>
                        <td>{{ number_format($totalRevenue, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="1">Total</th>
                    <th>{{ $totalTransactions }}</th>
                    <th>{{ number_format($total, 2) }}</th>
                </tr>
            </tfoot>
        </table>
    @endforeach
</body>
</html>
