<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Modules\Subscriptions\Models\Subscription;

class SubscriptionExport implements FromCollection, WithHeadings
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
        $query = Subscription::query();

        $query = $query->orderBy('updated_at', 'desc');

        $query = $query->get();

        $newQuery = $query->map(function ($row) {
            $selectedData = [];

            foreach ($this->columns as $column) {
                switch ($column) {

                    case 'status':
                        $selectedData[$column] = $row[$column];
                        break;

                        case 'user_details':
                            $user = $row->user;
                            $selectedData[$column] = $user
                                ? 'Name: ' . ($user->full_name ?? '-') . ', Email: ' . ($user->email ?? '-')
                                : 'Name: -, Email: -';
                            break;

                    default:
                        $selectedData[$column] = $row[$column];
                        break;
                }
            }

            return $selectedData;
        });

        return $newQuery;
    }
}
