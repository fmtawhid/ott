<?php

namespace Modules\Entertainment\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Trait\ModuleTrait;
use Modules\Entertainment\Models\Entertainment;
use Yajra\DataTables\DataTables;
use Modules\Constant\Models\Constant;
use Modules\Subscriptions\Models\Plan;
use Modules\Genres\Models\Genres;
use Modules\CastCrew\Models\CastCrew;
use Modules\Entertainment\Trait\ImportMovieTrait;
use Modules\Entertainment\Repositories\EntertainmentRepositoryInterface;
use  Modules\Genres\Repositories\GenreRepositoryInterface;
use Modules\Entertainment\Services\TvShowService;
use Modules\World\Models\Country;
use Illuminate\Support\Facades\Cache;

class TVshowController extends Controller
{
     protected string $exportClass = '\App\Exports\TVshowExport';
     use ImportMovieTrait;
     protected $tvShowService;

    use ModuleTrait {
        initializeModuleTrait as private traitInitializeModuleTrait;
        }

    public function __construct(TvShowService $tvShowService)
    {
        $this->tvShowService = $tvShowService;

        $this->traitInitializeModuleTrait(
            'tvshow.title', // module title
            'tvshows', // module name
            'fa-solid fa-clipboard-list' // module icon
        );
    }


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
                'value' => 'movie_access',
                'text' => __('movie.lbl_tv_show') . ' ' . __('movie.lbl_movie_access'),
            ],
            [
                'value' => 'like_count',
                'text' => __('movie.likes'),
            ],
            [
                'value' => 'watch_count',
                'text' => __('movie.watch'),
            ],

            [
                'value' => 'language',
                'text' => __('movie.lbl_movie_language'),
            ],

            [
                'value' => 'IMDb_rating',
                'text' => __('movie.lbl_imdb_rating'),
            ],

            [
                'value' => 'content_rating',
                'text' => __('movie.lbl_content_rating'),
            ],

            [
                'value' => 'duration',
                'text' => __('movie.lbl_duration'),
            ],

            [
                'value' => 'release_date',
                'text' => __('movie.lbl_release_date'),
            ],


            [
                'value' => 'is_restricted',
                'text' => __('movie.lbl_age_restricted'),
            ],

            [
                'value' => 'status',
                'text' => __('plan.lbl_status'),
            ]

        ];
        $export_url = route('backend.tvshows.export');

        $geners=Genres::where('status',1)->get();
        $plan=Plan::where('status',1)->get();

        $movie_language=Constant::where('type','movie_language')->get();

        return view('entertainment::backend.tvshows.index', compact('module_action', 'filter', 'export_import', 'export_columns', 'export_url','geners','plan','movie_language'));

    }

    public function bulk_action(Request $request)
    {
        $ids = explode(',', $request->rowIds);
        $actionType = $request->action_type;
        $moduleName = 'TV Shows'; // Adjust as necessary for dynamic use
        Cache::flush();

        return $this->performBulkAction(Entertainment::class, $ids, $actionType, $moduleName);
    }
    public function index_data(Datatables $datatable, Request $request)
    {
        $filter = $request->filter;
        $type='tvshow';
        return $this->tvShowService->getDataTable($datatable, $filter, $type);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
      {
        $upload_url_type=Constant::where('type','upload_type')->get();

        $assets = ['textarea'];

        $plan=Plan::where('status',1)->get();

        $movie_language=Constant::where('type','movie_language')->get();

        $genres=Genres::where('status',1)->get();

        $numberOptions = collect(range(1, 10))->mapWithKeys(function ($number) {
            return [$number => $number];
        });

        $video_quality=Constant::where('type','video_quality')->get();

        $actors=CastCrew::where('type','actor')->get();
        $directors=CastCrew::where('type','director')->get();
        $countries = Country::where('status', 1)->get();

        $type='tvshow';

        $module_title = __('tvshow.add_title');

        $mediaUrls =  getMediaUrls();


        return view('entertainment::backend.tvshows.create', compact('upload_url_type','assets','plan','movie_language','genres','numberOptions','actors','directors','countries','video_quality','type','module_title','mediaUrls'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('entertainment::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Entertainment::where('id',$id)->with('entertainmentGenerMappings','entertainmentTalentMappings')->first();
        $tmdb_id = $data->tmdb_id;
        $data->thumbnail_url = setBaseUrlWithFileName($data->thumbnail_url);
        $data->poster_url =  setBaseUrlWithFileName($data->poster_url);
        $data->poster_tv_url =  setBaseUrlWithFileName($data->poster_tv_url);
        $data['genres_data'] = $data->entertainmentGenerMappings->isEmpty() ? [] : $data->entertainmentGenerMappings->pluck('genre_id')->toArray();
        $data['countries'] = $data->entertainmentCountryMappings->isEmpty() ? [] : $data->entertainmentCountryMappings->pluck('country_id')->toArray();
        $data['actors'] = $data->entertainmentTalentMappings->isEmpty() ? [] : $data->entertainmentTalentMappings->pluck('talent_id')->toArray();
        $data['directors'] = $data->entertainmentTalentMappings->isEmpty() ? [] : $data->entertainmentTalentMappings->pluck('talent_id')->toArray();

        $upload_url_type=Constant::where('type','upload_type')->get();

        $seo = (object) [
        'meta_title' => $data->meta_title,
        'meta_keywords' => $data->meta_keywords,
        'meta_description' => $data->meta_description,
        'seo_image' => $data->seo_image,
        'google_site_verification' => $data->google_site_verification,
        'canonical_url' => $data->canonical_url,
        'short_description' => $data->short_description
    ];


        if($data->trailer_url_type =='Local'){

            $data->trailer_url = setBaseUrlWithFileName($data->trailer_url);
        }


        $plan=Plan::where('status',1)->get();

        $assets = ['textarea'];


        $movie_language=Constant::where('type','movie_language')->get();

        $genres=Genres::where('status',1)->get();

        $numberOptions = collect(range(1, 10))->mapWithKeys(function ($number) {
            return [$number => $number];
        });

        $actors=CastCrew::where('type','actor')->get();
        $directors=CastCrew::where('type','director')->get();
        $countries = Country::where('status', 1)->get();
        $module_title = __('tvshow.edit_title');

        $mediaUrls =  getMediaUrls();

        return view('entertainment::backend.tvshows.edit', compact('data','tmdb_id','assets','upload_url_type','plan','movie_language','genres','countries','numberOptions','actors','directors','mediaUrls','module_title','seo'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

    public function ImportTVshow($id)
    {


        $tv_show_id = $id;
        $tvshow_details = null;

        $tvshow=Entertainment::where('tmdb_id',  $tv_show_id)->where('type','tvshow')->first();

        if(!empty($tvshow)){

            $message = __('tvshow.already_added_tvshow');

            return response()->json([
                'success' => false,
                'message' => $message,
            ], 400);

        }


        $configuration =$this->getConfiguration();

        $configurationData = json_decode($configuration, true);

        while ($configurationData === null) {

            $configuration =$this->getConfiguration();

            $configurationData = json_decode($configuration, true);
        }

        if(isset($configurationData['success']) && $configurationData['success'] === false) {
            return response()->json([
                'success' => false,
                'message' => $configurationData['status_message']
            ], 400);
        }

        $tvshow_details = $this->getTVShowDetails($tv_show_id);
        $TVshowDetail = json_decode($tvshow_details, true);

        while ($TVshowDetail === null) {

            $tvshow_details = $this->getTVShowDetails($tv_show_id);
            $TVshowDetail = json_decode($tvshow_details, true);
        }

        if (isset($TVshowDetail['success']) && $TVshowDetail['success'] === false) {
            return response()->json([
                'success' => false,
                'message' => $TVshowDetail['status_message']
            ], 400);
        }


        $tvshow_videos = $this->getTVShowVideos($tv_show_id);
        $TVshowVideos = json_decode($tvshow_videos, true);

        while ($TVshowVideos === null) {

            $tvshow_videos = $this->getTVShowVideos($tv_show_id);
            $TVshowVideos = json_decode($tvshow_videos, true);
        }

        if (isset($TVshowVideos['success']) && $TVshowVideos['success'] === false) {
            return response()->json([
                'success' => false,
                'message' => $TVshowVideos['status_message']
            ], 400);
        }

        $trailer_url_type=null;
        $trailer_url=null;

        if(isset($TVshowVideos['results']) && is_array($TVshowVideos['results'])) {

            foreach ($TVshowVideos['results'] as $video) {

                if($video['type'] == 'Trailer'){

                    $trailer_url_type= $video['site'];
                    $trailer_url='https://www.youtube.com/watch?v='.$video['key'];

                }
            }
        }


        $language = null;


        if (isset($TVshowDetail['spoken_languages']) && is_array($TVshowDetail['spoken_languages'])) {
            $spoken_languages = $TVshowDetail['spoken_languages'];

            if (!empty($spoken_languages)) {
                $first_language = $spoken_languages[0];
                $language = $first_language['name'];

                $language_data = [
                    'name' => $language,
                    'value' => strtolower($language),
                    'type' => 'movie_language',
                    'status' => 1,
                ];

                Constant::updateOrCreate(
                    ['name' => $language_data['name'], 'type' => $language_data['type']],
                    $language_data
                );
            }
        }

       $all_language= Constant::where('type','movie_language')->where('status',1)->get();

        $genersIds = [];

        if(isset($TVshowDetail['genres']) && is_array($TVshowDetail['genres'])) {
            foreach ($TVshowDetail['genres'] as $genre) {
                $genre_data = [
                    'name' => $genre['name'],
                    'status' => 1,
                ];

                $genreRecord = Genres::updateOrCreate(
                    ['name' => $genre_data['name']],
                    $genre_data
                );

                $genersIds[] = $genreRecord->id;
            }

        }

        $all_genres=Genres::where('status',1)->get();


        function formatDuration($minutes) {
            $hours = floor($minutes / 60);
            $minutes = $minutes % 60;
            return sprintf('%02d:%02d', $hours, $minutes);
        }


        $castcrew = $this->getTvCastCrew($tv_show_id);

        $castcrewDetail = json_decode($castcrew, true);


        while($castcrewDetail === null) {

            $castcrew = $this->getTvCastCrew($tv_show_id);
            $castcrewDetail = json_decode($castcrew, true);
        }


        if ($castcrewDetail === null) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to decode cast/crew JSON.'
            ], 400);
        }

        $actors = [];
        $directors = [];
        $actorCount = 0;
        $directorCount = 0;
        $maxCount = 5;
        $all_actors=[];
        $all_directors=[];



       foreach ($castcrewDetail['crew'] as $crew) {
         if (($directorCount >= $maxCount)) {
             break;

           }


        if (isset($castcrewDetail['cast']) && is_array($castcrewDetail['cast'])) {
            foreach ($castcrewDetail['cast'] as $cast) {
                if (($actorCount >= $maxCount)) {
                    break;
                }

                if ($cast['known_for_department'] == 'Acting') {

                    $cast_details = $this->getCrewDetials($cast['id']);
                    $castDetails = json_decode($cast_details, true);

                    while($castcrewDetail === null) {

                        $cast_details = $this->getCrewDetials($cast['id']);
                        $castDetails = json_decode($cast_details, true);
                    }


                    if (!empty($castDetails)) {

                        $cast_data = [
                            'name' => $castDetails['name'],
                            'type' => 'actor',
                            'tmdb_id'=> $tv_show_id,
                            'file_url' => $configurationData['images']['secure_base_url'] . 'original' . $castDetails['profile_path'],
                            'bio' => $castDetails['biography'],
                            'place_of_birth' => $castDetails['place_of_birth'],
                            'dob' => $castDetails['birthday'],
                            'designation' => null,
                        ];

                            $castRecord = CastCrew::updateOrCreate(
                                ['name' => $cast_data['name'], 'dob' => $cast_data['dob'] ],
                                $cast_data
                            );
                            if ($actorCount < $maxCount) {
                                $actors[] = $castRecord->id;
                                $actorCount++;


                            }
                        }
                    }
                }
            }


        if (isset($castcrewDetail['crew']) && is_array($castcrewDetail['crew'])) {
              if ($crew['known_for_department'] == 'Directing') {
                    $crew_details = $this->getCrewDetials($crew['id']);
                    $crewDetails = json_decode($crew_details, true);

                    if (!empty($crewDetails)) {

                        $crew_data = [
                            'name' => $crewDetails['name'],
                            'type' => 'director',
                            'tmdb_id'=> $tv_show_id,
                            'file_url' => $configurationData['images']['secure_base_url'] . 'original' . $crewDetails['profile_path'],
                            'bio' => $crewDetails['biography'],
                            'place_of_birth' => $crewDetails['place_of_birth'],
                            'dob' => $crewDetails['birthday'],
                            'designation' => null,
                        ];

                            $crewRecord = CastCrew::updateOrCreate(
                                ['name' => $crew_data['name'], 'dob' => $crew_data['dob']],
                                $crew_data
                            );

                            if ($directorCount < $maxCount) {
                                $directors[] = $crewRecord->id;
                                $directorCount++;

                            }
                        }
                    }
                }
            }

           $all_directors=CastCrew::where('type', 'director')->get();

           $all_actors=CastCrew::where('type', 'actor')->get();


        $data = [
            'id'=>  $tv_show_id,
            'poster_url' => $configurationData['images']['secure_base_url'] . 'original' . $TVshowDetail['poster_path'],
            'thumbnail_url' => $configurationData['images']['secure_base_url'] . 'original' . $TVshowDetail['backdrop_path'],
            'name' => $TVshowDetail['original_name'],
            'description' => $TVshowDetail['overview'],
            'trailer_url_type'=>$trailer_url_type,
            'trailer_url'=>$trailer_url,
            'language' => $language,
            'genres' => $genersIds,
            'is_restricted' => $TVshowDetail['adult'],
            'release_date' => $TVshowDetail['first_air_date'],
            'actors' => $actors,
            'directors' => $directors,
            'movie_access'=>'free',
            'all_actors'=>$all_actors,
            'all_directors'=>$all_directors,
            'all_language'=>$all_language,
            'all_genres'=>$all_genres,

        ];


         return response()->json([
                'success' => true,
                'data' => $data,
            ], 200);
        }




}
