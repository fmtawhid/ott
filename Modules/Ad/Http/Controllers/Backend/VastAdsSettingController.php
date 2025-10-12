<?php

namespace Modules\Ad\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;
use App\Trait\ModuleTrait;
use Carbon\Carbon;
use Modules\Ad\Http\Requests\VastAdsSettingRequest;
use Modules\Ad\Models\VastAdsSetting;
use Modules\Video\Models\Video;
use Modules\Entertainment\Models\Entertainment;
use Modules\Episode\Models\Episode;
use Illuminate\Support\Facades\Log;

class VastAdsSettingController extends Controller
{
    protected string $exportClass = '\App\Exports\VastAdsExport';

    use ModuleTrait {
        initializeModuleTrait as private traitInitializeModuleTrait;
        }

    public function __construct()
    {
        $this->traitInitializeModuleTrait(
            __('messages.vast_ads'), // module title
            __('messages.vast_ads'), // module name
            'fa-solid fa-clipboard-list' // module icon
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function index(Request $request)
    {
        $filter = [
            'status' => $request->status,
        ];

        $module_action = 'List';

        $export_import = true;
        $export_columns = [
            [
                'value' => 'name',
                'text' => __('messages.ad_name'),
            ],
            [
                'value' => 'type',
                'text' => __('messages.type'),
            ],
            [
                'value' => 'duration',
                'text' => __('messages.lbl_duration'),
            ],
            [
                'value' => 'target_type',
                'text' => __('messages.target_type'),
            ],
            // [
            //     'value' => 'enable_skip',
            //     'text' => __('messages.enable_skip'),
            // ],
            // [
            //     'value' => 'skip_after',
            //     'text' => __('messages.skip_after'),
            // ],
            // [
            //     'value' => 'frequency',
            //     'text' => __('messages.frequency'),
            // ],
            [
                'value' => 'target_selection',
                'text' => __('messages.target_categories'),
            ],
            [
                'value' => 'start_date',
                'text' => __('messages.start_date'),
            ],
            [
                'value' => 'end_date',
                'text' => __('messages.end_date'),
            ],
            [
                'value' => 'status',
                'text' => __('messages.status'),
            ],
        ];
        $export_url = route('backend.vastads.export');
        return view('ad::backend.vastads.index', compact('module_action', 'filter', 'export_import', 'export_columns', 'export_url'));

   }

    public function index_data(Datatables $datatable, Request $request)
    {
        // Auto-deactivate expired ads before loading data
        VastAdsSetting::where('status', 1)
            ->where('end_date', '<', now()->toDateString())
            ->update(['status' => 0]);

        $query = VastAdsSetting::query()->withTrashed()->orderBy('updated_at', 'desc');

        $filter = $request->filter;

        if (isset($filter['search'])) {
            $searchTerm = $filter['search'];
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('type', 'like', '%' . $searchTerm . '%')
                  ->orWhere('frequency', 'like', '%' . $searchTerm . '%');
            });
        }

        // Apply individual filters
        foreach(['name', 'type', 'target_type', 'frequency'] as $field) {
            if (isset($filter[$field])) {
                $query->where($field, 'like', '%' . $filter[$field] . '%');
            }
        }

        return $datatable->eloquent($query)
            ->editColumn('name', function ($data) {
                return $data->name ?? '--';
            })
           ->editColumn('type', function ($data) {
               return $data->type ? ucfirst($data->type) : '--';
            })
            ->editColumn('duration', function ($data) {
                if (!$data->duration) return '--';

                $parts = explode(':', $data->duration);
                $minutes = (int)$parts[0];
                $seconds = (int)$parts[1];

                if ($minutes > 0) {
                    return $minutes . 'M' . ($seconds > 0 ? ' ' . $seconds . 's' : '');
                } else {
                    return $seconds . 's';
                }
            })
            ->editColumn('start_date', function ($data) {
                return $data->start_date ? date('d M Y', strtotime($data->start_date)) : '--';
            })
            ->editColumn('end_date', function ($data) {
                return $data->end_date ? date('d M Y', strtotime($data->end_date)) : '--';
            })
            ->editColumn('target_type', function ($data) {
                return $data->target_type ? ucfirst($data->target_type) : '--';
            })
            ->editColumn('enable_skip', function ($data) {
                return $data->enable_skip ? __('messages.yes') : __('messages.no') ?? '--';
            })
            ->filterColumn('enable_skip', function ($query, $keyword) {
                $keyword = strtolower($keyword);
                if ($keyword === 'yes') {
                    $query->where('enable_skip', 1);
                } elseif ($keyword === 'no') {
                    $query->where('enable_skip', 0);
                }
            })
            ->editColumn('skip_after', function ($data) {
                if (!$data->skip_after) return '--';
                $parts = explode(':', $data->skip_after);
                $seconds = end($parts);
                return $seconds . 's';
            })
            ->editColumn('frequency', function ($data) {
                return $data->frequency ?? '--';
            })
            ->editColumn('status', function ($row) {
                // $checked = $row->status ? 'checked="checked"' : ''; // Check if status is active
                // $disabled = $row->trashed() ? 'disabled' : ''; // Disable if the record is soft-deleted

                // return '
                //     <div class="form-check form-switch">
                //         <input type="checkbox" data-url="' . route('backend.vastads.update_status', $row->id) . '"
                //             data-token="' . csrf_token() . '" class="switch-status-change form-check-input"
                //             id="datatable-row-' . $row->id . '" name="status" value="' . $row->id . '" ' . $checked . ' ' . $disabled . '>
                //     </div>
                // ';
                $originalStatus = (int) $row->getOriginal('status');
                $endDate = Carbon::parse($row->end_date)->toDateString();
                $today = now()->toDateString();

                if ($originalStatus === 0 && $endDate < $today) {
                // if ($row->status == 0 && \Carbon\Carbon::parse($row->end_date)->lt(now()))  {
                    $checked = $row->status ? 'checked' : '';
                    $disabled = $row->trashed() ? 'disabled' : '';
                    return '<div class="form-check form-switch">
                        <input type="checkbox"
                            class="form-check-input switch-status-change"
                            data-end-date="' . $row->end_date . '"
                            data-ad-id="' . $row->id . '"
                            ' . $checked . '
                            ' . $disabled . '
                            title="Status"
                        >
                    </div>';
                }
                else {
                    $checked = $row->status ? 'checked="checked"' : '';
                    $disabled = $row->trashed() ? 'disabled' : '';

                    return '
                        <div class="form-check form-switch">
                            <input type="checkbox" data-url="' . route('backend.vastads.update_status', $row->id) . '"
                                data-token="' . csrf_token() . '" class="switch-status-change form-check-input"
                                id="datatable-row-' . $row->id . '" name="status" value="' . $row->id . '" ' . $checked . ' ' . $disabled . '>
                        </div>
                    ';
                }
             })
            ->addColumn('check', function ($row) {
                return '<input type="checkbox" class="form-check-input select-table-row"  id="datatable-row-' . $row->id . '"  name="datatable_ids[]" value="' . $row->id . '" data-type="vastads" onclick="dataTableRowCheck(' . $row->id . ',this)">';
            })
            ->addColumn('action', function ($data) {
                return view('ad::backend.vastads.action', compact('data'))->render(); // adjust view path accordingly
            })

            ->editColumn('updated_at', fn($data) => formatUpdatedAt($data->updated_at))
            ->rawColumns(['action', 'check', 'status'])
            ->orderColumns(['id'], '-:column $1')
            ->make(true);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $module_title = __('messages.add_vastads');
        return view('ad::backend.vastads.create',compact('module_title'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(VastAdsSettingRequest $request)
    {
        try {
            $data = $request->all();

            // Remove is_enable field as it's only for frontend select all functionality
            unset($data['is_enable']);

            // $data['enable_skip'] = $data['enable_skip'] ? 1 : 0;

            // if ($data['enable_skip'] == 0) {
            //     $data['skip_after'] = null;
            // }
            $data['target_type'] = $request->input('target_type');
            // $data['enable_skip'] = $request->input('enable_skip') == 1 ? 1 : 0;

            // Convert target_selection values to integers before encoding
            $targetSelection = array_map('intval', $request->input('target_selection', []));
            $data['target_selection'] = json_encode($targetSelection);

            // Format dates to Y-m-d format
            $data['start_date'] = $request->input('start_date') ? date('Y-m-d', strtotime($request->input('start_date'))) : null;
            $data['end_date'] = $request->input('end_date') ? date('Y-m-d', strtotime($request->input('end_date'))) : null;

            VastAdsSetting::create($data);
            return redirect()->route('backend.vastads.index')->with('success', __('messages.vast_ads_setting_created'));
        } catch (\Exception $e) {
            // dd($e->getMessage());
            \Log::error('VastAdsSetting Store Error: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', __('messages.something_went_wrong'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $module_title = __('messages.edit_vastads');
        $data = VastAdsSetting::findOrFail($id);
        $data->target_selection = array_map('strval', json_decode($data->target_selection, true) ?? []);
        $targetSelectionOptions = [];
        switch ($data->target_type) {
            case 'movie':
                $targetSelectionOptions = Entertainment::where('type', 'movie')->where('status', 1)->pluck('name', 'id')->toArray();
                break;

            case 'video':
                $targetSelectionOptions = Video::pluck('name', 'id')->where('status', 1)->toArray();
                break;

            case 'tvshow':
                $targetSelectionOptions = Episode::pluck('name', 'id')->where('status', 1)->toArray();
                break;

            default:
                $targetSelectionOptions = [];
        }
        return view('ad::backend.vastads.edit', compact('module_title', 'data', 'targetSelectionOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VastAdsSettingRequest $request, $id)
    {
        $vastAd = VastAdsSetting::findOrFail($id);
        $data = $request->all();
        // if (empty($data['enable_skip'])) {
        //     $data['skip_after'] = null;
        // }
        $data['target_type'] = $request->input('target_type');
        // $data['enable_skip'] = $request->input('enable_skip') ? 1 : 0;

        // Convert target_selection values to integers before encoding
        $targetSelection = array_map('intval', $request->input('target_selection', []));
        $data['target_selection'] = json_encode($targetSelection);

        // Format dates to Y-m-d format and debug
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $data['start_date'] = $startDate ? date('Y-m-d', strtotime($startDate)) : null;
        $data['end_date'] = $endDate ? date('Y-m-d', strtotime($endDate)) : null;

        $vastAd->update($data);

        return redirect()->route('backend.vastads.index')->with('success', __('messages.vast_ads_setting_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = VastAdsSetting::findOrFail($id);
        $data->delete();
        $message = trans('messages.delete_form');
        return response()->json(['message' => $message, 'status' => true], 200);
    }

    public function restore($id)
    {
        $data = VastAdsSetting::withTrashed()->findOrFail($id);
        $data->restore();
        $message = trans('messages.restore_form');
        return response()->json(['message' => $message, 'status' => true], 200);
    }


    public function forceDelete($id)
    {
        $category = VastAdsSetting::withTrashed()->findOrFail($id);
        $category->forceDelete();
        $message = trans('messages.permanent_delete_form');
        return response()->json(['message' => $message,'status' => true], 200);
    }

    public function update_status(Request $request, VastAdsSetting $id)
    {
        $id->update(['status' => $request->status]);
        return response()->json(['status' => true, 'message' => __('messages.status_updated')]);
    }

    public function bulk_action(Request $request)
    {
        $ids = explode(',', $request->rowIds);
        $actionType = $request->action_type;
        $moduleName = __('messages.vastads');
        return $this->performBulkAction(VastAdsSetting::class, $ids, $actionType, $moduleName);
    }

    public function getTargetSelection(Request $request)
    {
        $type = $request->get('type');
        $items = [];
        switch ($type) {
            case 'movie':
                $items = Entertainment::where('type', 'movie')
                            ->select('id', 'name as text')
                            ->where('video_upload_type', '!=', 'Vimeo')
                            ->where('trailer_url_type', '!=', 'Vimeo')
                            ->where('status',1)
                            ->get();
                break;

            case 'video':
                $items = Video::select('id', 'name as text')->where('trailer_url_type', '!=', 'Vimeo')->where('video_upload_type', '!=', 'Vimeo')->where('status',1)->get();
                break;

            case 'tvshow':
                // $items = Episode::select('id', 'name as text')->where('status',1)->get();
                $items = Episode::join('entertainments', 'episodes.entertainment_id', '=', 'entertainments.id')
                ->select(
                    'episodes.id',
                    \DB::raw("CONCAT(episodes.name, ' (', entertainments.name, ')') as text")
                )
                ->where('episodes.status',1)
                ->where('episodes.trailer_url_type', '!=', 'Vimeo')
                ->where('episodes.video_upload_type', '!=', 'Vimeo')
                ->get();
                break;

            default:
                return response()->json([], 200);
        }

        return response()->json($items);
    }

    public function reactivate(Request $request, $id)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);
        $ad = VastAdsSetting::findOrFail($id);
        $ad->start_date = $request->start_date;
        $ad->end_date = $request->end_date;
        $ad->status = 1;
        $ad->save();

        return response()->json(['status' => true, 'message' => __('messages.status_updated')]);
    }
}
