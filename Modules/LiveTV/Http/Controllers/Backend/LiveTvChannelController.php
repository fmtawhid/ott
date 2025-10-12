<?php

namespace Modules\LiveTV\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Trait\ModuleTrait;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;
use Modules\Constant\Models\Constant;
use Modules\LiveTV\Models\LiveTvChannel;
use Modules\Subscriptions\Models\Plan;
use Modules\LiveTV\Models\LiveTvCategory;
use Modules\LiveTV\Http\Requests\TvChannelRequest;
use Modules\LiveTV\Models\TvChannelStreamContentMapping;
use Modules\LiveTV\Services\LiveTvChannelService;
use Illuminate\Support\Facades\Cache;


class LiveTvChannelController extends Controller
{
    protected string $exportClass = '\App\Exports\TvChannelExport';

    use ModuleTrait {
        initializeModuleTrait as private traitInitializeModuleTrait;
    }
    protected $liveTvChannelService;


    public function __construct(LiveTvChannelService $liveTvChannelService)
    {
        $this->liveTvChannelService = $liveTvChannelService;

        $this->traitInitializeModuleTrait(
            'livetv.tvchannel', // module title
            'tv-channel', // module name
            'fa-solid fa-clipboard-list' // module icon
        );
    }
    /**
     * Display a listing of the resource.
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
                'text' => __('messages.name'),
            ],
            [
                'value' => 'stream_type',
                'text' => __('movie.lbl_stream_type'),
            ],
            [
                'value' => 'embedded',
                'text' => __('messages.lbl_embedded'),
            ],
            [
                'value' => 'server_url',
                'text' => __('movie.server_url'),
            ],
            [
                'value' => 'server_url1',
                'text' => __('movie.server_url1'),
            ],
            [
                'value' => 'description',
                'text' => __('livetv.description'),
            ],
            [
                'value' => 'status',
               'text' => __('plan.lbl_status'),
            ],
        ];
        $export_url = route('backend.tv-channel.export');

        $plan = Plan::where('status',1)->get();

        return view('livetv::backend.channel.index', compact('module_action', 'filter', 'export_import', 'export_columns', 'export_url', 'plan'));

    }
    public function bulk_action(Request $request)
    {
        $ids = explode(',', $request->rowIds);
        $actionType = $request->action_type;
        $moduleName = 'Tv Channel'; // Adjust as necessary for dynamic use

        Cache::flush();

        return $this->performBulkAction(LiveTvChannel::class, $ids, $actionType, $moduleName);
    }


    public function index_data(Datatables $datatable, Request $request)
    {
        $query = LiveTvChannel::query()->with('TvCategory', 'TvChannelStreamContentMappings')->withTrashed();

        $filter = $request->filter;

        if (isset($filter['name'])) {
            $query->where('name', $filter['name']);
        }

        if (isset($filter)) {
            if (isset($filter['column_status'])) {
                $query->where('status', $filter['column_status']);
            }

            if (isset($filter['category'])) {
                $query->where('category_id', $filter['category']);
            }
        }

        return $datatable->eloquent($query)
            ->editColumn('image', function ($data) {
                $type = 'livetvchannel';
                $imageUrl = setBaseUrlWithFileName( $data->poster_url);
                return view('components.media-item', ['thumbnail' => $imageUrl, 'name' => $data->name, 'type' => $type])->render();
            })
            ->editColumn('name', fn($data) => $data->name)
            ->editColumn('plan_id', function ($data) {
                return optional($data->plan)->name ?? '-';
            })

            ->filterColumn('plan_id', function ($query, $keyword) {
                if (!empty($keyword)) {
                    $query->whereHas('plan', function ($query) use ($keyword) {
                        $query->where('name', 'like', '%' . $keyword . '%');
                    });
                }
            })
            ->addColumn('category_name', function ($data) {
                return optional($data->TvCategory)->name ?? '-';
            })

            ->addColumn('check', function ($data) {
                return '<input type="checkbox" class="form-check-input select-table-row"  id="datatable-row-' . $data->id . '"  name="datatable_ids[]" value="' . $data->id . '" data-type="tvchannel" onclick="dataTableRowCheck(' . $data->id . ',this)">';
            })
            ->addColumn('action', function ($data) {
                return view('livetv::backend.channel.action', compact('data'));
            })
            ->editColumn('status', function ($data) {
                $checked = $data->status ? 'checked="checked"' : '';
                $disabled = $data->trashed() ? 'disabled' : '';
                return '
                    <div class="form-check form-switch">
                        <input type="checkbox" data-url="' . route('backend.tv-channel.update_status', $data->id) . '"
                               data-token="' . csrf_token() . '" class="switch-status-change form-check-input"
                               id="datatable-row-' . $data->id . '" name="status" value="' . $data->id . '"
                               ' . $checked . ' ' . $disabled . '>
                    </div>
                ';
            })
            ->editColumn('updated_at', fn($data) => $this->formatUpdatedAt($data->updated_at))
            ->rawColumns(['action', 'status', 'check', 'image', 'plan_id','category_name'])
            ->orderColumns(['id'], '-:column $1')
            ->make(true);
    }

    private function formatUpdatedAt($updatedAt)
    {
        $diff = Carbon::now()->diffInHours($updatedAt);
        return $diff < 25 ? $updatedAt->diffForHumans() : $updatedAt->isoFormat('llll');
    }

    public function update_status(Request $request, LiveTvChannel $id)
    {
        $id->update(['status' => $request->status]);

        Cache::flush();

        return response()->json(['status' => true, 'message' => __('messages.status_updated_livetv')]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $plan = Plan::where('status', 1)->get();
        $tvcategory = LiveTvCategory::where('status', 1)->get();
        $embedded = Constant::where('type', 'STREAM_TYPE')->where('name', 'Embedded')->get();
        $url = Constant::where('type', 'STREAM_TYPE')->where('name', '!=', 'Embedded')->get();
        $assets = ['textarea'];
        $streamMapping = null;
        $module_title = __('livetv.add_tvchannel');
        $mediaUrls = getMediaUrls();
        return view('livetv::backend.channel.create', compact('plan', 'assets','tvcategory', 'embedded', 'url', 'streamMapping', 'module_title', 'mediaUrls'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(TvChannelRequest $request)
    {
        $data = $request->all();
        $data['poster_url'] = extractFileNameFromUrl($data['poster_url']);
        $data['poster_tv_url'] = extractFileNameFromUrl($data['poster_tv_url']);

        $liveTvChannel = $this->liveTvChannelService->create($data, $request);

        if ($liveTvChannel) {
            $message = trans('messages.create_form_livetv', ['form' => 'Tv Channel']);
            return redirect()->route('backend.tv-channel.index')->with('success', $message);
        }

        return redirect()->back()->withErrors(['error' => trans('messages.something_went_wrong')]);
    }



    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('livetv::show');
    }

    /**
     * Show the form for editing the specified resource.
     */


    public function edit($id)
    {
        $data = LiveTvChannel::withTrashed()->with('TvChannelStreamContentMappings')->findOrFail($id);
        $data->poster_url = setBaseUrlWithFileName($data->poster_url );
        $data->poster_tv_url = setBaseUrlWithFileName($data->poster_tv_url );
        $plan = Plan::where('status', 1)->get();
        $tvcategory = LiveTvCategory::where('status', 1)->get();
        $embedded = Constant::where('type', 'STREAM_TYPE')->where('name', 'Embedded')->get();
        $url = Constant::where('type', 'STREAM_TYPE')->where('name', '!=', 'Embedded')->get();
        $assets = ['textarea'];
        $module_title = __('livetv.edit_tvchannel');
        $mediaUrls = getMediaUrls();
        return view('livetv::backend.channel.edit', compact('data','assets', 'plan', 'tvcategory', 'embedded', 'url', 'module_title', 'mediaUrls'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TvChannelRequest $request, $id): RedirectResponse
    {
        $data = $request->all();
        $data['poster_url'] = extractFileNameFromUrl($data['poster_url']);
        $data['poster_tv_url'] = extractFileNameFromUrl($data['poster_tv_url']);

        $liveTvChannel = LiveTvChannel::findOrFail($id);



        if ($request->type === 't_url') {
            $data['stream_type'] = $request->input('stream_type');
            $data['server_url'] = $request->input('server_url');
            $data['server_url1'] = $request->input('server_url1');
            $data['embedded'] = null;
        } else if ($request->type === 't_embedded') {
            $data['stream_type'] = $request->input('stream_type');
            $data['server_url'] = null;
            $data['server_url1'] = null;
            $data['embedded'] = $request->input('embedded');
        }

        $liveTvChannel->update($data);


        $mappingstream = TvChannelStreamContentMapping::where('tv_channel_id', $id)->first();

        if (!empty($mappingstream) && !empty($data['stream_type'])) {
            $mappingstream->update([
                'type' => $data['type'],
                'stream_type' => $data['stream_type'],
                'embedded' => $data['embedded'],
                'server_url' => $data['server_url'],
                'server_url1' => $data['server_url1'],
            ]);
        }

        Cache::flush();

        $message = trans('messages.update_form_livetv', ['form' => 'Tv Channel']);
        return redirect()->route('backend.tv-channel.index')->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     */


    public function destroy($id)
    {
        $deleted = $this->liveTvChannelService->delete($id);
        $message = trans('messages.delete_form_livetv', ['form' => 'Tv Channel']);
        return response()->json(['message' => $message, 'status' => $deleted], 200);
    }

    /**
     * Restore the specified resource from trash.
     */


    public function restore($id)
    {
        $restored = $this->liveTvChannelService->restore($id);
        $message = trans('messages.restore_form_livetv', ['form' => 'Tv Channel']);
        return response()->json(['message' => $message, 'status' => $restored], 200);
    }

    /**
     * Permanently delete the specified resource.
     */


    public function forceDelete($id)
    {
        $forceDeleted = $this->liveTvChannelService->forceDelete($id);
        $message = trans('messages.permanent_delete_form_livetv', ['form' =>  'Tv Channel']);
        return response()->json(['message' => $message, 'status' => $forceDeleted], 200);
    }
}
