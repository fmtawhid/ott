<?php

namespace Modules\Entertainment\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Modules\Entertainment\Models\Entertainment;
use Illuminate\Http\Request;
use Modules\Entertainment\Http\Requests\EntertainmentRequest;
use App\Trait\ModuleTrait;
use Modules\Constant\Models\Constant;
use Modules\Subscriptions\Models\Plan;
use Modules\Genres\Models\Genres;
use Modules\CastCrew\Models\CastCrew;
use Modules\Entertainment\Services\EntertainmentService;
use Modules\World\Models\Country;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Modules\Entertainment\Models\Subtitle;
use Illuminate\Support\Facades\Storage;
use Modules\SEO\Models\Seo;

class EntertainmentsController extends Controller
{
    protected string $exportClass = '\App\Exports\EntertainmentExport';


    use ModuleTrait {
        initializeModuleTrait as private traitInitializeModuleTrait;
        }

        protected $entertainmentService;

        public function __construct(EntertainmentService $entertainmentService)
        {
            $this->entertainmentService = $entertainmentService;

            $this->traitInitializeModuleTrait(
                'castcrew.castcrew_title',
                'castcrew',

                'fa-solid fa-clipboard-list'
            );
        }


    public function index(Request $request)
    {
        $filter = [
            'status' => $request->status,
        ];

        $module_action = 'List';

         $seo = Seo::first();

        $keywords = $seo->meta_keywords ? explode(',', $seo->meta_keywords) : [];

        $export_import = true;
        $export_columns = [
            [
                'value' => 'name',
                'text' => ' Name',
            ]
        ];
        $export_url = route('backend.entertainments.export');

        return view('entertainment::backend.entertainment.index', compact('module_action', 'filter', 'export_import', 'export_columns', 'export_url','keywords'));
    }

    public function bulk_action(Request $request)
    {
        $ids = explode(',', $request->rowIds);
        $actionType = $request->action_type;
        $moduleName = 'Entertainment'; // Adjust as necessary for dynamic use

        Cache::flush();


        return $this->performBulkAction(Entertainment::class, $ids, $actionType, $moduleName);
    }



public function store(EntertainmentRequest $request)
{
    // Get all request data
    $data = $request->all();

    // Handle movie access and related options
    if ($data['movie_access'] == "pay-per-view") {
        $data['download_status'] = 0;
    }

    if (Seo::where('meta_title', $data['meta_title'])->exists()) {
        return redirect()->back()->withErrors(['meta_title' => 'This Meta Title is already taken. Please choose a different one.']);
    }

    // Handle SEO image upload and store only the filename
    if ($request->hasFile('seo_image')) {
        $image = $request->file('seo_image');

        // Generate a safe filename for the image
        $originalName = $image->getClientOriginalName();
        $safeName = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $originalName);

        // Store the image and save only the filename
        $path = $image->storeAs('public/uploads/seo', $safeName);
        $data['seo_image'] = 'storage/uploads/seo/' . basename($path); // CORRECT
        // Only store the filename, not the full path
    }

    // Handle video quality types
    if (!empty($data['video_quality_type'])) {
        foreach ($data['video_quality_type'] as $key => $type) {
            if ($type === 'Embedded') {
                // Handle embedded video URLs
                if (isset($data['quality_video_embed_input'][$key])) {
                    $data['quality_video_url_input'][$key] = $data['quality_video_embed_input'][$key];
                }
            } else {
                // Handle URL types like YouTube, Vimeo, etc.
                if (isset($data['quality_video_url_input'][$key])) {
                    if (preg_match('/<iframe[^>]+src=[\'"]([^\'"]+)[\'"]/i', $data['quality_video_url_input'][$key], $matches)) {
                        $data['quality_video_url_input'][$key] = $matches[1];
                    }
                }
            }
        }
    }

    // Handle iframe content differently for video URL
    $videoType = $data['video_upload_type'] ?? null;
    $videoUrl = $data['video_url_input'] ?? null;

    if ($videoType === 'Embedded') {
        $data['video_url_input'] = $request->input('embedded');
    } else {
        if (preg_match('/<iframe[^>]+src=[\'"]([^\'"]+)[\'"]/i', $videoUrl, $matches)) {
            $data['video_url_input'] = $matches[1];
        }
    }

    // Handle trailer embed code
    if ($request->trailer_url_type === 'Embedded') {
        $data['trailer_url'] = $request->input('trailer_embedded');
    }

    // Handle SEO fields

    $data['meta_title'] = $request->input('meta_title');

    // Convert the array of meta keywords into a comma-separated string
    // Check if 'meta_keywords' is in the request and is an array before trying to implode it
    if (isset($data['meta_keywords']) && is_array($data['meta_keywords'])) {
        $data['meta_keywords'] = implode(',', $data['meta_keywords']);
    } elseif (!isset($data['meta_keywords'])) {
        // Optionally, set a default value if 'meta_keywords' is not set
        $data['meta_keywords'] = '';
    }



    $data['meta_description'] = $request->input('meta_description', '');
    $data['google_site_verification'] = $request->input('google_site_verification');
    $data['canonical_url'] = $request->input('canonical_url');
    $data['short_description'] = $request->input('short_description');

    // Handle other image uploads (e.g., thumbnails, posters, etc.)
    $data['thumbnail_url'] = !empty($data['tmdb_id']) ? $data['thumbnail_url'] : extractFileNameFromUrl($data['thumbnail_url']);
    $data['poster_url'] = !empty($data['tmdb_id']) ? $data['poster_url'] : extractFileNameFromUrl($data['poster_url']);
    $data['poster_tv_url'] = !empty($data['tmdb_id']) ? $data['poster_tv_url'] : extractFileNameFromUrl($data['poster_tv_url']);

// Process additional image/video fields (e.g., IMDb rating, trailer, etc.)
    if (!empty($data['IMDb_rating'])) {
        $data['IMDb_rating'] = round($data['IMDb_rating'], 1);
    } else {
        $data['IMDb_rating'] = null; // যদি না আসে বা empty হয়
    }

    // Create the entertainment record
    $entertainment = $this->entertainmentService->create($data);
    // 🟢 FCM Notification Automatically Create
    try {
        \App\Models\FCM::create([
            'title' => 'New ' . ucfirst($entertainment->type) . ' added!',
            'message' => $entertainment->name ?? 'Check out the latest ' . $entertainment->type,
        ]);
    } catch (\Exception $e) {
        \Log::error('FCM Notification failed: ' . $e->getMessage());
    }
    // Handle multiple subtitles
    if ($request->enable_subtitle && $request->has('subtitles')) {
        foreach ($request->file('subtitles') as $index => $subtitleInput) {
            $language = $request->input("subtitles.$index.language");
            $file = $subtitleInput['subtitle_file'] ?? null;
            $isDefault = $request->input("subtitles.$index.is_default", false);

            $lang_arr = Constant::where('type', 'subtitle_language')->where('value', $language)->first();

            if ($file) {
                $extension = strtolower($file->getClientOriginalExtension());
                if (!in_array($extension, ['srt', 'vtt'])) {
                    throw new \Exception('Only .srt and .vtt files are allowed');
                }

                $filename = time() . '_' . $index . '_' . str_replace(' ', '_', $file->getClientOriginalName());

                // If it's an SRT file, convert it to VTT
                if ($extension === 'srt') {
                    $srtContent = file_get_contents($file->getRealPath());
                    $vttContent = convertSrtToVtt($srtContent);
                    $filename = pathinfo($filename, PATHINFO_FILENAME) . '.vtt';
                    Storage::disk('public')->put('subtitles/' . $filename, $vttContent);
                } else {
                    // Store original VTT file
                    $file->storeAs('subtitles', $filename, 'public');
                }

                $entertainment->subtitles()->create([
                    'entertainment_id' => $entertainment->id,
                    'language_code' => $language,
                    'language' => $lang_arr->name ?? null,
                    'subtitle_file' => $filename,
                    'is_default' => $isDefault ? 1 : 0,
                    'type' => 'movie',
                ]);
            }
        }
    }

    DB::commit();  // Commit the transaction

    // Send success message and redirect
    $message = trans('messages.create_form', ['type' => ucfirst($entertainment->type)]);

    Cache::flush();

    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'message' => $message,
            'redirect' => $entertainment->type == 'movie' ? route('backend.movies.index') : route('backend.tvshows.index')
        ]);
    }

    return redirect()->route($entertainment->type == 'movie' ? 'backend.movies.index' : 'backend.tvshows.index')
        ->with('success', $message);
}



    public function update_status(Request $request, Entertainment $id)
    {
        $id->update(['status' => $request->status]);

        Cache::flush();

        return response()->json(['status' => true, 'message' => __('messages.status_updated_movie')]);
    }


    public function update_is_restricted(Request $request, Entertainment $id)
    {

        $id->update(['is_restricted' => $request->status]);

        Cache::flush();

        $message='';

        if ($request->status == 1) {
            $message = __('messages.content_added_to_restricted');
        } else {
            $message = __('messages.content_removed_from_restricted');
        }

        return response()->json(['status' => true, 'message' => $message]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
{
    // Fetch the entertainment data along with related data (SEO settings, etc.)
    $data = Entertainment::where('id', $id)
        ->with([
            'entertainmentGenerMappings',
            'entertainmentCountryMappings',
            'entertainmentStreamContentMappings',
            'entertainmentTalentMappings',
            'subtitles'
        ])
        ->first();

    // Initialize SEO data as an object
    $seo = (object) [
        'enable_seo' => $data->enable_seo ?? 0,
        'meta_title' => $data->meta_title,
        'meta_keywords' => $data->meta_keywords,
        'meta_description' => $data->meta_description,
        'seo_image' => $data->seo_image,
        'google_site_verification' => $data->google_site_verification,
        'canonical_url' => $data->canonical_url,
        'short_description' => $data->short_description
    ];

    // Set the base URL for the images
    $tmdb_id = $data->tmdb_id;
    $data->thumbnail_url = setBaseUrlWithFileName($data->thumbnail_url);
    $data->poster_url = setBaseUrlWithFileName($data->poster_url);
    $data->poster_tv_url = setBaseUrlWithFileName($data->poster_tv_url);

    // Set trailer URL and video URL based on their types
    if ($data->trailer_url_type == 'Local') {
        $data->trailer_url = setBaseUrlWithFileName($data->trailer_url);
    }

    if ($data->video_upload_type == 'Local') {
        $data->video_url_input = setBaseUrlWithFileName($data->video_url_input);
    }

    // Fetch constants for dropdowns
    $constants = Constant::whereIn('type', ['upload_type', 'movie_language', 'video_quality', 'subtitle_language'])->get();
    $upload_url_type = $constants->where('type', 'upload_type');
    $movie_language = $constants->where('type', 'movie_language');
    $video_quality = $constants->where('type', 'video_quality');
    $subtitle_language = $constants->where('type', 'subtitle_language');

    // Fetch related data like plans, genres, actors, and directors
    $plan = Plan::where('status', 1)->get();
    $genres = Genres::where('status', 1)->get();
    $actors = CastCrew::where('type', 'actor')->get();
    $directors = CastCrew::where('type', 'director')->get();
    $countries = Country::where('status', 1)->get();
    $mediaUrls = getMediaUrls();
    $assets = ['textarea'];

    // Set the module title based on the type of entertainment (movie or tvshow)
    $module_title = ($data->type === 'tvshow') ? __('tvshow.edit_title') : __('movie.edit_title');

    // Set options for number selection
    $numberOptions = collect(range(1, 10))->mapWithKeys(function ($number) {
        return [$number => $number];
    });

    // Set the genres, countries, actors, and directors data for the view
    $data['genres_data'] = $data->entertainmentGenerMappings->pluck('genre_id')->toArray();
    $data['countries'] = $data->entertainmentCountryMappings->pluck('country_id')->toArray();
    $data['actors'] = $data->entertainmentTalentMappings->pluck('talent_id')->toArray();
    $data['directors'] = $data->entertainmentTalentMappings->pluck('talent_id')->toArray();

    // Pass all required data to the view
    return view('entertainment::backend.entertainment.edit', compact(
        'data', 'seo', 'tmdb_id', 'upload_url_type', 'plan', 'movie_language',
        'genres', 'numberOptions', 'actors', 'directors', 'countries',
        'video_quality', 'mediaUrls', 'assets', 'module_title', 'subtitle_language'
    ));
}








public function update(EntertainmentRequest $request, $id)
{
    $request_data = $request->all();

    $requestData = $request->all();

    // Handle movie access and related options
    if ($request_data['movie_access'] == "pay-per-view") {
        $request_data['download_status'] = 0;
    }

    // Handle video quality embedded codes
    if (!empty($request_data['video_quality_type'])) {
        foreach ($request_data['video_quality_type'] as $key => $type) {
            if ($type === 'Embedded') {
                if (isset($request_data['quality_video_embed_input'][$key])) {
                    $request_data['quality_video_url_input'][$key] = $request_data['quality_video_embed_input'][$key];
                }
            } else if (in_array($type, ['URL', 'YouTube', 'HLS', 'Vimeo', 'x265'])) {
                if (isset($request_data['quality_video_url_input'][$key])) {
                    if (preg_match('/<iframe[^>]+src=[\'"]([^\'"]+)[\'"]/i', $request_data['quality_video_url_input'][$key], $matches)) {
                        $request_data['quality_video_url_input'][$key] = $matches[1];
                    }
                }
            }
        }
    }

    // Handle trailer embed code
    if ($request->trailer_url_type === 'Embedded') {
        $request_data['trailer_url'] = $request->input('trailer_embedded');
    }

    // Handle video embed code and iframe extraction
    $videoUrl = $request->input('video_url_input');
    $videoType = $request->input('video_upload_type');
    if ($videoType === 'Embedded') {
        $request_data['video_url_input'] = $request->input('video_embedded');
    } else {
        if (preg_match('/<iframe[^>]+src=[\'"]([^\'"]+)[\'"]/i', $videoUrl, $matches)) {
            $request_data['video_url_input'] = $matches[1];
        }
    }

    // Handle SEO fields
    $request_data['meta_title'] = $request->input('meta_title');

    // Convert the array of meta keywords into a comma-separated string
    if (isset($requestData['meta_keywords_input']) && !empty($requestData['meta_keywords_input'])) {
        // If meta_keywords is not already an array, make it an array (e.g., splitting by commas)
        if (!is_array($requestData['meta_keywords_input'])) {
            $requestData['meta_keywords_input'] = explode(',', $requestData['meta_keywords_input']);
        }
        // Implode the array back to a comma-separated string
        $requestData['meta_keywords_input'] = implode(',', $requestData['meta_keywords_input']);
    } else {
        $requestData['meta_keywords_input'] = ''; // Fallback if empty or not set
    }

    // Handle meta description similarly to meta_keywords
    $request_data['meta_description'] = $request->input('meta_description', '');

    // If empty or undefined, set it to null or some default value (optional)
    if (empty($request_data['meta_description'])) {
        $request_data['meta_description'] = null; // Optional: Set default if it's empty
    }

    $request_data['google_site_verification'] = $request->input('google_site_verification');
    $request_data['canonical_url'] = $request->input('canonical_url');
    $request_data['short_description'] = $request->input('short_description');

    // Handle SEO Image if it exists
    if ($request->hasFile('seo_image')) {
        $image = $request->file('seo_image');

        // Generate a safe filename for the image
        $originalName = $image->getClientOriginalName();
        $safeName = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $originalName);

        // Store the image and save only the filename
        $path = $image->storeAs('public/uploads/seo', $safeName);
        $request_data['seo_image'] = basename($path); // Only store the filename, not the full path
    }

    // Handle URLs and image processing
    $request_data['thumbnail_url'] = !empty($request_data['tmdb_id']) ? $request_data['thumbnail_url'] : extractFileNameFromUrl($request_data['thumbnail_url']);
    $request_data['poster_url'] = !empty($request_data['tmdb_id']) ? $request_data['poster_url'] : extractFileNameFromUrl($request_data['poster_url']);
    $request_data['poster_tv_url'] = !empty($request_data['tmdb_id']) ? $request_data['poster_tv_url'] : extractFileNameFromUrl($request_data['poster_tv_url']);
    $request_data['trailer_video'] = extractFileNameFromUrl($request_data['trailer_video']);
    $request_data['video_file_input'] = isset($request_data['video_file_input']) ? extractFileNameFromUrl($request_data['video_file_input']) : null;

    if (isset($request_data['IMDb_rating']) && $request_data['IMDb_rating'] !== '') {
        $request_data['IMDb_rating'] = round($request_data['IMDb_rating'], 1);
    } else {
        $request_data['IMDb_rating'] = null; // null করে দেবে
    }

    // Retrieve the existing entertainment entry
    $entertainment = $this->entertainmentService->getById($id);

    // Handle subtitles
    if ($request->has('deleted_subtitles')) {
        $deletedIds = explode(',', $request->deleted_subtitles);
        Subtitle::whereIn('id', $deletedIds)->delete();
    }

    if ($request->enable_subtitle == 1 && $request->has('subtitles')) {
        foreach ($request->subtitles as $key => $subtitleData) {
            $languageCode = $subtitleData['language'] ?? null;
            $file = $subtitleData['subtitle_file'] ?? null;
            $isDefault = isset($subtitleData['is_default']) && $subtitleData['is_default'] == 1;

            if (!$languageCode) continue; // Skip if no language code

            $lang_arr = Constant::where('type', 'subtitle_language')->where('value', $languageCode)->first();
            $existingSubtitle = $entertainment->subtitles()->where('language_code', $languageCode)->first();

            if ($file) {
                $extension = strtolower($file->getClientOriginalExtension());

                if (!in_array($extension, ['srt', 'vtt'])) {
                    return back()
                        ->withErrors(["subtitle_file.$key" => 'Only .srt and .vtt files are allowed'])
                        ->withInput();
                }

                $filename = time() . '_' . $key . '_' . str_replace(' ', '_', $file->getClientOriginalName());

                if ($extension === 'srt') {
                    $srtContent = file_get_contents($file->getRealPath());
                    $vttContent = convertSrtToVtt($srtContent);
                    $filename = pathinfo($filename, PATHINFO_FILENAME) . '.vtt';
                    Storage::disk('public')->put('subtitles/' . $filename, $vttContent);
                } else {
                    $file->storeAs('subtitles', $filename, 'public');
                }

                if ($existingSubtitle) {
                    $existingSubtitle->update([
                        'subtitle_file' => $filename,
                        'is_default' => $isDefault ? 1 : 0,
                        'language' => $lang_arr->name ?? null,
                    ]);
                } else {
                    $entertainment->subtitles()->create([
                        'entertainment_id' => $entertainment->id,
                        'language_code' => $languageCode,
                        'language' => $lang_arr->name ?? null,
                        'subtitle_file' => $filename,
                        'is_default' => $isDefault ? 1 : 0,
                        'type' => 'movie',
                    ]);
                }
            }

            if ($file == null && $existingSubtitle) {
                $existingSubtitle->update([
                    'is_default' => $isDefault ? 1 : 0,
                    'language' => $lang_arr->name ?? null,
                ]);
            }
        }
    }

    // Update the data in the database
    $data = $this->entertainmentService->update($id, $request_data);

    // Clear cache and return success message
    Cache::flush();
    $type = $entertainment->type;
    $message = trans('messages.update_form_movie', ['Form' => ucfirst($type)]);

    if ($type == 'movie') {
        return redirect()->route('backend.movies.index')->with('success', $message);
    } else {
        return redirect()->route('backend.tvshows.index')->with('success', $message);
    }
}





    public function destroy($id)
    {
       $entertainment = $this->entertainmentService->getById($id);
       $type=$entertainment->type;
       $entertainment->delete();
       $message = trans('messages.delete_form_movie', ['form' => $type]);
       Cache::flush();
       return response()->json(['message' => $message, 'status' => true], 200);
    }

    public function restore($id)
    {
        $entertainment = $this->entertainmentService->getById($id);
        $type=$entertainment->type;
        $entertainment->restore();
        $message = trans('messages.restore_form_movie', ['form' =>$type]);
        Cache::flush();
        return response()->json(['message' => $message, 'status' => true], 200);

    }

    public function forceDelete($id)
    {
        $entertainment = $this->entertainmentService->getById($id);
        $type=$entertainment->type;
        $entertainment->forceDelete();
        $message = trans('messages.permanent_delete_form_movie', ['form' =>$type]);
        Cache::flush();
        return response()->json(['message' => $message, 'status' => true], 200);
    }

    public function downloadOption(Request $request, $id){

        $data = Entertainment::where('id',$id)->with('entertainmentDownloadMappings')->first();

        $module_title =__('messages.download_movie');

        $upload_url_type=Constant::where('type','upload_type')
                            ->whereIn('name', ['URL', 'Local'])
                            ->get();
        $video_quality=Constant::where('type','video_quality')->get();
        Cache::flush();

        return view('entertainment::backend.entertainment.download', compact('data','module_title','upload_url_type','video_quality'));

    }


   public function storeDownloads(Request $request, $id)
    {
        $data = $request->all();
        $this->entertainmentService->storeDownloads($data, $id);
        $message = trans('messages.set_download_url');
        Cache::flush();

        return redirect()->route('backend.movies.index')->with('success', $message);
    }


    public function details($id)
    {
        $data = Entertainment::with([
            'entertainmentGenerMappings',
            'entertainmentStreamContentMappings',
            'entertainmentTalentMappings',
            'entertainmentReviews',
            'season',

        ])->findOrFail($id);


       foreach ($data->entertainmentTalentMappings as $talentMapping) {
    $talentProfile = $talentMapping->talentprofile;

    if ($talentProfile) {
        if (in_array($talentProfile->type, ['actor', 'director'])) {
            $talentProfile->file_url =  setBaseUrlWithFileName($talentProfile->file_url);
        }
    }
}
        $data->poster_url =setBaseUrlWithFileName($data->poster_url);

        $data->formatted_release_date = Carbon::parse($data->release_date)->format('d M, Y');
        if($data->type == "movie"){
            $module_title = __('movie.title');
            $show_name = $data->name;
            $route = 'backend.movies.index';
        }else{
            $module_title = __('tvshow.title');
            $show_name = $data->name;
            $route = 'backend.tvshows.index';
        }

        return view('entertainment::backend.entertainment.details', compact('data','module_title','show_name','route'));
    }



}
