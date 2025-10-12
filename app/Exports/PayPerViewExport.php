<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Modules\Subscriptions\Models\Subscription;
use currency;
use Modules\Frontend\Models\PayPerView;
use Carbon\Carbon;
class PayPerViewExport implements FromCollection, WithHeadings
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
        $data = PayPerView::with(['user', 'video', 'episode', 'movie', 'PayperviewTransaction'])
            ->orderBy('created_at', 'desc')
            ->get();

        return $data->map(function ($row) {
            $exportRow = [];

            foreach ($this->columns as $column) {
                switch ($column) {
                    case 'user_details':
                        $user = $row->user;
                        $exportRow[$column] = $user
                            ? 'Name: ' . ($user->full_name ?? '-') . ', Email: ' . ($user->email ?? '-')
                            : 'Name: -, Email: -';
                        break;

                    case 'content':
                        $exportRow[$column] = match($row->type) {
                            'video' => optional($row->video)->name,
                            'episode' => optional($row->episode)->name,
                            'movie' => optional($row->movie)->name,
                            default => '-'
                        };
                        break;

                    case 'duration':
                        $exportRow[$column] = $row->available_for . ' Days';
                        break;

                    case 'payment_method':
                        $exportRow[$column] = optional($row->PayperviewTransaction)->payment_type ?? '-';
                        break;

                    case 'start_date':
                        $exportRow[$column] = $row->created_at
                            ? Carbon::parse($row->created_at)->format('Y-m-d')
                            : '-';
                        break;

                    case 'end_date':
                        $exportRow[$column] = $row->view_expiry_date
                            ? Carbon::parse($row->view_expiry_date)->format('Y-m-d')
                            : '-';
                        break;

                    case 'amount':
                        $exportRow[$column] = \Currency::format($row->content_price ?? 0);
                        break;

                    case 'discount':
                        $exportRow[$column] = ($row->discount_percentage ?? 0) . '%';
                        break;

                    case 'total_amount':
                        $exportRow[$column] = \Currency::format(optional($row->PayperviewTransaction)->amount ?? 0);
                        break;

                    case 'status':
                        $exportRow[$column] = $row->status ?? '-';
                        break;

                    default:
                        $exportRow[$column] = $row->{$column} ?? '-';
                        break;
                }
            }

            return $exportRow;
        });
    }
}
