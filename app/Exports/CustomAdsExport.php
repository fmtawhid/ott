<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Modules\Ad\Models\CustomAdsSetting;
use Modules\Entertainment\Models\Entertainment;
use Modules\Video\Models\Video;
use Modules\Episode\Models\Episode;

class CustomAdsExport implements FromCollection, WithHeadings
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
        $query = CustomAdsSetting::query();
        $query = $query->orderBy('updated_at', 'desc');
        $query = $query->get();

        $newQuery = $query->map(function ($row) {
            $selectedData = [];
            foreach ($this->columns as $column) {
                switch ($column) {
                    case 'status':
                        $selectedData[$column] = $row[$column] ? 'Active' : 'Inactive';
                        break;
                    // case 'skip_enabled':
                    //     $selectedData[$column] = $row[$column] ? 'Yes' : 'No';
                    //     break;
                    case 'target_categories':
                        $ids = $row[$column] ? json_decode($row[$column], true) : [];
                        $names = [];
                        if (!empty($ids)) {
                            switch ($row['target_content_type']) {
                                case 'movie':
                                    $names = Entertainment::whereIn('id', $ids)->pluck('name')->toArray();
                                    break;
                                case 'video':
                                    $names = Video::whereIn('id', $ids)->pluck('name')->toArray();
                                    break;
                                case 'tvshow':
                                    // For each episode, append the parent TV show name in brackets
                                    $episodes = Episode::whereIn('id', $ids)->get(['id', 'name', 'entertainment_id']);
                                    $entertainmentNames = Entertainment::whereIn('id', $episodes->pluck('entertainment_id')->unique()->toArray())->pluck('name', 'id');
                                    foreach ($episodes as $episode) {
                                        $tvShowName = $entertainmentNames[$episode->entertainment_id] ?? '';
                                        $names[] = $episode->name . ($tvShowName ? ' (' . $tvShowName . ')' : '');
                                    }
                                    break;
                            }
                        }
                        $selectedData[$column] = implode(', ', $names);
                        break;
                    case 'start_date':
                    case 'end_date':
                        $selectedData[$column] = $row[$column] ? date('Y-m-d', strtotime($row[$column])) : '';
                        break;
                    default:
                        if (in_array($column, ['type', 'placement', 'target_content_type'])) {
                            $selectedData[$column] = ucwords(str_replace('_', ' ', $row[$column]));
                        } else {
                            $selectedData[$column] = $row[$column];
                        }
                }
            }
            return $selectedData;
        });
        return $newQuery;
    }
}
