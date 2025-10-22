<?php

namespace Modules\Frontend\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Entertainment\Models\ContinueWatch;
use Modules\Entertainment\Models\Entertainment;
use Modules\Entertainment\Transformers\MovieDetailResource;
use Modules\Entertainment\Models\Watchlist;
use Modules\Entertainment\Models\Like;
use Illuminate\Support\Facades\Cache;
use Modules\Entertainment\Models\EntertainmentDownload;
// use Modules\MobileSettings\Models\MobileSetting;
use Modules\LiveTV\Models\LiveTvCategory;
use Modules\LiveTV\Models\LiveTvChannel;
use Modules\LiveTV\Transformers\LiveTvCategoryResource;
use Modules\LiveTV\Transformers\LiveTvChannelResource;
use Modules\Entertainment\Transformers\ComingSoonResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Modules\Subscriptions\Models\Subscription;
use Modules\Genres\Models\Genres;
use Modules\Entertainment\Models\EntertainmentGenerMapping;
use Modules\Entertainment\Transformers\MoviesResource;
use App\Models\MobileSetting;
use Modules\CastCrew\Models\CastCrew;
use Modules\Banner\Transformers\SliderResource;
use App\Services\RecommendationService;
use Modules\Banner\Models\Banner;
use App\Models\UserSearchHistory;
use Modules\Entertainment\Models\Subtitle as ModelsSubtitle;
use Modules\Entertainment\Models\Subtitle;
use Modules\SEO\Models\Seo;
class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     protected $recommendationService;


     public function __construct(RecommendationService $recommendationService)
     {
         $this->recommendationService = $recommendationService;

     }

    public function movieList(Request $request,$language=null)
    {
        $access_type = $request->type;
        $user_id = auth()->id();
        $user = Auth::user();

        $featured_movies = Banner::where('banner_for', 'movie')
            ->where('status', 1)
            ->limit(5)
            ->get();
        $featured_movie = SliderResource::collection($featured_movies);
        $featured_movies =  $featured_movie->toArray(request());

        $popular_movies = Cache::remember('popular_movie', 3600, function() {
            $popularMovieIds = MobileSetting::getValueBySlug('popular-movies');
            if($popularMovieIds != null) {
                return Entertainment::whereIn('id', json_decode($popularMovieIds))
                    ->where('status', 1)
                    ->get();
            }
            return collect([]);
        });


        $popular_movies = MoviesResource::collection($popular_movies);


        $watched_movies = collect([]);
        if (auth()->id()) {
            $userId = auth()->id();
            $recentlyWatched = ContinueWatch::where('user_id', $userId)
                ->where('entertainment_type', 'movie')
                ->orderBy('updated_at', 'desc')
                ->first();
            if ($recentlyWatched && $recentlyWatched->entertainment_id) {
                $movie = Entertainment::where('id', $recentlyWatched->entertainment_id)
                    ->with('entertainmentGenerMappings')
                    ->first();
                $genres = optional($movie)->entertainmentGenerMappings;
                $genre_ids = optional($genres)->pluck('genre_id')->toArray();

                $entertainment_ids = EntertainmentGenerMapping::whereIn('genre_id', $genre_ids)
                    ->pluck('entertainment_id')
                    ->toArray();
                $more_items = Entertainment::whereIn('id', $entertainment_ids)
                    ->where('type', 'movie')
                    ->where('status', 1)
                    ->limit(7)
                    ->get();

                $watched_movies = MoviesResource::collection($more_items);
            }
        }

        $personalities = Cache::remember('personality', 3600, function() {
            $castIds = MobileSetting::getValueBySlug('your-favorite-personality');
            if($castIds != null) {
                $casts = CastCrew::whereIn('id', json_decode($castIds))->get();
                return $casts->map(function($value) {
                    return [
                        'id' => $value->id,
                        'name' => $value->name,
                        'type' => $value->type,
                        'profile_image' => setBaseUrlWithFileName($value->file_url),
                    ];
                });
            }
            return collect([]);
        });


        $movies = Entertainment::where('type', 'movie')
            ->when($language, function($query) use ($language) {
                return $query->where('language', $language);
            })
            ->where('status', 1)
            ->get();


            $user=Auth::user();


            $html='';
            $trending_movies = collect([]);
            if ($user) {
                $trendingData = $this->recommendationService->getTrendingMoviesByCountry($user);
                if ($trendingData) {
                    $trending_movies = MoviesResource::collection($trendingData);
                }
            } else {
                $trending_movies = Entertainment::where('type', 'movie')
                    ->where('status', 1)
                    ->released()
                    ->limit(10)
                    ->get();
                $trending_movies = MoviesResource::collection($trending_movies);
            }


        return view('frontend::movie', compact('movies', 'language', 'popular_movies', 'watched_movies', 'personalities','featured_movies','trending_movies','access_type'));

}

public function moviesListByGenre($genre_id)
{

    $featured_movies = Banner::where('banner_for', 'movie')
        ->where('status', 1)
        ->limit(5)
        ->get();
    $featured_movie = SliderResource::collection($featured_movies);
    $featured_movies =  $featured_movie->toArray(request());

    $movies = Entertainment::whereHas('entertainmentGenerMappings', function ($query) use ($genre_id) {
        $query->where('genre_id', $genre_id);
    })->get();

    $genre = Genres::where('id',$genre_id)->first();
    $access_type = '';
    return view('frontend::movie', compact('movies', 'genre_id','genre','featured_movies','access_type'));
}
    public function livetvList()
    {
        $channelData = LiveTvChannel::with('TvCategory','plan','TvChannelStreamContentMappings')->where('status',1)->orderBy('updated_at', 'desc')->take(6)->get();
        $categoryData = LiveTvCategory::with('tvChannels')->where('status',1)->orderBy('updated_at', 'desc')->get();

        $responseData['slider'] = LiveTvChannelResource::collection($channelData)->toArray(request());
        $responseData['category_data'] = LiveTvCategoryResource::collection($categoryData)->toArray(request());

        return view('frontend::livetv',compact('responseData'));
    }


//     public function movieDetails(Request $request, $id)
//     {
//         $continue_watch=false;
//         if($request->has('continue_watch')){

//             $continue_watch=true;
//         }

//         $movieId = $id;
//         $userId = auth()->id();
//         $cacheKey = 'movie_' . $movieId;

//         $data = Cache::get($cacheKey);

//         if (!$data) {
//             $movie = Entertainment::where('id', $movieId)
//                 ->with([
//                     'entertainmentGenerMappings',
//                     'plan',
//                     'entertainmentReviews.user',
//                     'entertainmentTalentMappings',
//                     'entertainmentStreamContentMappings',
//                     'entertainmentDownloadMappings',
//                     'subtitles',
//                     'entertainmentSubtitleMappings'
//                 ])
//                 ->first();

//             $reviews = $movie->entertainmentReviews ?? collect();

//             // Encrypt the trailer URL
//             if (!empty($movie->trailer_url) && $movie->trailer_url_type != 'Local') {
//                 $movie['trailer_url'] = Crypt::encryptString($movie->trailer_url);
//             }

//             if (!empty($movie->video_url_input) && $movie->video_upload_type != 'Local') {
//                 $movie['video_url_input'] = Crypt::encryptString($movie->video_url_input);
//             }

//             if ($userId) {
//                 $movie['is_watch_list'] = WatchList::where('entertainment_id', $movieId)
//                     ->where('user_id', $userId)
//                     ->exists();

//                 $movie['subtitle_enable'] = Subtitle::where('entertainment_id', $movieId)->where('type', 'movie')->exists();

//                 $movie['is_likes'] = Like::where('entertainment_id', $movieId)
//                     ->where('user_id', $userId)
//                     ->where('is_like', 1)
//                     ->exists();

//                 $movie['is_download'] = EntertainmentDownload::where('entertainment_id', $movieId)
//                     ->where('user_id', $userId)
//                     ->where('entertainment_type', 'movie')
//                     ->where('is_download', 1)
//                     ->exists();

//                 $yourReview = $reviews->where('user_id', $userId)->first();

//                 $movie['your_review'] = $yourReview;
//                 $movie['reviews'] = $yourReview ? $reviews->where('user_id', '!=', $userId) : $reviews;

//                 $movie['total_review'] = $movie->entertainmentReviews->count();

//                 $continueWatch = ContinueWatch::where('entertainment_id', $movieId)
//                     ->where('user_id', $userId)
//                     ->where('entertainment_type', 'movie')
//                     ->first();

//                 $movie['continue_watch'] = $continueWatch;
//             } else {
//                 $movie['reviews'] = $reviews;
//             }

//             $genres = $movie->entertainmentGenerMappings;

//             $genre_ids = $genres->pluck('genre_id')->toArray();
//             $entertainment_ids = EntertainmentGenerMapping::whereIn('genre_id', $genre_ids)
//                 ->pluck('entertainment_id')
//                 ->toArray();
//             $more_items = Entertainment::whereIn('id', $entertainment_ids)
//                 ->where('type', 'movie')
//                 ->where('status', 1)
//                 ->limit(7)
//                 ->get()
//                 ->except($id);

// // dd($movie);
//             $data = new MovieDetailResource($movie);
//             $data['more_items'] = MoviesResource::collection($more_items);



//             // Cache the base data
//             Cache::put($cacheKey, $data);
//         }

//         // Convert data to array for manipulation
//         $data = $data->toArray($request);

//         // Dynamically append more_items (non-cached)
//         $movie = Entertainment::where('id', $movieId)
//             ->with('entertainmentGenerMappings')
//             ->first();

//         $genres = $movie->entertainmentGenerMappings;
//         $genre_ids = $genres->pluck('genre_id')->toArray();
//         $entertainment_ids = EntertainmentGenerMapping::whereIn('genre_id', $genre_ids)
//             ->pluck('entertainment_id')
//             ->toArray();
//         $more_items = Entertainment::whereIn('id', $entertainment_ids)
//             ->where('type', 'movie')
//             ->where('status', 1)
//             ->limit(7)
//             ->get()
//             ->except($id);


//         $data['more_items'] = MoviesResource::collection($more_items);

//         if ($request->has('is_search') && $request->is_search == 1) {
//             $user_id = auth()->user()->id ?? $request->user_id;

//             if ($user_id) {
//                 $currentProfile = GetCurrentProfile($user_id, $request);

//                 if ($currentProfile) {
//                     $existingSearch = UserSearchHistory::where('user_id', $user_id)
//                         ->where('profile_id', $currentProfile)
//                         ->where('search_query', $data['name'])
//                         ->first();

//                     if (!$existingSearch) {
//                         UserSearchHistory::create([
//                             'user_id' => $user_id,
//                             'profile_id' => $currentProfile,
//                             'search_query' => $data['name'],
//                             'search_id' => $data['id'],
//                             'type' => $data['type']
//                         ]);
//                     }
//                 }
//             }
//         }

//         $entertainment = Entertainment::findOrFail($id);

//         return view('frontend::movieDetail', compact('data', 'continue_watch', 'entertainment'));
//     }



    public function movieDetails(Request $request, $slug)
    {
        $continue_watch = $request->has('continue_watch');
        $userId = auth()->id();

        // Fetch movie by slug with relations
        $movie = Entertainment::where('slug', $slug)
            ->with([
                'entertainmentGenerMappings',
                'plan',
                'entertainmentReviews.user',
                'entertainmentTalentMappings',
                'entertainmentStreamContentMappings',
                'entertainmentDownloadMappings',
                'subtitles',
                'entertainmentSubtitleMappings'
            ])
            ->firstOrFail();

        $movieId = $movie->id;
        $cacheKey = 'movie_' . $movieId;

        // Get from cache or build Resource
        $data = Cache::remember($cacheKey, 3600, function () use ($movie, $userId) {

            // Encrypt URLs if not local
            if (!empty($movie->trailer_url) && $movie->trailer_url_type != 'Local') {
                $movie->trailer_url = Crypt::encryptString($movie->trailer_url);
            }

            if (!empty($movie->video_url_input) && $movie->video_upload_type != 'Local') {
                $movie->video_url_input = Crypt::encryptString($movie->video_url_input);
            }

            // Set dynamic attributes for authenticated users
            if ($userId) {
                $movie->is_watch_list = WatchList::where('entertainment_id', $movie->id)
                    ->where('user_id', $userId)
                    ->exists();

                $movie->subtitle_enable = Subtitle::where('entertainment_id', $movie->id)
                    ->where('type', 'movie')
                    ->exists();

                $movie->is_likes = Like::where('entertainment_id', $movie->id)
                    ->where('user_id', $userId)
                    ->where('is_like', 1)
                    ->exists();

                $movie->is_download = EntertainmentDownload::where('entertainment_id', $movie->id)
                    ->where('user_id', $userId)
                    ->where('entertainment_type', 'movie')
                    ->where('is_download', 1)
                    ->exists();

                $movie->your_review = $movie->entertainmentReviews
                    ->where('user_id', $userId)
                    ->first();

                $movie->total_review = $movie->entertainmentReviews->count();

                $movie->continue_watch = ContinueWatch::where('entertainment_id', $movie->id)
                    ->where('user_id', $userId)
                    ->where('entertainment_type', 'movie')
                    ->first();
            }

            return new MovieDetailResource($movie);
        });

        // Append more items dynamically (non-cached)
        $genres = $movie->entertainmentGenerMappings;
        $genre_ids = $genres->pluck('genre_id')->toArray();
        $entertainment_ids = EntertainmentGenerMapping::whereIn('genre_id', $genre_ids)
            ->pluck('entertainment_id')
            ->toArray();

        $more_items = Entertainment::whereIn('id', $entertainment_ids)
            ->where('type', 'movie')
            ->where('status', 1)
            ->limit(7)
            ->get()
            ->except($movieId);

        $dataArray = $data->toArray($request);
        $dataArray['more_items'] = MoviesResource::collection($more_items);

        // Handle search history if requested
        if ($request->has('is_search') && $request->is_search == 1) {
            $user_id = auth()->user()->id ?? $request->user_id;

            if ($user_id) {
                $currentProfile = GetCurrentProfile($user_id, $request);

                if ($currentProfile) {
                    $existingSearch = UserSearchHistory::where('user_id', $user_id)
                        ->where('profile_id', $currentProfile)
                        ->where('search_query', $dataArray['name'])
                        ->first();

                    if (!$existingSearch) {
                        UserSearchHistory::create([
                            'user_id' => $user_id,
                            'profile_id' => $currentProfile,
                            'search_query' => $dataArray['name'],
                            'search_id' => $dataArray['id'],
                            'type' => $dataArray['type']
                        ]);
                    }
                }
            }
        }

        return view('frontend::movieDetail', [
            'data' => $dataArray,
            'continue_watch' => $continue_watch,
            'entertainment' => $movie
        ]);
    }

    public function liveTvDetails($id)
    {
        $livetvId = $id;
        $userId = auth()->id();

            $livetv = LiveTvChannel::where('id',$livetvId)->with('TvCategory','plan','TvChannelStreamContentMappings')->  first();
            $suggestions = LiveTvChannel::where('category_id', $livetv->category_id)
            ->where('id', '!=', $livetvId) // Exclude the current channel
            ->with('TvCategory') // Eager load the category
            ->get();

            $suggestions = LiveTvChannelResource::collection($suggestions)->toArray(request());

            if (!$livetv) {
                return abort(404, 'TV show not found.');
            }


          $data = new LiveTvChannelResource($livetv);


        $data=$data->toArray(request());

        // Encrypt the trailer URL
        if (!empty($livetv->TvChannelStreamContentMappings['server_url'])) {
            $data['server_url'] = Crypt::encryptString($livetv->TvChannelStreamContentMappings['server_url']);
        }

        // Get suggestions based on TV category
        $entertainment = LiveTvChannel::findOrFail($id);


        return view('frontend::livetvDetail', compact('data', 'suggestions','entertainment'));
    }

    public function livetvChannelsList(Request $request, $id)
    {
        $tvcategory_id = $id;
        $data = LiveTvChannel::where('category_id', $tvcategory_id)->where('status',1)->get();

        $data = LiveTvChannelResource::collection($data)->toArray(request());

        return view('frontend::tvchannelList', compact('data'));
    }


    public function comingSoonList()
    {

        $todayDate = Carbon::today()->toDateString(); // 'Y-m-d'

        // Query the database to get entertainment items with release_date greater than today
        $entertainmentList = Entertainment::whereDate('release_date', '>', $todayDate)->with([
            // 'UserReminder' => function ($query) use ($request) {
            //     $query->where('user_id', $request->user_id);
            // },
            'entertainmentGenerMappings',
            'plan',
            'entertainmentReviews',
            'entertainmentTalentMappings',
            'entertainmentStreamContentMappings',
            'season'

        ])->when(Auth::check(), function ($query) {
            $query->with(['UserRemind' => function ($query) {
                $query->where('user_id', Auth::id());
            }]);
        })->get();

        $data = ComingSoonResource::collection($entertainmentList);


        return view('frontend::comingsoon',compact('data'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('frontend::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('frontend::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('frontend::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
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
}
