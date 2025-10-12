<?php

namespace Modules\Frontend\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MobileSetting;
use Modules\Constant\Models\Constant;
use Modules\Entertainment\Models\Entertainment;
use Modules\Entertainment\Transformers\MoviesResource;
use Illuminate\Support\Facades\Cache;
use Modules\Episode\Models\Episode;
use Modules\LiveTV\Models\LiveTvChannel;
use Modules\LiveTV\Transformers\LiveTvChannelResource;
use Modules\Entertainment\Transformers\TvshowResource;
use Modules\CastCrew\Models\CastCrew;
use Modules\Genres\Transformers\GenresResource;
use Modules\Genres\Models\Genres;
use Modules\Season\Models\Season;
use Modules\Video\Transformers\VideoResource;
use Modules\Video\Models\Video;
use App\Services\RecommendationService;
use Modules\Entertainment\Models\ContinueWatch;
use Modules\Entertainment\Transformers\ContinueWatchResource;
use Auth;
use Modules\CastCrew\Transformers\CastCrewListResource;
use Modules\Entertainment\Transformers\SeasonResource;
use Modules\Entertainment\Transformers\EpisodeResource;

class DashboardController extends Controller
{
    protected $recommendationService;


    public function __construct(RecommendationService $recommendationService)
    {
        $this->recommendationService = $recommendationService;

    }


    public function Top10Movies()
    {
        $cacheKey = 'top_10_movie';
        $top_10 = Cache::get($cacheKey);

         $html='';

        if (!$top_10) {
            $top_10=[];
            $topMovieIds = MobileSetting::getValueBySlug('top-10');
            if($topMovieIds != null){
                $topMovies = Entertainment::whereIn('id', json_decode($topMovieIds));
                isset(request()->is_restricted) && $topMovies = $topMovies->where('is_restricted', request()->is_restricted);
                (!empty(getCurrentProfileSession('is_child_profile')) && getCurrentProfileSession('is_child_profile') != 0) &&
                $topMovies = $topMovies->where('is_restricted',0);

                $topMovies = $topMovies->where('status', 1)
                    ->where(function($query) {
                        $query->whereNull('release_date')
                              ->orWhere('release_date', '<=', now());
                    })
                    ->get();

                $top_10 = MoviesResource::collection($topMovies);
                $top_10 = $top_10->toArray(request());

              }


            Cache::put($cacheKey, $top_10);
        }

        if(!empty($top_10)){
          $html = view('frontend::components.section.top_10_movie', ['top10' => $top_10])->render();
        }

        return response()->json(['html' => $html]);
    }


    public function LatestMovies()
    {
         $cacheKey = 'latest_movie';
         $latest_movie = Cache::get($cacheKey);
         $html='';
         if(!$latest_movie){
            $latest_movie=[];
            // Get both the IDs and the name from MobileSetting
            $latestSetting = MobileSetting::where('slug', 'latest-movies')->first();
            $latestMovieIds = $latestSetting ? $latestSetting->value : null;
            $sectionName = $latestSetting ? $latestSetting->name : __('frontend.latest_movie');

            if($latestMovieIds != null){
               $latestMovie = Entertainment::whereIn('id',json_decode($latestMovieIds));
               isset(request()->is_restricted) && $latestMovie = $latestMovie->where('is_restricted', request()->is_restricted);
                (!empty(getCurrentProfileSession('is_child_profile')) && getCurrentProfileSession('is_child_profile') != 0) &&
                $latestMovie = $latestMovie->where('is_restricted',0);

                $latestMovie = $latestMovie->where('status',1)->get();
               $latest_movie = MoviesResource::collection($latestMovie);
             }

            Cache::put($cacheKey, $latest_movie);
         }

      if(!empty($latest_movie)){
        $html = view('frontend::components.section.entertainment', ['data' =>  $latest_movie , 'title' => $sectionName ?? __('frontend.latest_movie'),'type' => 'movie','slug'=>'latest_movie'] )->render();
       }

        return response()->json(['html' => $html]);
    }

    public function FetchLanguages()
    {
       $cacheKey = 'popular_language';
       $popular_language = Cache::get($cacheKey);

       $html='';

       if(!$popular_language){

         $popular_language=[];

          // Get both the IDs and the name from MobileSetting
          $languageSetting = MobileSetting::where('slug', 'enjoy-in-your-native-tongue')->first();
          $languageIds = $languageSetting ? $languageSetting->value : null;
          $sectionName = $languageSetting ? $languageSetting->name : __('frontend.popular_language');

         if($languageIds != null){
            $popular_language = Constant::whereIn('id', json_decode($languageIds))->where('type','movie_language')->get();
          }

          Cache::put($cacheKey, $popular_language);
       }

       if(!empty($popular_language)){

        $html = view('frontend::components.section.language', ['popular_language' =>  $popular_language , 'title' => $sectionName ?? __('frontend.popular_language')]) ->render();

       }

     return response()->json(['html' => $html]);

    }

    public function PopularMovies()
    {
         $cacheKey = 'popular_movie';
         $popular_movie = Cache::get($cacheKey);
         $html='';
         if(!$popular_movie){
            $popular_movie=[];
            // Get both the IDs and the name from MobileSetting
            $popularSetting = MobileSetting::where('slug', 'popular-movies')->first();
            $popularMovieIds = $popularSetting ? $popularSetting->value : null;
            $sectionName = $popularSetting ? $popularSetting->name : __('frontend.popular_movie');

            if($popularMovieIds != null){
               $popular_movie = Entertainment::whereIn('id',json_decode($popularMovieIds));
               isset(request()->is_restricted) && $popular_movie = $popular_movie->where('is_restricted', request()->is_restricted);
                (!empty(getCurrentProfileSession('is_child_profile')) && getCurrentProfileSession('is_child_profile') != 0) &&
                $popular_movie = $popular_movie->where('is_restricted',0);

                $popular_movie = $popular_movie->where('status',1)->get();
               $popular_movie = MoviesResource::collection($popular_movie);
             }

            Cache::put($cacheKey, $popular_movie);
         }

      if(!empty($popular_movie)){
        $html = view('frontend::components.section.entertainment', ['data' =>  $popular_movie , 'title' => $sectionName ?? __('frontend.popular_movie'),'type' => 'movie','slug'=>'popular_movie'])->render();
       }

        return response()->json(['html' => $html]);
    }


    public function TopChannels()
    {
        $cacheKey = 'top_channel';
        $top_channel = Cache::get($cacheKey);

       $html='';

       if(!$top_channel){

         $top_channel=[];

         // Get both the IDs and the name from MobileSetting
         $channelSetting = MobileSetting::where('slug', 'top-channels')->first();
         $channelIds = $channelSetting ? $channelSetting->value : null;
         $sectionName = $channelSetting ? $channelSetting->name : __('frontend.top_tvchannel');

         if($channelIds != null){
            $channels = LiveTvChannel::whereIn('id',json_decode($channelIds))->where('status',1)->get();
            $top_channel = LiveTvChannelResource::collection($channels);
            $top_channel = $top_channel->toArray(request());
          }
          Cache::put($cacheKey, $top_channel);
       }

       if(!empty($top_channel)){

         $html = view('frontend::components.section.tvchannel',  ['top_channel' => $top_channel,'title' => $sectionName ?? __('frontend.top_tvchannel')]) ->render();

       }

     return response()->json(['html' => $html]);

    }


    public function PopularTVshows()
    {
         $cacheKey = 'popular_tvshow';
         $popular_tvshow = Cache::get($cacheKey);
         $html='';
         if(!$popular_tvshow){
            $popular_tvshow=[];
            // Get both the IDs and the name from MobileSetting
            $tvshowSetting = MobileSetting::where('slug', 'popular-tvshows')->first();
            $popular_tvshowIds = $tvshowSetting ? $tvshowSetting->value : null;
            $sectionName = $tvshowSetting ? $tvshowSetting->name : __('frontend.popular_tvshow');

            if($popular_tvshowIds != null){
               $popular_tvshow = Entertainment::whereIn('id',json_decode($popular_tvshowIds));
               isset(request()->is_restricted) && $popular_tvshow = $popular_tvshow->where('is_restricted', request()->is_restricted);
                (!empty(getCurrentProfileSession('is_child_profile')) && getCurrentProfileSession('is_child_profile') != 0) &&
                $popular_tvshow = $popular_tvshow->where('is_restricted',0);

                $popular_tvshow = $popular_tvshow->where('status',1)->get();
               $popular_tvshow = TvshowResource::collection($popular_tvshow);
             }

            Cache::put($cacheKey, $popular_tvshow);
         }

      if(!empty($popular_tvshow)){
        $html = view('frontend::components.section.entertainment',  ['data' =>  $popular_tvshow , 'title' => $sectionName ?? __('frontend.popular_tvshow'),'type' => 'tvshow','slug'=>'popular_tvshow'])->render();

       }

        return response()->json(['html' => $html]);
    }

    public function favoritePersonality()
    {
         $cacheKey = 'personality';
         $personality = Cache::get($cacheKey);

       $html='';

       if(!$personality){

         $personality=[];

         // Get both the IDs and the name from MobileSetting
         $personalitySetting = MobileSetting::where('slug', 'your-favorite-personality')->first();
         $castIds = $personalitySetting ? $personalitySetting->value : null;
         $sectionName = $personalitySetting ? $personalitySetting->name : __('frontend.personality');

         if($castIds != null){
            $casts = CastCrew::whereIn('id',json_decode($castIds))->get();

            $personality = [];
            foreach ($casts as $key => $value) {
                $personality[] = [
                    'id' => $value->id,
                    'name' => $value->name,
                    'type' => $value->type,
                    'profile_image' => setBaseUrlWithFileName($value->file_url),
                ];
            }
          }

          Cache::put($cacheKey, $personality);
       }

       if(!empty($personality)){

        $html = view('frontend::components.section.castcrew',  ['data' => $personality,'title' => $sectionName ?? __('frontend.personality'),'entertainment_id' => 'all', 'type'=>'actor','slug'=>'favorite_personality']) ->render();

       }

     return response()->json(['html' => $html]);

    }

    public function FreeMovies()
    {
         $cacheKey = 'free_movie';
        $free_movies = Cache::get($cacheKey);

         $html='';
         if(!$free_movies ){
            $free_movies =[];
            // Get both the IDs and the name from MobileSetting
            $freeSetting = MobileSetting::where('slug', '500-free-movies')->first();
            $movieIds = $freeSetting ? $freeSetting->value : null;
            $sectionName = $freeSetting ? $freeSetting->name : __('frontend.free_movie');

            if($movieIds != null){
                $free_movies= Entertainment::whereIn('id',json_decode($movieIds))->where('movie_access','free');
                isset(request()->is_restricted) && $free_movies = $free_movies->where('is_restricted', request()->is_restricted);
                (!empty(getCurrentProfileSession('is_child_profile')) && getCurrentProfileSession('is_child_profile') != 0) &&
                $free_movies = $free_movies->where('is_restricted',0);

                $free_movies = $free_movies->where('status',1)->get();
                $free_movies = MoviesResource::collection($free_movies);
                $free_movies =  $free_movies->toArray(request());

             }

             Cache::put($cacheKey, $free_movies);

         }

      if(!empty($free_movies)){
        $html = view('frontend::components.section.entertainment',  ['data' => $free_movies,'title' => $sectionName ?? __('frontend.free_movie'),'type' =>'movie','slug'=>'free_movie'])->render();
       }

        return response()->json(['html' => $html]);
    }

    public function GetGener()
    {
        $cacheKey = 'genres';
        $genres = Cache::get($cacheKey);

       $html='';

       if(!$genres){

         $genres=[];

          // Get both the IDs and the name from MobileSetting
          $genreSetting = MobileSetting::where('slug', 'genre')->first();
          $genreIds = $genreSetting ? $genreSetting->value : null;
          $sectionName = $genreSetting ? $genreSetting->name : __('frontend.genres');

         if($genreIds != null){
            $genres = Genres::whereIn('id',json_decode($genreIds))->where('status',1)->get();
            $genres = GenresResource::collection($genres);
            $genres = $genres->toArray(request());
            Cache::put($cacheKey, $genres);
          }

       }

       if(!empty($genres)){

         $html = view('frontend::components.section.geners',  ['genres' => $genres,'title' => $sectionName ?? __('frontend.genres'),'slug'=>'gener-section']) ->render();

        }

       return response()->json(['html' => $html]);

    }

    public function GetVideo()
    {
        $cacheKey = 'popular_videos';
        $popular_videos = Cache::get($cacheKey);

       $html='';

       if(!$popular_videos){

         $genres=[];

         // Get both the IDs and the name from MobileSetting
         $videoSetting = MobileSetting::where('slug', 'popular-videos')->first();
         $videoIds = $videoSetting ? $videoSetting->value : null;
         $sectionName = $videoSetting ? $videoSetting->name : __('frontend.popular_videos');

         if($videoIds != null){
            $popular_videos = Video::whereIn('id',json_decode($videoIds));
            isset(request()->is_restricted) && $popular_videos = $popular_videos->where('is_restricted', request()->is_restricted);
                (!empty(getCurrentProfileSession('is_child_profile')) && getCurrentProfileSession('is_child_profile') != 0) &&
                $popular_videos = $popular_videos->where('is_restricted',0);

            $popular_videos = $popular_videos->where('status',1)->get();
            $popular_videos = VideoResource::collection($popular_videos);
            Cache::put($cacheKey, $popular_videos);
          }

       }

       if(!empty($popular_videos)){

         $html = view('frontend::components.section.video',  ['data' => $popular_videos,'title' => $sectionName ?? __('frontend.popular_videos')]) ->render();

        }

       return response()->json(['html' => $html]);

    }


    public function  GetLastWatchContent(Request $request){

        $html='';
        $user=Auth::user();
        $profile_id=getCurrentProfile($user->id, $request);

        $based_on_last_watch = $this->recommendationService->recommendByLastHistory($user,$profile_id);
        if (collect($based_on_last_watch)->isEmpty()) {
          return response()->json(['html' => '']);
       }
        $Lastwatchrecommendation = MoviesResource::collection($based_on_last_watch );

      if ($Lastwatchrecommendation->isNotEmpty()) {
    $html = view('frontend::components.section.entertainment',  [
        'data' => $Lastwatchrecommendation,
        'title' => __('frontend.because_you_watch'),
        'type' => 'movie',
        'slug' => 'based_on_last_watch'
    ])->render();
}

      return response()->json(['html' => $html]);

    }

    public function MostLikeMoive(Request $request){

        $user=Auth::user();
        $profile_id=getCurrentProfile($user->id, $request);

        $html='';
        $likedMovies = $this->recommendationService->getLikedMovies($user, $profile_id);
        if ($likedMovies->isEmpty()) {
          return response()->json(['html' => '']);
        }
        $likedMovies = MoviesResource::collection($likedMovies);
       if(!empty($likedMovies)){

         $html = view('frontend::components.section.entertainment',  ['data' => $likedMovies,'title' => __('frontend.liked_movie'),'type' =>'movie','slug'=>'most-like'])->render();

       }


      return response()->json(['html' => $html]);

    }



      public function MostviewMoive(Request $request){

        $user=Auth::user();
        $profile_id=getCurrentProfile($user->id, $request);

        $html='';
        $viewedMovies = $this->recommendationService->getEntertainmentViews($user, $profile_id);
        if ($viewedMovies->isEmpty()) {
            return response()->json(['html' => '']);
        }
        $viewedMovies = MoviesResource::collection($viewedMovies);
       if(!empty($viewedMovies)){

         $html = view('frontend::components.section.entertainment',  ['data' => $viewedMovies,'title' => __('frontend.viewed_movie'),'type' =>'movie','slug'=>'most-view'])->render();

       }

        return response()->json(['html' => $html]);

    }


    public function TrandingInCountry(Request $request){

        $user=Auth::user();
        $profile_id=getCurrentProfile($user->id, $request);

        $html='';
        $trendingMovies = $this->recommendationService->getTrendingMoviesByCountry($user, $request);
        if ($trendingMovies->isEmpty()) {
            return response()->json(['html' => '']);
        }
        $trendingMovies = MoviesResource::collection($trendingMovies);

       if(!empty($trendingMovies)){

         $html = view('frontend::components.section.entertainment',  ['data' => $trendingMovies,'title' => __('frontend.trending_movies_country'),'type' =>'movie','slug'=>'tranding-in-country'])->render();

       }


      return response()->json(['html' => $html]);

    }

    public function FavoriteGenres(Request $request){

        $user=Auth::user();
        $profile_id=getCurrentProfile($user->id, $request);

        $html='';

        $favorite_gener = $this->recommendationService->getFavoriteGener($user, $profile_id);
        $FavoriteGener = GenresResource::collection($favorite_gener);
        $FavoriteGener = $FavoriteGener->toArray(request());

       if(!empty($FavoriteGener)){

         $html = view('frontend::components.section.geners',  ['genres' => $FavoriteGener,'title' => __('frontend.favroite_geners'),'slug'=>'favorite-genres'])->render();

       }

      return response()->json(['html' => $html]);

    }

    public function UserfavoritePersonality(Request $request){

        $user=Auth::user();
        $profile_id=getCurrentProfile($user->id, $request);

        $html='';

        $favorite_personality = $this->recommendationService->getFavoritePersonality($user, $profile_id);
        $favorite_personality = CastCrewListResource::collection($favorite_personality);
        $favorite_personality = $favorite_personality->toArray(request());

        if(!empty($favorite_personality)){

            $html = view('frontend::components.section.castcrew',  ['data' => $favorite_personality,'title' => __('frontend.favorite_personality'),'entertainment_id' => 'all', 'type'=>'actor' ,'slug'=>'user-favorite_personality']) ->render();

           }
      return response()->json(['html' => $html]);

    }

    public function ContinuewatchList(Request $request){

        $user=Auth::user();

        $profile_id=getCurrentProfile($user->id, $request);

        $html='';

        $continueWatchList = ContinueWatch::where('user_id', $user->id)
        ->whereNotNull('watched_time')
        ->whereNotNull('total_watched_time')
        ->where('profile_id', $profile_id)
        ->whereHas('entertainment', function ($query) {
            $query->where('status', 1);
            isset(request()->is_restricted) && $query->where('is_restricted', request()->is_restricted);
            (!empty(getCurrentProfileSession('is_child_profile')) && getCurrentProfileSession('is_child_profile') != 0) &&
                $query->where('is_restricted',0);
        })
        ->with(['entertainment', 'episode', 'video'])
        ->orderBy('id', 'desc')
        ->get();
         $continue_watch = $continueWatchList->map(function ($item) {
             return new ContinueWatchResource($item);
         })->toArray();

        if(!empty($continue_watch)){

            $html = view('frontend::components.section.continue_watch',  ['continuewatchData' =>  $continue_watch])->render();

           }
      return response()->json(['html' => $html]);

    }

    public function getPinpopup($id)
    {
        $result = getLoggedUserPin($id);
        if (empty($result)) {
            return response()->json(['error' => "something went wrong"], 400);
        }

        return response()->json(['data' => $result]);
    }

    public function ContinuewatchListV2(Request $request)
    {
        $user=Auth::user();

        $profile_id = getCurrentProfile($user->id, $request);

        $html='';

        $cacheKey = 'ContinuewatchList_'.$user->id.'_'.$profile_id;
        $resultData = Cache::get($cacheKey);

        if(!empty($resultData))
        {
            return response()->json(['html' => $resultData]);
        }

        $continueWatchList = ContinueWatch::where('user_id', $user->id)
        ->whereNotNull('watched_time')
        ->whereNotNull('total_watched_time')
        ->where('profile_id', $profile_id)
        ->whereHas('entertainment', function ($query) {
            $query->where('status', 1);

            isset(request()->is_restricted) && $query->where('is_restricted', request()->is_restricted);
            (!empty(getCurrentProfileSession('is_child_profile')) && getCurrentProfileSession('is_child_profile') != 0) &&
                $query->where('is_restricted',0);
        })
        ->with(['entertainment', 'episode', 'video'])
        ->orderBy('id', 'desc')
        ->get();
         $continue_watch = $continueWatchList->map(function ($item) {
             return new ContinueWatchResource($item);
         })->toArray();

        if(!empty($continue_watch)){
            $html = view('frontend::components.section.continue_watch',  ['continuewatchData' =>  $continue_watch])->render();
        }

        Cache::put($cacheKey, $html, now()->addMinutes(60));
        return response()->json(['html' => $html]);
    }

    public function Top10MoviesV2()
    {
        $cacheKey = 'top_10_movie_v2';
        $top_10 = Cache::get($cacheKey);

        $html='';

        if (!$top_10) {
            $top_10=[];
            // Get both the IDs and the name from MobileSetting
            $topSetting = MobileSetting::where('slug', 'top-10')->first();
            $topMovieIds = $topSetting ? $topSetting->value : null;
            $sectionName = $topSetting ? $topSetting->name : __('frontend.top_10');

            if($topMovieIds != null){
                $topMovies = Entertainment::whereIn('id', json_decode($topMovieIds));
                isset(request()->is_restricted) && $topMovies = $topMovies->where('is_restricted', request()->is_restricted);
                (!empty(getCurrentProfileSession('is_child_profile')) && getCurrentProfileSession('is_child_profile') != 0) &&
                    $topMovies = $topMovies->where('is_restricted',0);

                $topMovies = $topMovies->where('status', 1)
                    ->where(function($query) {
                        $query->whereNull('release_date')
                              ->orWhere('release_date', '<=', now());
                    })
                    ->get();

                $top_10 = MoviesResource::collection($topMovies);
                $top_10 = $top_10->toArray(request());

              }


            Cache::put($cacheKey, $top_10);
        }

        if(!empty($top_10)){
          $html = view('frontend::components.section.top_10_movie', ['top10' => $top_10, 'sectionName' => $sectionName ?? __('frontend.top_10')])->render();
        }

        return response()->json(['html' => $html]);
    }

    function payperview(){
        $cacheKey = 'pay_per_view_combined';
        $payperview = Cache::get($cacheKey);

        $html = '';

        // if(!$payperview){
            // Fetch pay-per-view movies/TV shows
            $entertainments = Entertainment::where('movie_access', 'pay-per-view')->where('status', 1)->when(getCurrentProfileSession('is_child_profile') && getCurrentProfileSession('is_child_profile') != 0, function ($query) {
               $query->where('is_restricted', 0);
             })->get();
            $entertainments = MoviesResource::collection($entertainments)->toArray(request());

            // Fetch pay-per-view videos
            $videos = Video::where('access', 'pay-per-view')->when(getCurrentProfileSession('is_child_profile') && getCurrentProfileSession('is_child_profile') != 0, function ($query) {
             $query->where('is_restricted', 0);
            })->where('status', 1)->get();
            $videos = VideoResource::collection($videos)->toArray(request());


            $episode = Episode::where('access', 'pay-per-view')->when(getCurrentProfileSession('is_child_profile') && getCurrentProfileSession('is_child_profile') != 0, function ($query) {
            $query->where('is_restricted', 0);
            })->where('status', 1)->get();
            $episode = EpisodeResource::collection($episode)->toArray(request());

            $payperview = array_merge($entertainments, $videos, $episode);

        //     Cache::put($cacheKey, $payperview);
        // }

        if(!empty($payperview)) {
            $html = view('frontend::components.section.entertainment', [
                'data' => $payperview,
                'title' => __('messages.pay_per_view'),
                'type' => 'pay-per-view',
                'slug' => 'per_pay_view'
            ])->render();
        }

        return response()->json(['html' => $html]);
}

    function moviePayperview(){
      // $cacheKey = 'movie_pay_per_view';
      // $movies = Cache::get($cacheKey);

       $html='';
      //  if(!$movies ){
          $movies =[];
          // $movieIds = MobileSetting::getValueBySlug('500-free-movies');
              $allMovies = Entertainment::where('movie_access','pay-per-view')
              ->where('type','movie')
              ->where('status',1)
              ->when(getCurrentProfileSession('is_child_profile') && getCurrentProfileSession('is_child_profile') != 0, function ($query) {
                  $query->where('is_restricted', 0);
              })
              ->get();
              $movies = $allMovies->filter(function ($movie) {
                return Entertainment::isPurchased($movie->id, 'movie');
              });
              $movies = MoviesResource::collection($movies);
              $movies =  $movies->toArray(request());

          //  Cache::put($cacheKey, $movies);

      //  }

        if(!empty($movies)){

          $html = view('frontend::components.section.entertainment',  ['data' => $movies,'title' => __('frontend.movies'),'type' =>'movies-pay-per-view','slug'=>'movies_pay_per_view'])->render();
        }

      return response()->json(['html' => $html]);
    }

    function tvShowPayperview(){
      // $cacheKey = 'tvshows_pay_per_view';
      // $tvshow = Cache::get($cacheKey);

       $html='';
      //  if(!$tvshow ){
          $tvshow =[];
          // $movieIds = MobileSetting::getValueBySlug('500-free-movies');
              $allTvshow= Entertainment::where('movie_access','pay-per-view')->where('type','tvshow')->where('status',1)->get();
              $tvshow = $allTvshow->filter(function ($movie) {
                return Entertainment::isPurchased($movie->id, 'tvshow');
              });
              $tvshow = MoviesResource::collection($tvshow);
              $tvshow =  $tvshow->toArray(request());

          //  Cache::put($cacheKey, $tvshow);

      //  }

        if(!empty($tvshow)){
          $html = view('frontend::components.section.entertainment',  ['data' => $tvshow,'title' => __('frontend.tvshows'),'type' =>'tvshows-pay-per-view','slug'=>'tvshows_pay_per_view'])->render();
        }

      return response()->json(['html' => $html]);
    }

    public function videosPayperview()
    {
        // $cacheKey = 'pay_per_view_videos';
        // $videos = Cache::get($cacheKey);

       $html='';

      //  if(!$videos){

         $genres=[];

        //  $videoIds = MobileSetting::getValueBySlug(slug: 'popular-videos');

        //  if($videoIds != null){
          $allvideos = Video::where('access', 'pay-per-view')
    ->where('status', 1)
    ->when(request()->has('is_restricted'), function ($query) {
        $query->where('is_restricted', request()->is_restricted);
    })
    ->when(getCurrentProfileSession('is_child_profile') && getCurrentProfileSession('is_child_profile') != 0, function ($query) {
        $query->where('is_restricted', 0);
    })
    ->get();
            $videos = $allvideos->filter(function ($movie) {
              return Entertainment::isPurchased($movie->id, 'video');
            });
            $videos = VideoResource::collection($videos);
            // Cache::put($cacheKey, $videos);
          // }

      //  }

       if($videos->isNotEmpty()){

         $html = view('frontend::components.section.video',  ['data' => $videos,'title' => __('sidebar.videos')]) ->render();

        }

       return response()->json(['html' => $html]);

    }

    public function getSessionsPayPerView(Request $request)
    {
      // $cacheKey = 'pay_per_view_season';
        // $season = Cache::get($cacheKey);

       $html='';

      //  if(!$season){

         $genres=[];

        //  $videoIds = MobileSetting::getValueBySlug(slug: 'popular-videos');

        //  if($videoIds != null){
            $allvideos = Season::where('access','pay-per-view')->where('status',1)->get();
            $season = $allvideos->filter(function ($movie) {
              return Entertainment::isPurchased($movie->id, 'season');
            });
            $season = SeasonResource::collection($season);
            // Cache::put($cacheKey, $season);
          // }

      //  }

       if($season->isNotEmpty()){

        $html = view('frontend::components.section.season',  ['data' => $season,'title' => __('movie.seasons')]) ->render();

       }

       return response()->json(['html' => $html]);
    }

    public function getEpisodesPayPerView(Request $request)
    {
      // $cacheKey = 'pay_per_view_episode';
        // $season = Cache::get($cacheKey);

       $html='';

      //  if(!$season){
         $genres=[];
        //  $videoIds = MobileSetting::getValueBySlug(slug: 'popular-videos');

        //  if($videoIds != null){
            $allvideos = Episode::where('access', 'pay-per-view')
    ->where('status', 1)
    ->when(request()->has('is_restricted'), function ($query) {
        $query->where('is_restricted', request()->is_restricted);
    })
    ->when(getCurrentProfileSession('is_child_profile') && getCurrentProfileSession('is_child_profile') != 0, function ($query) {
        $query->where('is_restricted', 0);
    })
    ->get();
            $season = $allvideos->filter(function ($movie) {
              return Entertainment::isPurchased($movie->id, 'episode');
            });

            $season = EpisodeResource::collection($season);
            // Cache::put($cacheKey, $season);
          // }

      //  }

       if($season->isNotEmpty()){

        $html = view('frontend::components.section.episode',  ['data' => $season,'title' => __('sidebar.episodes')]) ->render();

       }

       return response()->json(['html' => $html]);
    }


}

























