<?php

namespace Modules\Banner\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Modules\Banner\Models\Banner;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Modules\Banner\Http\Requests\BannerRequest;
use App\Trait\ModuleTrait;
use Modules\Entertainment\Models\Entertainment;
use Modules\LiveTV\Models\LiveTV;
use Modules\LiveTV\Models\LiveTvChannel;
use Modules\Banner\Services\BannerService;
use Illuminate\Support\Facades\Cache;
use Modules\Video\Models\Video;

class BannersController extends Controller
{
    protected string $exportClass = '\App\Exports\BannerExport';

    use ModuleTrait {
        initializeModuleTrait as private traitInitializeModuleTrait;
    }

    protected $bannerService;

    public function __construct(BannerService $bannerService)
    {
        $this->bannerService = $bannerService;

        $this->traitInitializeModuleTrait(
            'banner.title', // module title
            'banners', // module name
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
                'value' => 'type',
                'text' => __('banner.lbl_type'),
            ],
            [
                'value' => 'type_name',
                'text' => __('messages.name'),
            ],
            [
                'value' => 'status',
                'text' => __('messages.lbl_status'),
            ],

        ];
        $export_url = route('backend.banners.export');
        return view('banner::backend.banner.index', compact('module_action', 'filter', 'export_import', 'export_columns', 'export_url'));
    }

    public function bulk_action(Request $request)
    {
        $ids = explode(',', $request->rowIds);
        $actionType = $request->action_type;
        $moduleName = __('banner.title');

        Cache::flush();

        return $this->performBulkAction(Banner::class, $ids, $actionType, $moduleName);
    }

    public function update_status(Request $request, Banner $id)
    {
        $id->update(['status' => $request->status]);

        Cache::flush();

        return response()->json(['status' => true, 'message' => __('messages.status_updated_banner')]);
    }

    public function index_list($type)
    {
        $names = [];

        if ($type == 'movie' || $type == 'tvshow') {
            $names = Entertainment::where('type', $type)
                ->select('id', 'name', 'thumbnail_url', 'poster_url','poster_tv_url','tmdb_id')
                ->get()
                ->toArray();
        } else if ($type == 'video') {
            $names = Video::select('id', 'name', 'poster_url','poster_tv_url')
                ->get()
                ->toArray();
        }
        else if ($type == 'livetv') {
            $names = LiveTvChannel::select('id', 'name')
                ->get()
                ->toArray();
        }

        foreach ($names as &$value) {
            $value['thumbnail_url'] = isset($value['thumbnail_url'])
                ? setBaseUrlWithFileName($value['thumbnail_url'])
                : (isset($value['poster_url']) ? setBaseUrlWithFileName($value['poster_url']) : null);
        
            $value['poster_url'] = isset($value['poster_url'])
                ? setBaseUrlWithFileName($value['poster_url'])
                : null;
        
            $value['poster_tv_url'] = isset($value['poster_tv_url'])
                ? setBaseUrlWithFileName($value['poster_tv_url'])
                : null;
        }
        

        return response()->json($names);
    }

    public function index_data(Datatables $datatable, Request $request)
    {
        $query = Banner::query()->withTrashed();

        $movieEnabled = isenablemodule('movie') == 1;
        $tvshowEnabled = isenablemodule('tvshow') == 1;
        $videoEnabled = isenablemodule('video') == 1;

        $types = [];

        if ($movieEnabled) {
            $types[] = 'movie';
        }
        if ($tvshowEnabled) {
            $types[] = 'tvshow';
        }
        if ($videoEnabled) {
            $types[] = 'video';
        }

        // Always include 'livetv' regardless of other modules
        $types[] = 'livetv';

        $query->whereIn('type', $types);

        $filter = $request->filter;


        if (isset($filter['column_status'])) {
            $query->where('status', $filter['column_status']);
        }

        return $datatable->eloquent($query)
            ->addColumn('check', function ($data) {
                return '<input type="checkbox" class="form-check-input select-table-row" id="datatable-row-' . $data->id . '" name="datatable_ids[]" value="' . $data->id . '" data-type="banner" onclick="dataTableRowCheck(' . $data->id . ',this)">';
            })

            ->addColumn('image', function ($data) {
                $type = 'banner';
                $imageUrl = setBaseUrlWithFileName($data->file_url);

                return view('components.media-item', ['thumbnail' => $imageUrl, 'name' => $data->title, 'type' => $type])->render();

            })
            ->editColumn('type', function ($data) {
                return ucfirst($data->type) ?? '-';
            })
            ->addColumn('action', function ($data) {
                return view('banner::backend.banner.action', compact('data'));
            })
            ->editColumn('status', function ($data) {
                $checked = '';
                $disabled = '';

                // Check if the status is active
                if ($data->status) {
                    $checked = 'checked="checked"';
                }

                // Check if the record is soft-deleted and disable the checkbox if true
                if ($data->trashed()) {
                    $disabled = 'disabled';
                }
                return '
                    <div class="form-check form-switch">
                        <input type="checkbox" data-url="' . route('backend.banners.update_status', $data->id) . '" data-token="' . csrf_token() . '" class="switch-status-change form-check-input" id="datatable-row-' . $data->id . '" name="status" value="' . $data->id . '" ' . $checked . ' ' . $disabled . '>
                    </div>
                ';
            })

            ->filterColumn('image', function ($query, $keyword) {
                if (!empty($keyword)) {
                    $query->where('title', 'like', '%' . $keyword . '%');
                }
            })
            ->orderColumn('image', function ($query, $order) {
                $query->orderBy('title', $order);
            })

            ->editColumn('updated_at', function ($data) {
                $diff = \Carbon\Carbon::now()->diffInHours($data->updated_at);
                return $diff < 25 ? $data->updated_at->diffForHumans() : $data->updated_at->isoFormat('llll');
            })
            ->addColumn('banner_for', function ($row) {
                return ucfirst($row->banner_for); 
            })
            	
             ->orderColumn('banner_for', function ($query, $order) {
               $query->orderBy('banner_for', $order);
           })
            ->rawColumns(['action', 'status', 'check', 'image'])
            ->orderColumns(['id'], '-:column $1')
            ->make(true);
    }





    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */


    public function create()
    {
        $module_title = __('banner.add_title');
        $types = ['movie' => 'Movie', 'tvshow' => 'TV Show' , 'video' => 'Video'];
        $mediaUrls = getMediaUrls();
        return view('banner::backend.banner.create', compact('module_title', 'types', 'mediaUrls'));
    }


    public function store(BannerRequest $request)
    {
        $data = $request->all();
      
        $movie = Entertainment::where('id', $data['type_id'])->where('type', $data['type'])->first();

        $data['file_url'] = !empty($movie) && $movie->thumbnail_url === $data['file_url'] ? $data['file_url'] : extractFileNameFromUrl($data['file_url']);
        $data['poster_url'] = !empty($movie) && $movie->poster_url === $data['poster_url'] ? $data['poster_url'] : extractFileNameFromUrl($data['poster_url']);
        $data['poster_tv_url'] = $data['poster_tv_url'] ? extractFileNameFromUrl($data['poster_tv_url']) : null;
        $this->bannerService->create($data, $request);
        $title = __('banner.title');
        $message = trans('messages.create_form_banner', ['form' => $title]);
        return redirect()->route('backend.banners.index')->with('success', $message);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(Banner $banner)
    {
        $module_title = __('banner.edit_title');
        $types = ['movie' => 'Movie', 'tvshow' => 'TV Show' ,'video' => 'Video'];
        $names = [];

        $banner['name_id'] = $banner->type_id;
        $banner->file_url  = setBaseUrlWithFileName($banner->file_url);
        $banner->poster_url = setBaseUrlWithFileName($banner->poster_url);
        $banner->poster_tv_url = setBaseUrlWithFileName($banner->poster_tv_url);

        $mediaUrls = getMediaUrls();

        foreach ($types as $type => $label) {
            if ($type == 'movie' || $type == 'tvshow') {
                $names[$type] = Entertainment::where('type', $type)->pluck('name', 'id');
            } else if ($type == 'livetv') {
                $names[$type] = LiveTvChannel::pluck('name', 'id');
            }
            else if ($type == 'video') {
                $names[$type] = Video::pluck('name', 'id');
            }
        }

        return view('banner::backend.banner.edit', compact('module_title', 'types', 'names', 'banner', 'mediaUrls'));
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */


    public function update(BannerRequest $request, Banner $banner)
    {
        $data = $request->all();
        $data['type_id'] = $request->input('type_id');
        $data['type_name'] = $request->input('type_name');

        $movie = Entertainment::where('id', $data['type_id'])->where('type', $data['type'])->first();

        $data['file_url'] = !empty($movie) && $movie->thumbnail_url === $data['file_url'] ? $data['file_url'] : extractFileNameFromUrl($data['file_url']);
        $data['poster_url'] = !empty($movie) && $movie->poster_url === $data['poster_url'] ? $data['poster_url'] : extractFileNameFromUrl($data['poster_url']);
        $data['poster_tv_url'] = $data['poster_tv_url'] ? extractFileNameFromUrl($data['poster_tv_url']) : null;
    
        $banner->update($data);

        $title = __('banner.title');
        $message = trans('messages.update_form_banner', ['form' => $title]);
        return redirect()->route('backend.banners.index')->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */

    public function destroy($id)
    {
        $data = Banner::where('id', $id)->first();
        $data->delete();
        $title = __('banner.title');
        $message = trans('messages.delete_form_banner', ['form' => $title]);
        return response()->json(['message' => $message, 'status' => true], 200);
    }

    public function restore($id)
    {
        $data = Banner::withTrashed()->findOrFail($id);
        $data->restore();
        $title = __('banner.title');
        $message = trans('messages.restore_form_banner', ['form' => $title]);
        return response()->json(['message' => $message, 'status' => true], 200);
    }


    public function forceDelete($id)
    {
        $category = Banner::withTrashed()->findOrFail($id);
        $category->forceDelete();
        $title = __('banner.title');
        $message = trans('messages.permanent_delete_form_banner', ['form' => $title]);
        return response()->json(['message' => $message,'status' => true], 200);
    }
}



