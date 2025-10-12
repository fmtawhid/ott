<?php

namespace Modules\Season\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Controller;
use Modules\Season\Models\Season;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Modules\Season\Http\Requests\SeasonRequest;
use App\Trait\ModuleTrait;
use Modules\Constant\Models\Constant;
use Modules\Entertainment\Models\Entertainment;
use Modules\Season\Services\SeasonService;
use Modules\Subscriptions\Models\Plan;
use App\Services\ChatGTPService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class SeasonsController extends Controller
{
    protected string $exportClass = '\App\Exports\SeasonExport';

    protected $seasonService;
    protected $chatGTPService;

    use ModuleTrait {
        initializeModuleTrait as private traitInitializeModuleTrait;
        }


    public function __construct(SeasonService $seasonService,ChatGTPService $chatGTPService)
    {
        $this->seasonService = $seasonService;
        $this->chatGTPService=$chatGTPService;

        $this->traitInitializeModuleTrait(
            'season.title',
            'seasons',
            'fa-solid fa-clipboard-list'
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
                'text' => __('messages.name'),
            ],
            [
                'value' => 'access',
                'text' => __('episode.lbl_season') . ' ' . __('movie.lbl_movie_access'),
            ],


            [
                'value' => 'plan_id',
                'text' => __('movie.plan'),
            ],

            [
                'value' => 'entertainment_id',
                'text' => __('movie.lbl_tv_show'),
            ],


            [
                'value' => 'status',
                'text' => __('plan.lbl_status'),
            ]
        ];
        $export_url = route('backend.seasons.export');

        $plan=Plan::where('status',1)->get();

        $tvshows = Entertainment::where('type','tvshow')->get();

        return view('season::backend.season.index', compact('module_action', 'filter', 'export_import', 'export_columns', 'export_url','plan','tvshows'));
    }

    public function bulk_action(Request $request)
    {
        $ids = explode(',', $request->rowIds);
        $actionType = $request->action_type;
        $moduleName = 'Season'; // Adjust as necessary for dynamic use
        Cache::flush();


        return $this->performBulkAction(Season::class, $ids, $actionType, $moduleName);
    }

    public function index_data(Datatables $datatable, Request $request)
    {
        $filter = $request->filter;
        return $this->seasonService->getDataTable($datatable, $filter);
    }


    public function index_list(Request $request)
    {
        $term = trim($request->q);

        $query_data = Season::query();

        if ($request->filled('entertainment_id')) {
            $query_data->where('entertainment_id', $request->entertainment_id);
        }

        $query_data = $query_data->where('status', 1)->get();

        $data = $query_data->map(function ($row) {
            return [
                'id' => $row->id,
                'name' => $row->name,
            ];
        });

        return response()->json($data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */

      public function create()
    {

        $upload_url_type=Constant::where('type','upload_type')->get();

        $plan=Plan::where('status',1)->get();

        $tvshows=Entertainment::Where('type','tvshow')->where('status', 1)->orderBy('id','desc')->get();

        $imported_tvshow = Entertainment::where('type', 'tvshow')
        ->where('status', 1)
        ->whereNotNull('tmdb_id')
        ->get();

        $assets = ['textarea'];
        $seasons=null;

        $module_title = __('season.new_title');
        $mediaUrls =  getMediaUrls();

        return view('season::backend.season.create', compact('upload_url_type','assets','plan','tvshows','module_title','mediaUrls','imported_tvshow','seasons'));

    }




    public function store(SeasonRequest $request)
{
    // Get all the request data
    $data = $request->all();

    // Process images and URLs if TMDB ID exists
    $data['poster_url'] = !empty($data['tmdb_id']) ? $data['poster_url'] : extractFileNameFromUrl($data['poster_url']);
    $data['poster_tv_url'] = !empty($data['tmdb_id']) ? $data['poster_tv_url'] : extractFileNameFromUrl($data['poster_tv_url']);

    // If the trailer is local, process the video file name
    if ($request->trailer_url_type == 'Local') {
        $data['trailer_video'] = extractFileNameFromUrl($data['trailer_video']);
    }

    // Handle trailer embed code if the type is 'Embedded'
    if ($request->trailer_url_type === 'Embedded') {
        $data['trailer_url'] = $request->input('trailer_embedded');
    }

    //  Handle SEO image file upload
    if ($request->hasFile('seo_image')) {
        $image = $request->file('seo_image');
        $originalName = $image->getClientOriginalName();
        $safeName = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $originalName);
        $path = $image->storeAs('public/uploads/seo', $safeName);
        $data['seo_image'] = basename($path); // Store only filename
    } else {
        $data['seo_image'] = $request->input('seo_image'); // fallback in case it's set from input
    }

    // Handle SEO fields
    $data['slug'] = $request->input('slug');
    $data['meta_title'] = $request->input('meta_title');
    // $data['meta_keywords'] = $request->input('meta_keywords');
     if (isset($data['meta_keywords'])) {
        // If it's an array, convert it to a comma-separated string
        if (is_array($data['meta_keywords'])) {
            $data['meta_keywords'] = implode(',', $data['meta_keywords']);
        }
        // If it's already a string, we can just keep it as is
    } else {
        // If meta_keywords isn't provided, set it as an empty string
        $data['meta_keywords'] = '';
    }

    $data['meta_description'] = $request->input('meta_description');
    $data['google_site_verification'] = $request->input('google_site_verification');
    $data['canonical_url'] = $request->input('canonical_url');
    $data['short_description'] = $request->input('short_description');

    // Create the season record and save SEO fields
    $season = $this->seasonService->create($data);

    // 🟢 FCM Notification Automatically Create
    try {
        \App\Models\FCM::create([
            'title' => 'New Season Coming! ',
            'message' => $season->name ?? 'Check out the latest season!',
        ]);
    } catch (\Exception $e) {
        \Log::error('FCM Notification failed (Season): ' . $e->getMessage());
    }

    // Optionally update the season record with SEO fields if not handled by `create` directly
    $season->meta_keywords = $data['meta_keywords'];
    $season->meta_description = $data['meta_description'];
    $season->seo_image = $data['seo_image']; // Make sure seo_image is the filename
    $season->save();

    // Prepare notification data
    $notification_data = [
        'id' => $season->id,
        'name' => $season->name,
        'poster_url' => $season->poster_url ?? null,
        'type' => 'season',
        'release_date' => optional($season->entertainmentdata)->release_date ?? null,
        'description' => $season->description ?? null,
    ];

    sendNotifications($notification_data);
    // dd($data);

    // Success message and redirect
    $message = __('messages.create_form_season', ['form' => 'Season']);
    return redirect()->route('backend.seasons.index')->with('success', $message);
}




    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
{
    // Retrieve the season record by its ID or fail
    $data = Season::findOrFail($id);

    // Get the TMDB ID (useful for populating related fields or showing specific data)
    $tmdb_id = $data->tmdb_id;

    // Set poster URLs with the base URL if not already full URLs
    $data->poster_url = setBaseUrlWithFileName($data->poster_url);
    $data->poster_tv_url = setBaseUrlWithFileName($data->poster_tv_url);

    // Process trailer URL for local videos (if trailer is of type 'Local')
    if ($data->trailer_url_type == 'Local') {
        $data->trailer_url = setBaseUrlWithFileName($data->trailer_url);
    }

    // Get upload URL types, assuming this holds different upload options (like Local, URL, etc.)
    $upload_url_type = Constant::where('type', 'upload_type')->get();

    // Get active plans (for selection in the form)
    $plan = Plan::where('status', 1)->get();

    // Define assets (e.g., textareas, or any other form components you want to use)
    $assets = ['textarea'];

    // Get TV shows for selection (assuming we have a relationship with TV shows for this season)
    $tvshows = Entertainment::where('type', 'tvshow')->where('status', 1)->orderBy('id', 'desc')->get();

    // Define the title for the edit form (translatable)
    $module_title = __('season.edit_title');

    // Get media URLs (could be used for things like image handling)
    $mediaUrls = getMediaUrls();

    // Assuming the 'Season' model has the SEO fields (meta_title, meta_keywords, etc.), you can pass them like this:
    $seo = (object) [
        'meta_title' => $data->meta_title,
         'meta_keywords' => $data->meta_keywords,
        'meta_description' => $data->meta_description,
        'seo_image' => $data->seo_image,
        'google_site_verification' => $data->google_site_verification,
        'canonical_url' => $data->canonical_url,
        'short_description' => $data->short_description
    ];


    // Pass all data to the edit view for rendering the form, including SEO data
    return view('season::backend.season.edit', compact(
        'data', // the current season data
        'tmdb_id', // TMDB ID (if relevant for SEO or poster/image handling)
        'upload_url_type', // upload URL options
        'plan', // available plans for selection
        'tvshows', // list of TV shows
        'module_title', // title for the page
        'mediaUrls', // any media URLs for form handling
        'assets', // any special assets like textareas or rich text editors
        'seo' // the SEO data to be used in the view
    ));
}



    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */


public function update(SeasonRequest $request, $id)
{
    // dd(request()->all());
    $requestData = $request->all();

    // Handle poster URLs
    $requestData['poster_url'] = !empty($requestData['tmdb_id']) ? $requestData['poster_url'] : extractFileNameFromUrl($requestData['poster_url']);
    $requestData['poster_tv_url'] = !empty($requestData['tmdb_id']) ? $requestData['poster_tv_url'] : extractFileNameFromUrl($requestData['poster_tv_url']);

    // Handle trailer video if local
    if ($request->trailer_url_type == 'Local') {
        $requestData['trailer_video'] = extractFileNameFromUrl($requestData['trailer_video']);
    }

    // Handle embedded trailer code
    if ($request->trailer_url_type === 'Embedded') {
        $requestData['trailer_url'] = $request->input('trailer_embedded');
    }

    // Handle SEO image file upload
    if ($request->hasFile('seo_image')) {
        $image = $request->file('seo_image');
        $originalName = $image->getClientOriginalName();
        $safeName = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $originalName);
        $path = $image->storeAs('public/uploads/seo', $safeName);
        $requestData['seo_image'] = basename($path); // Store only filename
    }

    // Assign SEO-related fields
    $requestData['slug'] = $request->input('slug');
    $requestData['meta_title'] = $request->input('meta_title');

    // Handle meta keywords: convert array to comma-separated string
    if (isset($requestData['meta_keywords_input']) && !empty($requestData['meta_keywords_input'])) {
        // If it's a comma-separated string, convert it to an array
        if (!is_array($requestData['meta_keywords_input'])) {
            // Split the string into an array
            $requestData['meta_keywords_input'] = explode(',', $requestData['meta_keywords_input']);
        }
        // Implode the array back to a comma-separated string
        $requestData['meta_keywords_input'] = implode(',', $requestData['meta_keywords_input']);
    } else {
        // If it's empty or not set, set it to an empty string
        $requestData['meta_keywords_input'] = ''; // Fallback if empty or not set
    }


    // Handle meta description similarly to meta_keywords
    $requestData['meta_description'] = $request->input('meta_description', '');

    // If empty or undefined, set it to null or some default value (optional)
    if (empty($requestData['meta_description'])) {
        $requestData['meta_description'] = null; // Optional: Set default if it's empty
    }

    $requestData['google_site_verification'] = $request->input('google_site_verification');
    $requestData['canonical_url'] = $request->input('canonical_url');
    $requestData['short_description'] = $request->input('short_description');

    // Update season
    $this->seasonService->update($id, $requestData);

    // Redirect with success message
    $message = __('messages.update_form_season', ['form' => 'Season']);
    return redirect()->route('backend.seasons.index')->with('success', $message);
}



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */

    public function destroy($id)
    {

        $this->seasonService->delete($id);

        $message = __('messages.delete_form_season', ['form' => 'Season']);
        return response()->json(['message' => $message, 'status' => true], 200);
    }

    public function restore($id)
    {
        $this->seasonService->restore($id);
        $message = __('messages.restore_form_season', ['form' => 'Season']);
        return response()->json(['message' => $message, 'status' => true], 200);
    }

    public function forceDelete($id)
    {
        $this->seasonService->forceDelete($id);

        $message = __('messages.permanent_delete_form_season', ['form' => 'Season']);
        return response()->json(['message' => $message, 'status' => true], 200);
    }

    public function update_status(Request $request, Season $id)
    {
        $id->update(['status' => $request->status]);
        Cache::flush();


        return response()->json(['status' => true, 'message' => __('messages.status_updated_season')]);
    }

    public function ImportSeasonlist(Request $request){

        $tv_show_id=$request->tmdb_id;

        $tvshowjson = $this->seasonService->getSeasonsList($tv_show_id);
        $tvshowDetails = json_decode($tvshowjson, true);

        while($tvshowDetails === null) {

            $tvshowjson = $this->seasonService->getSeasonsList($tv_show_id);
           $tvshowDetails = json_decode($tvshowjson, true);

        }

        if (isset($seasons['success']) && $seasons['success'] === false) {
            return response()->json([
                'success' => false,
                'message' => $seasons['status_message']
            ], 400);
        }

        $seasonsData= [];

        if(isset($tvshowDetails['seasons']) && is_array($tvshowDetails['seasons'])) {

            foreach ($tvshowDetails['seasons'] as $season) {
                $seasonlist = [
                    'name' => $season['name'],
                    'season_number'=>$season['season_number'],
                ];

                $seasonsData[] = $seasonlist;
            }
         }
        return response()->json($seasonsData);
     }

     public function ImportSeasonDetails(Request $request){

        $tvshow_id=$request->tvshow_id;
        $season_id=$request->season_id;

        $season=Season::where('tmdb_id', $tvshow_id)->where('season_index',$season_id)->first();

        if(!empty($season)){

            $message = __('season.already_added_season');

            return response()->json([
                'success' => false,
                'message' => $message,
            ], 400);

        }

        $configuration =$this->seasonService->getConfiguration();
        $configurationData = json_decode($configuration, true);

        while($configurationData === null) {

            $configuration =$this->seasonService->getConfiguration();
            $configurationData = json_decode($configuration, true);
        }

        if(isset($configurationData['success']) && $configurationData['success'] === false) {
            return response()->json([
                'success' => false,
                'message' => $configurationData['status_message']
            ], 400);
        }

        $seasonData = $this->seasonService->getSeasonsDetails($tvshow_id,$season_id);
        $seasonDetails = json_decode($seasonData, true);

        while($seasonDetails === null) {

            $seasonData = $this->seasonService->getSeasonsDetails($tvshow_id,$season_id );
            $seasonDetails = json_decode($seasonData, true);

        }

        if (isset($seasonDetails['success']) && $seasonDetails['success'] === false) {
            return response()->json([
                'success' => false,
                'message' => $seasonDetails['status_message']
            ], 400);
        }

        $seasonvideos = $this->seasonService->getSeasonVideos($tvshow_id,$season_id);
        $seasonvideo = json_decode($seasonvideos, true);

        while ($seasonvideo === null) {

             $seasonvideos = $this->seasonService->getSeasonVideos($tvshow_id,$season_id);
             $seasonvideo = json_decode($seasonvideos, true);
        }

        if (isset($seasonvideo['success']) && $seasonvideo['success'] === false) {
            return response()->json([
                'success' => false,
                'message' => $seasonvideo['status_message']
            ], 400);
        }

        $trailer_url_type=null;
        $trailer_url=null;

        if(isset($seasonvideo['results']) && is_array($seasonvideo['results'])) {

            foreach($seasonvideo['results'] as $video) {

                if($video['type'] == 'Trailer'){

                    $trailer_url_type= $video['site'];
                    $trailer_url='https://www.youtube.com/watch?v='.$video['key'];

                }
            }
        }

        $tvshows = Entertainment::where('tmdb_id',$tvshow_id)->first();

        $data = [

            'poster_url' => $configurationData['images']['secure_base_url'] . 'original' . $seasonDetails['poster_path'],
            'trailer_url_type'=>$trailer_url_type,
            'trailer_url'=>$trailer_url,
            'name' => $seasonDetails['name'],
            'description' => $seasonDetails['overview'],
            'entertainment_id'=>$tvshows->id,
            'access'=>'free',
            'season_index'=>$season_id,
            'tvshow_id'=>$tvshow_id,

        ];

             return response()->json([
                'success' => true,
                'data' => $data,
            ], 200);

     }

     public function generateDescription(Request $request)
     {
         $name = $request->input('name');
         $description = $request->input('description');
         $tvshow=$request->input('tvshow');
         $type=$request->input('type');

         $tvshows=Entertainment::Where('id',$tvshow)->first();

         if( $tvshows){

            $name= $name.'of'.$tvshows->name;
         }

         $result = $this->chatGTPService->GenerateDescription($name, $description, $type);

         $result =json_decode( $result, true);

         if (isset($result['error'])) {
             return response()->json([
                 'success' => false,
                 'message' => $result['error']['message'],
             ], 400);
         }

         return response()->json([

             'success' => true,
             'data' => isset($result['choices'][0]['message']['content']) ? $result['choices'][0]['message']['content'] : null,
         ], 200);
     }

    public function details($id)
{
    $data = Season::with([
        'entertainmentdata',
        'episodes',
        'plan',
    ])->findOrFail($id);

    // Set base URL for poster and formatted release date
    $data->poster_url = setBaseUrlWithFileName($data->poster_url);
    $data->formatted_release_date = Carbon::parse($data->release_date)->format('d M, Y');

    // Meta values to be passed
    $meta_title = $data->meta_title ?? 'Default Meta Title';  // Use default if not set
    $meta_description = $data->meta_description ?? 'Default Meta Description';
    $meta_keywords = $data->meta_keywords ?? 'Default Meta Keywords';
    $favicon_url = 'path/to/favicon.ico';  // Set a default favicon or dynamically

    // Passing to the view
    $module_title = __('season.title');
    $show_name = $data->name;
    $route = 'backend.seasons.index';

    return view('season::backend.season.details', compact(
        'data',
        'module_title',
        'show_name',
        'route',
        'meta_title',  // Pass meta title to the view
        'meta_description',  // Pass meta description to the view
        'meta_keywords',  // Pass meta keywords to the view
        'favicon_url'  // Pass favicon URL to the view
    ));
}


}
