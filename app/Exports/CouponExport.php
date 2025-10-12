<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Modules\Coupon\Models\Coupon;
use Carbon\Carbon;
use Modules\Currency\Models\Currency;


class CouponExport implements FromCollection, WithHeadings
{
    public array $columns;

    public function __construct($columns)
    {
        $this->columns = $columns;
    }

    public function headings(): array
    {
        $modifiedHeadings = [];

        foreach ($this->columns as $column) {
            $modifiedHeadings[] = ucwords(str_replace('_', ' ', $column));
        }

        return $modifiedHeadings;
    }

    public function collection()
    {
        $query = Coupon::with('subscriptionPlans')->orderBy('updated_at', 'desc')->get();

        return $query->map(function ($row) {
            $selectedData = [];

            foreach ($this->columns as $column) {
                switch ($column) {
                    case 'status':
                        $selectedData[$column] = $row[$column] ? 'Active' : 'Inactive';
                        break;

                    case 'start_date':
                    case 'expire_date':
                    case 'created_at':
                    case 'updated_at':
                        $selectedData[$column] = $row[$column] ? Carbon::parse($row[$column])->format('Y-m-d') : '';
                        break;

                    case 'discount':
                        $selectedData[$column] = $row->discount_type === 'percentage' 
                            ? $row[$column] . '%' 
                            : Currency::format($row[$column]);
                        break;

                    case 'subscription_type':
                        $selectedData[$column] = $row->subscriptionPlans->pluck('name')->join(', ');
                        break;

                    case 'is_expired':
                        $selectedData[$column] = $row[$column] ? 'Yes' : 'No';
                        break;

                    default:
                        $selectedData[$column] = $row[$column];
                        break;
                }
            }

            return $selectedData;
        });
    }
}
