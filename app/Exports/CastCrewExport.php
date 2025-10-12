<?php

namespace App\Exports;

use Modules\CastCrew\Models\CastCrew;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CastCrewExport implements FromCollection, WithHeadings
{
    public array $columns;
    public array $dateRange;
    public $casttype;

    public function __construct($columns,$dateRange,$casttype)
    {
        $this->columns = $columns;

        $this->type = $casttype;
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
        $type = $this->type ?? 'actor';
        $query = CastCrew::where('type',$type);

        $query = $query->orderBy('updated_at', 'desc');

        $query = $query->get();

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
