<?php

namespace App\Exports;

use Modules\Entertainment\Models\Entertainment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MoiveExport implements FromCollection, WithHeadings
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
        $query = Entertainment::where('type', 'movie')
            ->withCount([
                'entertainmentLike' => function ($query) {
                    $query->where('is_like', 1); 
                },
                'entertainmentView' 
            ])
            ->orderBy('updated_at', 'desc')
            ->get();

        $newQuery = $query->map(function ($row) {
            $selectedData = [];

            foreach ($this->columns as $column) {
                switch ($column) {

                    case 'status':
                        $selectedData[$column] = 'Inactive';
                        if ($row[$column]) {
                            $selectedData[$column] = 'Active';
                        }
                        break;

                    case 'is_restricted':
                        $selectedData[$column] = 'no';
                        if ($row[$column]) {
                            $selectedData[$column] = 'yes';
                        }
                        break;

                    case 'like_count':
                        $selectedData[$column] = $row->entertainment_like_count > 0 ? $row->entertainment_like_count : '-';
                        break;

                    case 'watch_count':
                        $selectedData[$column] = $row->entertainment_view_count > 0 ? $row->entertainment_view_count : '-';
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
