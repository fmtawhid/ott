<?php

namespace Modules\Ad\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Trait\ModuleTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Modules\Ad\Http\Requests\CustomAdsSettingRequest;
use Modules\Ad\Models\CustomAdsSetting;
use Modules\Entertainment\Models\Entertainment;
use Modules\Episode\Models\Episode;
use Modules\Video\Models\Video;
use Yajra\DataTables\DataTables;

class CustomAdsSettingController extends Controller
{
    protected string $exportClass = '\App\Exports\CustomAdsExport';

    use ModuleTrait {
        initializeModuleTrait as private traitInitializeModuleTrait;
    }

    public function __construct()
    {
        $this->traitInitializeModuleTrait(
            'Customads', // module title
            'Castads', // module name
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
                'value' => 'placement',
                'text' => __('messages.lbl_ad_placement'),
            ],
            [
                'value' => 'redirect_url',
                'text' => __('messages.redirect_url'),
            ],
            // [
            //     'value' => 'duration',
            //     'text' => __('messages.lbl_duration'),
            // ],
            // [
            //     'value' => 'skip_enabled',
            //     'text' => __('messages.enable_skip'),
            // ],
            // [
            //     'value' => 'skip_after',
            //     'text' => __('messages.skip_after'),
            // ],
            [
                'value' => 'target_content_type',
                'text' => __('messages.target_content_type'),
            ],
            [
                'value' => 'target_categories',
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
                'text' => __('messages.lbl_status'),
            ],
        ];
        $export_url = route('backend.customads.export');
        $module_title = __('messages.customads');

        return view('ad::backend.customads.index', compact('module_action', 'filter', 'export_import', 'export_columns', 'export_url', 'module_title'));

    }

    public function index_data(Datatables $datatable, Request $request)
    {
        // Auto-deactivate expired ads before loading data
        CustomAdsSetting::where('status', 1)
            ->where('end_date', '<', now()->toDateString())
            ->update(['status' => 0]);

        $query = CustomAdsSetting::query()->withTrashed()->orderBy('updated_at', 'desc');

        $filter = $request->filter;

        if (isset($filter['name'])) {
            $query->where('name', 'like', '%'.$filter['name'].'%');
        }

        if (isset($filter['type'])) {
            $query->where('type', $filter['type']);
        }

        if (isset($filter['placement'])) {
            $query->where('placement', $filter['placement']);
        }

        if (isset($filter['target_content_type'])) {
            $query->where('target_content_type', $filter['target_content_type']);
        }

        return $datatable->eloquent($query)
            ->editColumn('name', function ($data) {
                return $data->name ?? '--';
            })
           ->editColumn('type', function ($data) {
               return $data->type ? ucfirst($data->type) : '--';
            })
            ->editColumn('placement', function ($data) {
                if ($data->placement) {
                    return ucwords(str_replace('_', ' ', $data->placement));
                }
                return '--';
            })
            ->editColumn('redirect_url', function ($data) {
                return $data->redirect_url ?? '--';
            })
            ->editColumn('target_content_type', function ($data) {
                return $data->target_content_type ? ucfirst($data->target_content_type) : '--';
            })
            ->editColumn('start_date', function ($data) {
                return $data->start_date ? date('Y-m-d', strtotime($data->start_date)) : '--';
            })
            ->editColumn('end_date', function ($data) {
                return $data->end_date ? date('Y-m-d', strtotime($data->end_date)) : '--';
            })
            ->addColumn('check', function ($row) {
                return '<input type="checkbox" class="form-check-input select-table-row"  id="datatable-row-'.$row->id.'"  name="datatable_ids[]" value="'.$row->id.'" data-type="customads" onclick="dataTableRowCheck('.$row->id.',this)">';
            })
            ->addColumn('action', function ($data) {
                return view('ad::backend.customads.action', compact('data'))->render();
            })
            ->editColumn('status', function ($row) {
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
                            data-end-date="'.$row->end_date.'"
                            data-ad-id="'.$row->id.'"
                            '.$checked.'
                            '.$disabled.'
                            title="Status"
                        >
                    </div>';
                } else {
                    $checked = $row->status ? 'checked="checked"' : '';
                    $disabled = $row->trashed() ? 'disabled' : '';

                    return '
                        <div class="form-check form-switch">
                            <input type="checkbox" data-url="'.route('backend.customads.update_status', $row->id).'"
                                data-token="'.csrf_token().'" class="switch-status-change form-check-input"
                                id="datatable-row-'.$row->id.'" name="status" value="'.$row->id.'" '.$checked.' '.$disabled.'>
                        </div>
                    ';
                }
            })
            ->editColumn('updated_at', fn ($data) => formatUpdatedAt($data->updated_at))
            ->rawColumns(['action', 'check', 'status'])
            ->orderColumns(['id'], '-:column $1')
            ->make(true);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $module_title = __('messages.custom_ads');
        return view('ad::backend.customads.create', compact('module_title'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomAdsSettingRequest $request)
    {
        try {
            $data = $request->all();
            $type = strtolower($request->input('type'));
            $urlType = strtolower($request->input('url_type'));

            if ($type === 'video') {
                if ($urlType === 'local') {
                    $mediaInput = $request->input('video_file_input');
                    $data['media'] = $mediaInput ? extractFileNameFromUrl($mediaInput) : null;
                } else {
                    $data['media'] = $request->input('media_url') ?? null;
                }
            } elseif ($type === 'image') {
                if ($urlType === 'local') {
                    if ($request->has('file_url') && ! empty($request->input('file_url'))) {
                        $filename = $request->input('file_url');
                        // Store only the filename, not the full path
                        $data['media'] = extractFileNameFromUrl($filename);
                    } else {
                        $data['media'] = $data['media'] ?? null;
                    }
                } else {
                    $data['media'] = $request->input('media_url') ?? null;
                }
            }

            $targetCategories = array_map('intval', $request->input('target_categories', []));
            $data['target_categories'] = json_encode($targetCategories);
            // $data['skip_enabled'] = $data['skip_enabled'] ? $data['skip_enabled'] : 0;
            // $data['skip_after'] = $data['skip_enabled'] ? $request->input('skip_after') : null;
            $data['status'] = $request->has('status') ? 1 : 0;

            CustomAdsSetting::create($data);

            return redirect()->route('backend.customads.index')->with('success', __('messages.customads_created_successfully'));
        } catch (\Exception $e) {
            // dd($e->getMessage());
            \Log::error('CustomAds Store Error: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all(),
            ]);

            return redirect()->back()->withInput()->with('error', __('messages.customads_creation_failed'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $module_title = __('messages.edit_customads');
        $data = CustomAdsSetting::findOrFail($id);
        $type = $data['type'];
        $urlType = $data['url_type'];
        if ($type === 'video') {
            if ($urlType === 'local') {
                $data->video_url_input = setBaseUrlWithFileName($data->media);
            } else {
                $data->media_url = $data->media;
            }
        } elseif ($type === 'image') {
            if ($urlType === 'local') {
                $data->file_url = setBaseUrlWithFileName($data->media);
            } else {
                $data->media_url = $data->media;
            }
        }
        $data->target_categories = json_decode($data->target_categories, true);
        $targetCategoriesOptions = [];
        switch ($data->target_content_type) {
            case 'movie':
                $targetCategoriesOptions = Entertainment::where('type', 'movie')->pluck('name', 'id')->toArray();
                break;

            case 'video':
                $targetCategoriesOptions = Video::pluck('name', 'id')->toArray();
                break;

            case 'tvshow':
                $targetCategoriesOptions = Episode::pluck('name', 'id')->toArray();
                break;

            default:
                $targetCategoriesOptions = [];
        }

        // dd($data);
        return view('ad::backend.customads.edit', compact('module_title', 'data', 'targetCategoriesOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomAdsSettingRequest $request, $id)
    {
        // dd($request->all());
        $customad = CustomAdsSetting::findOrFail($id);
        $data = $request->all();
        if (empty($data['skip_enabled'])) {
            $data['skip_after'] = null;
        }
        $type = $request->input('type');
        $urlType = $request->input('url_type');

        $media = null;

        if ($type === 'video') {
            if ($urlType === 'local') {
                $mediaInput = $request->input('video_file_input');
                $media = $mediaInput ? extractFileNameFromUrl($mediaInput) : null;
            } else {
                $media = $request->input('media_url') ?? null;
            }
        } elseif ($type === 'image') {
            if ($urlType === 'local') {
                $fileInput = $request->input('file_url');
                if ($fileInput) {
                    // Store only the filename, not the full path
                    $media = extractFileNameFromUrl($fileInput);
                } else {
                    $media = null;
                }
            } else {
                $media = $request->input('media_url') ?? null;
            }
        }
        if (! $media) {
            if ($type === $customad->type && $urlType === $customad->url_type) {
                $media = $customad->media;
            } else {
                $media = null;
            }
        }
        $data['media'] = $media;
        $targetCategories = array_map('intval', $request->input('target_categories', []));
        $data['target_categories'] = json_encode($targetCategories);
        $customad->update($data);

        return redirect()->route('backend.customads.index')->with('success', __('messages.customads_updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = CustomAdsSetting::findOrFail($id);
        $data->delete();
        $message = trans('messages.delete_form');

        return response()->json(['message' => $message, 'status' => true], 200);
    }

    public function restore($id)
    {
        $data = CustomAdsSetting::withTrashed()->findOrFail($id);
        $data->restore();
        $message = trans('messages.restore_form');

        return response()->json(['message' => $message, 'status' => true], 200);
    }

    public function forceDelete($id)
    {
        $category = CustomAdsSetting::withTrashed()->findOrFail($id);
        $category->forceDelete();
        $message = trans('messages.permanent_delete_form');

        return response()->json(['message' => $message, 'status' => true], 200);
    }

    public function update_status(Request $request, CustomAdsSetting $id)
    {
        $id->update(['status' => $request->status]);

        return response()->json(['status' => true, 'message' => __('messages.status_updated')]);
    }

    public function bulk_action(Request $request)
    {
        $ids = explode(',', $request->rowIds);
        $actionType = $request->action_type;
        $moduleName = __('messages.customads');

        return $this->performBulkAction(CustomAdsSetting::class, $ids, $actionType, $moduleName);
    }

    public function getTargetCategories(Request $request)
    {
        $type = $request->get('type');
        $items = [];
        switch ($type) {
            case 'movie':
                $items = Entertainment::where('type', 'movie')
                    ->select('id', 'name as text')
                    ->where('status', 1)
                    ->get();
                break;

            case 'video':
                $items = Video::select('id', 'name as text')->where('status', 1)->get();
                break;

            case 'tvshow':
                // $items = Episode::select('id', 'name as text')->where('status', 1)->get();
                 $items = Episode::join('entertainments', 'episodes.entertainment_id', '=', 'entertainments.id')
                ->select(
                    'episodes.id',
                    \DB::raw("CONCAT(episodes.name, ' (', entertainments.name, ')') as text")
                )
                ->where('episodes.status', 1)
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
        $ad = CustomAdsSetting::findOrFail($id);
        $ad->start_date = $request->start_date;
        $ad->end_date = $request->end_date;
        $ad->status = 1;
        $ad->save();

        return response()->json(['status' => true, 'message' => __('messages.status_updated')]);
    }
}
