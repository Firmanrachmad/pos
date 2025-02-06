<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class RevenueExport implements WithMultipleSheets
{
    private $data;

    public function __construct(Collection $data)
    {
        $this->data = $data;
    }

    public function sheets(): array
    {
        $sheets = [];

        $groupedByMonth = $this->data->groupBy(function ($item) {
            return \Carbon\Carbon::parse($item->transaction_date)->format('F Y');
        });

        foreach ($groupedByMonth as $month => $data) {
            $sheets[] = new RevenueSheetExport($data, $month);
        }

        return $sheets;
    }
}
