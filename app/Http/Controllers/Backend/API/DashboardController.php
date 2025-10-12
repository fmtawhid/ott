<?php

namespace App\Http\Controllers\Backend\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\MobileSetting;
use Modules\Entertainment\Models\Entertainment;
use Modules\Banner\Models\Banner;
use Modules\Entertainment\Models\ContinueWatch;
use Modules\Banner\Transformers\SliderResource;
use Modules\Entertainment\Transformers\ContinueWatchResource;
use Modules\LiveTV\Models\LiveTvChannel;
use Modules\LiveTV\Transformers\LiveTvChannelResource;
use Modules\CastCrew\Models\CastCrew;
use Modules\CastCrew\Transformers\CastCrewListResource;
use Modules\Genres\Transformers\GenresResource;
use Modules\Genres\Models\Genres;
use Modules\Video\Models\Video;
use App\Services\RecommendationService;
use App\Services\RecommendationServiceV2;
use Modules\Entertainment\Transformers\MoviesResource;
use Modules\Entertainment\Transformers\CommanResource;
use Modules\Entertainment\Transformers\TvshowResource;
use Modules\Constant\Models\Constant;
use Modules\Video\Transformers\VideoResource;
use Carbon\Carbon;
use function PHPSTORM_META\type;
use Illuminate\Support\Facades\Cache;
use Modules\Banner\Transformers\SliderResourceV2;
use Modules\Entertainment\Transformers\ContinueWatchResourceV2;
use Modules\Entertainment\Transformers\SeasonResource;
use Modules\Entertainment\Transformers\EpisodeResource;
use Modules\Episode\Models\Episode;
use Modules\Season\Models\Season;


class DashboardController extends Controller
{
    protected $recommendationService,$recommendationServiceV2;
    public function __construct(RecommendationService $recommendationService, RecommendationServiceV2 $recommendationServiceV2)
    {
        $this->recommendationService = $recommendationService;
        $this->recommendationServiceV2 = $recommendationServiceV2;

    }
    public function DashboardDetail(Request $request){

        $user_id = !empty($request->user_id) ? $request->user_id : null;
        $continueWatch = [];


        if($request->has('user_id')){
            $continueWatchList = ContinueWatch::where('user_id', $user_id)
            ->where('profile_id',$request->profile_id)->get();
            $continueWatch = ContinueWatchResource::collection($continueWatchList);
        }

        $isBanner = MobileSetting::getValueBySlug('banner');
        $sliderList = $isBanner
            ? Banner::where('banner_for','home')->where('status', 1)->get()
            : collect();

        $sliders = SliderResource::collection(
            $sliderList->map(fn($slider) => new SliderResource($slider, $user_id))
        );


        $topMovieIds = MobileSetting::getValueBySlug('top-10');

        if (!empty($topMovieIds)) {
            $topMovies = Entertainment::whereIn('id', json_decode($topMovieIds, true))
                ->with('entertainmentGenerMappings')
                ->where('status', 1)
                ->released();

            if (isset($request->is_restricted)) {
                $topMovies = $topMovies->where('is_restricted', $request->is_restricted);
            }

            if (!empty(getCurrentProfileSession('is_child_profile')) && getCurrentProfileSession('is_child_profile') != 0) {
                $topMovies = $topMovies->where('is_restricted', 0);
            }

            $topMovies = $topMovies->get();
        } else {
            $topMovies = collect();
        }
        $top_10 = CommanResource::collection($topMovies)->toArray(request());


       $responseData = [
           'slider' => $sliders,
           'continue_watch' => $continueWatch,
           'top_10' => $top_10
       ];

       // Cache::put($cacheKey,$responseData);

       return response()->json([
           'status' => true,
           'data' => $responseData,
           'message' => __('messages.dashboard_detail'),
       ], 200);
    }

public function DashboardDetailData(Request $request){

    $user_id = !empty($request->user_id) ? $request->user_id : null;

         if($request->has('user_id')){
           $continueWatchList = ContinueWatch::where('user_id', $user_id)
           ->where('profile_id',$request->profile_id)->get();
           $continueWatch = ContinueWatchResource::collection($continueWatchList);

           $user = User::where('id',$request->user_id)->first();
           $profile_id=$request->profile_id;

           if( $user_id !=null){
               $user = User::where('id',$user_id)->first();

                $likedMovies = $this->recommendationService->getLikedMovies($user, $profile_id);
                $likedMovies = CommanResource::collection($likedMovies);
                $viewedMovies = $this->recommendationService->getEntertainmentViews($user, $profile_id);
                $viewedMovies = CommanResource::collection($viewedMovies);

                $favorite_gener = $this->recommendationService->getFavoriteGener($user, $profile_id);
                $FavoriteGener = GenresResource::collection($favorite_gener);
                $FavoriteGener = $FavoriteGener->toArray(request());

                $favorite_personality = $this->recommendationService->getFavoritePersonality($user, $profile_id);
                $favorite_personality = CastCrewListResource::collection($favorite_personality);
                $favorite_personality = $favorite_personality->toArray(request());

                $trendingMovies = $this->recommendationService->getTrendingMoviesByCountry($user, $request);
                $trendingMovies = CommanResource::collection($trendingMovies);

           }

       }

       $latestMovieIds = MobileSetting::getValueBySlug('latest-movies');
       $latestMovieIdsArray = json_decode($latestMovieIds, true);

       if(!empty($latestMovieIdsArray))
       {
            $latest_movie = Entertainment::whereIn('id', $latestMovieIdsArray)->with('entertainmentGenerMappings')
                ->where('status', 1);
                isset($request->is_restricted) && $latest_movie = $latest_movie->where('is_restricted', $request->is_restricted);
                (!empty(getCurrentProfileSession('is_child_profile')) && getCurrentProfileSession('is_child_profile') != 0) &&
                $latest_movie = $latest_movie->where('is_restricted',0);
                $latest_movie = $latest_movie->released()
                ->get();

            $latest_movie = CommanResource::collection($latest_movie);

        }else{
            $latest_movie = collect();
        }

       $languageIds = MobileSetting::getValueBySlug('enjoy-in-your-native-tongue');
       $languageIdsArray = json_decode($languageIds, true);
       $popular_language = !empty($languageIdsArray) ? Constant::whereIn('id', $languageIdsArray)->get() : collect();

       $popularMovieIds = MobileSetting::getValueBySlug('popular-movies');
       $popularMovieIdsArray = json_decode($popularMovieIds, true);

       if(!empty($popularMovieIdsArray))
       {
            $popular_movie = Entertainment::whereIn('id', $popularMovieIdsArray)->with('entertainmentGenerMappings')
               ->where('status', 1);
               isset($request->is_restricted) && $popular_movie = $popular_movie->where('is_restricted', $request->is_restricted);
               (!empty(getCurrentProfileSession('is_child_profile')) && getCurrentProfileSession('is_child_profile') != 0) &&
                $popular_movie = $popular_movie->where('is_restricted',0);

               $popular_movie = $popular_movie->released()
               ->get();
            $popular_movie = CommanResource::collection($popular_movie);
        }else{
            $popular_movie = collect();
        }

       $channelIds = MobileSetting::getValueBySlug('top-channels');
       $channelIdsArray = json_decode($channelIds, true);
       $top_channel = !empty($channelIdsArray) ? LiveTvChannelResource::collection(
           LiveTvChannel::whereIn('id', $channelIdsArray)
               ->where('status', 1)
               ->get()
       ) : collect();

       $castIds = MobileSetting::getValueBySlug('your-favorite-personality');
       $castIdsArray = json_decode($castIds, true);
       $personality = [];
       if (!empty($castIdsArray)) {
           $casts = CastCrew::whereIn('id', $castIdsArray)->get();
           foreach ($casts as $value) {
               $personality[] = [
                   'id' => $value->id,
                   'name' => $value->name,
                   'type' => $value->type,
                   'profile_image' => setBaseUrlWithFileName($value->file_url),
               ];
           }
       }

       $movieIds = MobileSetting::getValueBySlug('500-free-movies');
       $movieIdsArray = json_decode($movieIds, true);
       if(!empty($movieIdsArray))
       {
            $free_movie = Entertainment::whereIn('id', $movieIdsArray)->with('entertainmentGenerMappings')
               ->where('status', 1)
               ->whereDate('release_date', '<=', Carbon::now());
               isset($request->is_restricted) && $free_movie = $free_movie->where('is_restricted', $request->is_restricted);
               (!empty(getCurrentProfileSession('is_child_profile')) && getCurrentProfileSession('is_child_profile') != 0) &&
                $free_movie = $free_movie->where('is_restricted',0);
            $free_movie = $free_movie->get();
            $free_movie = CommanResource::collection($free_movie);
        }else{
            $free_movie = collect();
        }

       $popular_tvshowIds = MobileSetting::getValueBySlug('popular-tvshows');
       $popular_tvshowIdsArray = json_decode($popular_tvshowIds, true);

       if(!empty($popular_tvshowIdsArray))
       {
            $popular_tvshow = Entertainment::whereIn('id', $popular_tvshowIdsArray)->with('entertainmentGenerMappings')
               ->where('status', 1);
            isset($request->is_restricted) && $popular_tvshow = $popular_tvshow->where('is_restricted', $request->is_restricted);
            (!empty(getCurrentProfileSession('is_child_profile')) && getCurrentProfileSession('is_child_profile') != 0) &&
                $popular_tvshow = $popular_tvshow->where('is_restricted',0);

            $popular_tvshow = $popular_tvshow->get();
            $popular_tvshow = CommanResource::collection($popular_tvshow);
        }else{
            $popular_tvshow = collect();
        }

       $genreIds = MobileSetting::getValueBySlug('genre');
       $genreIdsArray = json_decode($genreIds, true);
       $genres = !empty($genreIdsArray) ? GenresResource::collection(
           Genres::whereIn('id', $genreIdsArray)
               ->where('status', 1)

               ->get()
       ) : collect();

       $videoIds = MobileSetting::getValueBySlug('popular-videos');
       $videoIdsArray = json_decode($videoIds, true);
       if(!empty($videoIdsArray))
       {
            $popular_videos = Video::whereIn('id', $videoIdsArray)
               ->where('status', 1);
            isset($request->is_restricted) && $popular_videos = $popular_videos->where('is_restricted', $request->is_restricted);
            (!empty(getCurrentProfileSession('is_child_profile')) && getCurrentProfileSession('is_child_profile') != 0) &&
            $popular_videos = $popular_videos->where('is_restricted',0);

            $popular_videos = $popular_videos->get();
            $popular_videos = VideoResource::collection($popular_videos);
        } else{
            $popular_videos = collect();
        }

       $entertainment_list = Entertainment::with([
           'entertainmentReviews' => function ($query) {
               $query->whereBetween('rating', [4, 5])->take(6);
           }
       ])->where('status', 1)
       ->where('type', 'movie');
       isset($request->is_restricted) && $entertainment_list = $entertainment_list->where('is_restricted', $request->is_restricted);
       (!empty(getCurrentProfileSession('is_child_profile')) && getCurrentProfileSession('is_child_profile') != 0) &&
            $entertainment_list = $entertainment_list->where('is_restricted',0);

       $entertainment_list = $entertainment_list->whereDate('release_date', '<=', Carbon::now())->get();

       $tranding_movie = CommanResource::collection($entertainment_list);

       $responseData = [
        'latest_movie' => $latest_movie,
        'popular_language' => $popular_language,
        'popular_movie' => $popular_movie,
        'top_channel' => $top_channel,
        'personality' => $personality,
        'tranding_movie'=>$tranding_movie,
        'free_movie' => $free_movie,
        'genres' => $genres,
        'popular_tvshow' => $popular_tvshow,
        'popular_videos' => $popular_videos,
        'likedMovies' => $likedMovies ?? [],
        'viewedMovies' => $viewedMovies ?? [],
        'trendingMovies' => $trendingMovies ?? [],
        'favorite_gener' => $FavoriteGener ?? [],
        'favorite_personality' => $favorite_personality ?? [],
        'base_on_last_watch'=>$Lastwatchrecommendation ?? [],
    ];

    // Cache::put($cacheKey,$responseData);

    return response()->json([
        'status' => true,
        'data' => $responseData,
        'message' => __('messages.dashboard_detail'),
    ], 200);


}

    public function getTrandingData(Request $request){


        if ($request->has('is_ajax') && $request->is_ajax == 1) {

            $popularMovieIds = MobileSetting::getValueBySlug(slug: 'popular-movies');
            $movieList = Entertainment::whereIn('id',json_decode($popularMovieIds));

            isset(request()->is_restricted) && $movieList = $movieList->where('is_restricted', request()->is_restricted);
            (!empty(getCurrentProfileSession('is_child_profile')) && getCurrentProfileSession('is_child_profile') != 0) &&
                $movieList = $movieList->where('is_restricted',0);

            $movieList = $movieList->where('status',1)
                            ->where(function($query) {
                                $query->whereNull('release_date')
                                    ->orWhere('release_date', '<=', now());
                            })
                        ->get();

            $html = '';
            if($request->has('section')&& $request->section == 'tranding_movie'){
                $movieData = (isenablemodule('movie') == 1) ? MoviesResource::collection($movieList) : [];
                if(!empty( $movieData)){

                    foreach( $movieData->toArray(request()) as $index => $movie){
                        $html .= view('frontend::components.card.card_entertainment',['value' => $movie])->render();
                    }
                }
            }


        return response()->json([
                'status' => true,
                'html' => $html,
                'message' => __('movie.tvshow_list'),
            ], 200);
        }



    }
    public function getEntertainmentData(Request $request)
    {
        $type = $request->query('type', 'movie'); // Default to 'movie'
        $user_id = $request->user_id ?? null;


        $isBanner = MobileSetting::getValueBySlug('banner');
        if($request->type == 'tvshow'){
            $type = 'tv_show';
        }

        // $sliderList = $isBanner
        // ? Banner::get_sliderList($request->type)
        // : collect();


        $sliderList = $isBanner
        ? Banner::where('status',1)->where('banner_for',$type)->get()
        : collect();

        $sliderList->each(function ($item) use ($user_id) {
            $item->user_id = $user_id;
        });

       $sliders = SliderResource::collection($sliderList)->toArray(request());
        return response()->json([
            'status' => true,
            'data' => [
                'slider' => $sliders,
            ],
            'message' => __('messages.' . $type . '_detail'),
        ], 200);
    }




    // public function getMovieData(Request $request)
    // {
    //     return $this->getEntertainmentData($request, 'movie');
    // }

    // public function getTvShowData(Request $request)
    // {
    //     return $this->getTvshowAllData($request, 'tvshow');
    // }
    public function DashboardDetailDataV2(Request $request)
    {

        $user_id = !empty($request->user_id) ? $request->user_id : null;

        if (!Cache::has('genres')) {
            $genresData = Genres::get(['id','name'])->keyBy('id')->toArray();
            Cache::put('genres', $genresData);
        }


            if($request->has('user_id'))
            {
            //    $continueWatchList = ContinueWatch::where('user_id', $user_id)
            //    ->where('profile_id',$request->profile_id)->get();
            //    $continueWatch = ContinueWatchResource::collection($continueWatchList);

               $user = User::where('id',$request->user_id)->first();
               $profile_id=$request->profile_id;

               if( $user_id !=null)
               {
                   $user = User::where('id',$user_id)->first();

                    $likedMovies = $this->recommendationServiceV2->getLikedMovies($user, $profile_id);
                    $likedMovies->each(function ($movie) use ($user_id) {
                        $movie->user_id = $user_id; // Add the user_id to each movie
                    });
                    $likedMovies = CommanResource::collection($likedMovies);
                    $viewedMovies = $this->recommendationService->getEntertainmentViews($user, $profile_id);
                    $viewedMovies->each(function ($movie) use ($user_id) {
                        $movie->user_id = $user_id; // Add the user_id to each movie
                    });
                    $viewedMovies = CommanResource::collection($viewedMovies);

                    $FavoriteGener = $this->recommendationService->getFavoriteGener($user, $profile_id);
                    $FavoriteGener = GenresResource::collection($FavoriteGener);


                    $favorite_personality = $this->recommendationService->getFavoritePersonality($user, $profile_id);
                     $favorite_personality = CastCrewListResource::collection($favorite_personality);

                    $trendingMovies = $this->recommendationService->getTrendingMoviesByCountry($user, $request);
                    $trendingMovies->each(function ($movie) use ($user_id) {
                        $movie->user_id = $user_id; // Add the user_id to each movie
                    });
                    $trendingMovies = CommanResource::collection($trendingMovies);
               }

            }

           $latestMovieIds = MobileSetting::getCacheValueBySlug('latest-movies');
           $latestMovieIdsArray = json_decode($latestMovieIds, true);


           $latest_movie = (!empty($latestMovieIdsArray)) ? Entertainment::get_latest_movie($latestMovieIdsArray) : collect();
           $latest_movie->each(function ($movie) use ($user_id) {
                $movie->user_id = $user_id; // Add the user_id to each movie
            });


           $latest_movie = MoviesResource::collection($latest_movie)->toArray(request());


           $languageIds = MobileSetting::getCacheValueBySlug('enjoy-in-your-native-tongue');
           $languageIdsArray = json_decode($languageIds, true);
           $popular_language = !empty($languageIdsArray) ? Constant::whereIn('id', $languageIdsArray)->get() : collect();

           $popularMovieIds = MobileSetting::getCacheValueBySlug('popular-movies');

           $popularMovieIdsArray = json_decode($popularMovieIds, true);
           $popular_movie = (!empty($popularMovieIdsArray)) ? Entertainment::get_popular_movie($popularMovieIdsArray) : collect();
           $popular_movie->each(function ($movie) use ($user_id) {
                $movie->user_id = $user_id; // Add the user_id to each movie
           });
           $popular_movie = MoviesResource::collection($popular_movie)->toArray(request());


           $channelIds = MobileSetting::getValueBySlug('top-channels');
           $channelIdsArray = json_decode($channelIds, true);

           $top_channel = (!empty($channelIdsArray)) ? LiveTvChannel::get_top_channel($channelIdsArray) : collect();
           $top_channel = LiveTvChannelResource::collection($top_channel)->toArray(request());



           $castIds = MobileSetting::getValueBySlug('your-favorite-personality');
           $castIdsArray = json_decode($castIds, true);
           $personality = [];
            if (!empty($castIdsArray)) {
               $casts = CastCrew::whereIn('id', $castIdsArray)->get();
               foreach ($casts as $value) {
                   $personality[] = [
                       'id' => $value->id,
                       'name' => $value->name,
                       'type' => $value->type,
                       'profile_image' => setBaseUrlWithFileName($value->file_url),
                   ];
               }
            }

           $movieIds = MobileSetting::getValueBySlug('500-free-movies');
           $movieIdsArray = json_decode($movieIds, true);


           $free_movie = !empty($movieIdsArray) ? Entertainment::get_free_movie($movieIdsArray) : collect();
           $free_movie = MoviesResource::collection($free_movie)->toArray(request());


           $popular_tvshowIds = MobileSetting::getValueBySlug('popular-tvshows');
           $popular_tvshowIdsArray = json_decode($popular_tvshowIds, true);

           $popular_tvshow = !empty($popular_tvshowIdsArray) ? Entertainment::get_popular_tvshow($popular_tvshowIdsArray) : collect();
           $popular_tvshow->each(function ($video) use ($user_id) {
                 $video->user_id = $user_id; // Add the user_id to each movie
            });
           $popular_tvshow = TvshowResource::collection($popular_tvshow)->toArray(request());


           $genreIds = MobileSetting::getValueBySlug('genre');
           $genreIdsArray = json_decode($genreIds, true);
           $genres = !empty($genreIdsArray) ? GenresResource::collection(
               Genres::whereIn('id', $genreIdsArray)
                   ->where('status', 1)
                   ->get()
           ) : collect();

            $videoIds = MobileSetting::getValueBySlug('popular-videos');
            $videoIdsArray = json_decode($videoIds, true);

            $popular_videos = !empty($videoIdsArray) ? Video::get_popular_videos($videoIdsArray) : collect();
            $popular_videos->each(function ($video) use ($user_id) {
                $video->user_id = $user_id; // Add the user_id to each movie
            });
            $popular_videos = VideoResource::collection($popular_videos)->toArray(request());

            $tranding_movie = Entertainment::get_entertainment_list();
            $tranding_movie = MoviesResource::collection($tranding_movie)->toArray(request());
            $payPerViewRequest = new Request(['user_id' => $user_id]);

            $payPerViewContent = $this->getPayPerViewUnlockedContent( $payPerViewRequest);
            // Define slugs and their default names
            $slugsWithDefaults = [
                'latest-movies' => 'Latest Movies',
                'enjoy-in-your-native-tongue' => 'Popular Language',
                'popular-movies' => 'Popular Movies',
                'top-channels' => 'Top Channels',
                'your-favorite-personality' => 'Popular Personalities',
                '500-free-movies' => 'Free Movies',
                'popular-tvshows' => 'Popular TV Show',
                'genre' => 'Genres',
                'popular-videos' => 'Popular Videos',
            ];

            // Fetch all required settings in one query
            $settings = MobileSetting::whereIn('slug', array_keys($slugsWithDefaults))->pluck('name', 'slug');

            // Resolve names with fallback to default
            $sectionNames = [];
            foreach ($slugsWithDefaults as $slug => $default) {
                $sectionNames[$slug] = $settings[$slug] ?? $default;
            }
           $responseData = [
               'latest_movie' => [
                    'name' => $sectionNames['latest-movies'],
                    'data' => $latest_movie,
                    ],
                'popular_language' => [
                    'name' => $sectionNames['enjoy-in-your-native-tongue'],
                    'data' => $popular_language,
                ],
                'popular_movie' => [
                    'name' => $sectionNames['popular-movies'],
                    'data' => $popular_movie,
                ],
                'top_channel' => [
                    'name' => $sectionNames['top-channels'],
                    'data' => $top_channel,
                ],
                'personality' => [
                    'name' => $sectionNames['your-favorite-personality'],
                    'data' => $personality,
                ],
                'free_movie' => [
                    'name' => $sectionNames['500-free-movies'],
                    'data' => $free_movie,
                ],
                'popular_tvshow' => [
                    'name' => $sectionNames['popular-tvshows'],
                    'data' => $popular_tvshow,
                ],
                'genres' => [
                    'name' => $sectionNames['genre'],
                    'data' => $genres,
                ],
                'popular_videos' => [
                    'name' => $sectionNames['popular-videos'],
                    'data' => $popular_videos,
                ],
               'likedMovies' => $likedMovies ?? [],
               'viewedMovies' => $viewedMovies ?? [],
               'trendingMovies' => $trendingMovies ?? [],
               'favorite_gener' => $FavoriteGener ?? [],
               'favorite_personality' => $favorite_personality ?? [],
               'base_on_last_watch'=> $Lastwatchrecommendation ?? [],
               'tranding_movie'=>$tranding_movie,
               'pay_per_view' => $payPerViewContent,
           ];

        return response()->json([
            'status' => true,
            'data' => $responseData,
            'message' => __('messages.dashboard_detail'),
        ], 200);
    }

    public function DashboardDetailV2(Request $request)
    {
        if (!Cache::has('genres')) {
            $genresData = Genres::get(['id','name'])->keyBy('id')->toArray();
            Cache::put('genres', $genresData);
        }

        $user_id = !empty($request->user_id) ? $request->user_id : null;
        $continueWatch = [];

        if($request->has('user_id')){
            $continueWatchList = ContinueWatch::where('user_id', $user_id)
            ->where('profile_id',$request->profile_id)->get();
            $continueWatch = ContinueWatchResourceV2::collection($continueWatchList);
        }

        $isBanner = MobileSetting::getCacheValueBySlug('banner');
        $sliderList = $isBanner
        ? Banner::where('banner_for','home')->where('status', 1)->get()
        : collect();

        $sliders = SliderResource::collection(
            $sliderList->map(fn($slider) => new SliderResource($slider, $user_id))
       );


        $topMovieIds = MobileSetting::getCacheValueBySlug('top-10');

        $top_10 = !empty($topMovieIds) ? Entertainment::get_top_movie(json_decode($topMovieIds, true)) : collect();

        $top_10 = MoviesResource::collection($top_10)->toArray(request());

        $responseData = [
           'slider' => $sliders,
           'continue_watch' => $continueWatch,
           'top_10' => $top_10
        ];

       // Cache::put($cacheKey,$responseData);

       return response()->json([
           'status' => true,
           'data' => $responseData,
           'message' => __('messages.dashboard_detail'),
       ], 200);
    }

    public function getPayPerViewUnlockedContent(Request $request)
    {
        $payPerViewContent = [];
        $user_id = $request->query('user_id');


        // Movies
       $movies = MoviesResource::collection(
          Entertainment::where('movie_access', 'pay-per-view')
              ->where('type', 'movie')
              ->where('status', 1)
              ->when(request()->has('is_restricted'), function ($query) {
                  $query->where('is_restricted', request()->is_restricted);
              })
              ->when(getCurrentProfileSession('is_child_profile') && getCurrentProfileSession('is_child_profile') != 0, function ($query) {
                  $query->where('is_restricted', 0);
              })
              ->get()
      )->map(function ($item) use ($user_id) {
          $item->user_id = $user_id;
          return $item;
      })->toArray(request());

      $payPerViewContent = array_merge($payPerViewContent, $movies);

        // TV Shows
        $tvshows = TvshowResource::collection(
            Entertainment::where('movie_access', 'pay-per-view')
                ->where('type', 'tvshow')
                ->where('status', 1)
                ->get()
        )->map(function ($item) use ($user_id) {
            $item->user_id = $user_id;
            return $item;
        })->toArray(request());
        $payPerViewContent = array_merge($payPerViewContent, $tvshows);

        // Videos
        $videos = VideoResource::collection(
            Video::where('access', 'pay-per-view')
                ->where('status', 1)
                  ->when(request()->has('is_restricted'), function ($query) {
                  $query->where('is_restricted', request()->is_restricted);
              })
              ->when(getCurrentProfileSession('is_child_profile') && getCurrentProfileSession('is_child_profile') != 0, function ($query) {
                  $query->where('is_restricted', 0);
              })
                ->get()
        )->map(function ($item) use ($user_id) {
            $item->user_id = $user_id;
            return $item;
        })->toArray(request());
        $payPerViewContent = array_merge($payPerViewContent, $videos);

        // Seasons
        $seasons = SeasonResource::collection(
            Season::where('access', 'pay-per-view')
                ->where('status', 1)
                ->get()
        )->map(function ($item) use ($user_id) {
            $item->user_id = $user_id;
            return $item;
        })->toArray(request());
        $payPerViewContent = array_merge($payPerViewContent, $seasons);

        // Episodes
        $episodes = EpisodeResource::collection(
            Episode::where('access', 'pay-per-view')
                ->where('status', 1)
                  ->when(request()->has('is_restricted'), function ($query) {
                  $query->where('is_restricted', request()->is_restricted);
              })
              ->when(getCurrentProfileSession('is_child_profile') && getCurrentProfileSession('is_child_profile') != 0, function ($query) {
                  $query->where('is_restricted', 0);
              })
                ->get()
        )->map(function ($item) use ($user_id) {
            $item->user_id = $user_id;
            return $item;
        })->toArray(request());
        $payPerViewContent = array_merge($payPerViewContent, $episodes);

        if ($request->is('api/*')) {
            return response()->json([
                'status' => true,
                'data' => $payPerViewContent
            ]);
        }

        return $payPerViewContent;
    }
}
