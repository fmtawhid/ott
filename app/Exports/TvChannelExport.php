<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Modules\LiveTV\Models\LiveTvChannel;

class TvChannelExport implements FromCollection, WithHeadings
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
        $query = LiveTvChannel::with('TvChannelStreamContentMappings');

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
                    case 'stream_type':
                        case 'embedded':
                        case 'server_url':
                        case 'server_url1':
                            // Access from the relationship, e.g. streamDetails
                            $selectedData[$column] = $row->TvChannelStreamContentMappings ? $row->TvChannelStreamContentMappings->$column : '';
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
