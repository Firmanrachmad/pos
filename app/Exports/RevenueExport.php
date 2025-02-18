<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class RevenueExport implements WithMultipleSheets
{
    private $data;
    private $customerName;
    private $startDate;
    private $endDate;

    public function __construct(Collection $data, $startDate, $endDate, $customerName)
    {
        $this->data = $data;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->customerName = $customerName;
    }

    public function sheets(): array
    {
        $sheets = [];

        $groupedByMonth = $this->data->groupBy(function ($item) {
            $date = \Carbon\Carbon::parse($item->transaction_date);
            return $date->format('Y-m');
        });

        // Sort the grouped data by month-year (ascending order)
        $groupedByMonth = $groupedByMonth->sortBy(function ($items, $key) {
            return $key; // Sort by the key (e.g., "2024-01")
        });

        foreach ($groupedByMonth as $monthYear => $data) {
            $date = \Carbon\Carbon::createFromFormat('Y-m', $monthYear);
            $month = $date->format('F');  // "January"
            $year = $date->format('Y');   // "2024"

            $sheets[] = new RevenueSheetExport($data, $month, $year, $this->customerName);
        }

        return $sheets;
    }
}
