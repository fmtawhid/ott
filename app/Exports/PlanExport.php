<?php

namespace App\Exports;

use Modules\Subscriptions\Models\Plan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PlanExport implements FromCollection, WithHeadings
{
    public array $columns;

    public function __construct($columns, $dateRange)
    {
        $this->columns = $columns;
    }

    public function headings(): array
    {
        $modifiedHeadings = [];

        foreach ($this->columns as $column) {
            // Capitalize each word and replace underscores with spaces
            $modifiedHeadings[] = ucwords(str_replace('_', ' ', $column));
        }

        return $modifiedHeadings;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = Plan::query();
        $query = $query->orderBy('updated_at', 'desc');
        $plans = $query->get();

        $newQuery = $plans->map(function ($row) {
            $selectedData = [];

            foreach ($this->columns as $column) {
                switch ($column) {
                    case 'status':
                        $selectedData[$column] = $row[$column] ? 'Active' : 'Inactive';
                        break;

                    case 'price':
                    case 'amount':
                    case 'monthly_price':
                    case 'subscription_fee':
                        $selectedData[$column] = $row[$column] ? \Currency::format($row[$column]): '-';
                        break;

                    default:
                        // Optionally detect price-like fields dynamically
                        if (preg_match('/(price|amount|fee|cost)/i', $column)) {
                            $selectedData[$column] = row[$column] ? \Currency::format($row[$column]): '-';
                        } else {
                            $selectedData[$column] = $row[$column];
                        }
                        break;
                }
            }

            return $selectedData;
        });

        return $newQuery;
    }

}
