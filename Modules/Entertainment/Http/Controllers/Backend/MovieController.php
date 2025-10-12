<?php

namespace Modules\Entertainment\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Trait\ModuleTrait;
use Yajra\DataTables\DataTables;
use Modules\Constant\Models\Constant;
use Modules\Subscriptions\Models\Plan;
use Modules\Genres\Models\Genres;
use Modules\CastCrew\Models\CastCrew;
use Modules\Entertainment\Trait\ImportMovieTrait;
use Modules\Entertainment\Services\EntertainmentService;
use Modules\Entertainment\Services\MovieService;
use App\Services\ChatGTPService;
use Modules\World\Models\Country;

class MovieController extends Controller
{
     use ImportMovieTrait;
    protected string $exportClass = '\App\Exports\MoiveExport';

    use ModuleTrait {
        initializeModuleTrait as private traitInitializeModuleTrait;
        }


        protected $entertainmentService;
        protected $movieService;
        protected $chatGTPService;

        public function __construct(ChatGTPService $chatGTPService, EntertainmentService $entertainmentService, MovieService $movieService)

        {
            $this->entertainmentService = $entertainmentService;
            $this->movieService= $movieService;
            $this->chatGTPService=$chatGTPService;

            $this->traitInitializeModuleTrait(
                'movie.title',
                'movies',
                'fa-solid fa-clipboard-list'
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
                'text' => __('movie.movie') . ' ' . __('movie.lbl_movie_access'),
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
        $export_url = route('backend.movies.export');

        $geners=Genres::where('status',1)->get();
        $plan=Plan::where('status',1)->get();

        $movie_language=Constant::where('type','movie_language')->get();

        return view('entertainment::backend.movie.index', compact('module_action', 'filter', 'export_import', 'export_columns', 'export_url','geners','movie_language','plan'));

    }

    public function index_data(Datatables $datatable, Request $request)
    {
        $filter = $request->filter;
        $type='movie';
        return $this->entertainmentService->getDataTable($datatable, $filter, $type);
    }

    /**
     * Show the form for creating a new resource.
     */

        public function create()
        {

            $constants = Constant::whereIn('type', ['upload_type', 'movie_language', 'video_quality','subtitle_language'])->get()->groupBy('type');

            $upload_url_type = $constants->get('upload_type', collect());
            $movie_language = $constants->get('movie_language', collect());
            $video_quality = $constants->get('video_quality', collect());
            $subtitle_language = $constants->get('subtitle_language', collect());

            $plan = Plan::where('status', 1)->get();
            $genres = Genres::where('status', 1)->get();

            $numberOptions = collect(range(1, 10))->mapWithKeys(function ($number) {
                return [$number => $number];
            });

            $cast_crew = CastCrew::whereIn('type', ['actor', 'director'])->get()->groupBy('type');

            $actors = $cast_crew->get('actor', collect());
            $directors = $cast_crew->get('director', collect());
            $countries = Country::where('status', 1)->get();

            $type = 'movie';
            $module_title = __('movie.add_title');
            $mediaUrls = getMediaUrls();
            $assets = ['textarea'];
            return view('entertainment::backend.entertainment.create', compact('assets',
                'upload_url_type', 'plan', 'movie_language','subtitle_language','genres', 'numberOptions', 'actors', 'directors','countries', 'video_quality', 'type', 'module_title', 'mediaUrls'
            ));
         }

         public function generateDescription(Request $request)
         {
             $name = $request->input('name');
             $description = $request->input('description');

             $result = $this->chatGTPService->GenerateDescription($name, $description);

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




         public function ImportMovie($id)
         {
             $result = $this->movieService->importMovie($id);


             if (isset($result['success']) && $result['success'] === false){
                 return response()->json([
                     'success' => false,
                     'message' => $result['status_message']
                 ], 400);
             }

             return response()->json([
                 'success' => true,
                 'data' => $result
             ], 200);
         }

}


