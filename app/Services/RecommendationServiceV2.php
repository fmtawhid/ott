<?php
    namespace App\Services;

    use App\Models\User;
    use Modules\Entertainment\Models\Entertainment;
    use Modules\Entertainment\Models\EntertainmentGenerMapping;
    use Modules\Entertainment\Models\Like;
    use Modules\Entertainment\Models\EntertainmentView;
    use Modules\Entertainment\Models\Watchlist;
    use Modules\Entertainment\Transformers\WatchlistResource;
    use Modules\Entertainment\Models\EntertainmentTalentMapping;
    use Modules\World\Models\Country;
    use Modules\Genres\Models\Genres;
    use Modules\CastCrew\Models\CastCrew;
    use libphonenumber\PhoneNumberUtil;
    use libphonenumber\NumberParseException;
    use App\Models\UserWatchHistory;
    use Carbon\Carbon;

    class RecommendationServiceV2
    {
        /**
         * Get the most recent watch history of a user
         *
         * @param User $user
         * @param int $profileId
         * @return mixed
         */
        public function getRecentlyWatched($user, $profileId)
        {

            if($user){
                return UserWatchHistory::where('profile_id', $profileId)
                            ->where('user_id', $user->id)
                            ->where('entertainment_type', 'movie')
                            ->first();


            }
        }

        /**
         * Get the genre IDs associated with an entertainment ID
         *
         * @param int $entertainmentId
         * @return array
         */
        protected function getGenresByEntertainmentId($entertainmentId)
        {

            return EntertainmentGenerMapping::where('entertainment_id', $entertainmentId)
                                            ->pluck('genre_id')
                                            ->toArray();

        }
        public function recommendByLastHistory($user, $profileId)
        {
            $recentlyWatched = $this->getRecentlyWatched($user, $profileId);


            if (!$recentlyWatched) {
                return [];
            }

            $genres = $this->getGenresByEntertainmentId($recentlyWatched->entertainment_id);

            return Entertainment::whereIn('id', function($query) use ($genres) {
                    $query->select('entertainment_id')
                          ->from('entertainment_gener_mapping')
                          ->whereIn('genre_id', $genres);
                })
                ->where('id', '!=', $recentlyWatched->entertainment_id)
                ->where('type', 'movie')
                ->where('status',1)
               ->released()
                ->take(10)
                ->get();
        }

        public function getLikedMovies($user, $profileId)
        {
            // Get IDs of movies liked by the user for a specific profile
            $likedEntertainmentIds = Like::where([
                ['user_id', '=', $user->id],
                ['profile_id', '=', $profileId],
                ['is_like', '=', true]
            ])->pluck('entertainment_id');

            $mostLikedMovies = Like::where('is_like', true)
                ->whereNotIn('entertainment_id', $likedEntertainmentIds)
                ->select('entertainment_id')
                ->groupBy('entertainment_id')
                ->orderByRaw('COUNT(*) DESC')
                ->pluck('entertainment_id');

            $builder = Entertainment::selectRaw('entertainments.id,entertainments.name,entertainments.type,entertainments.plan_id,plan.level as plan_level,entertainments.description,entertainments.trailer_url_type,entertainments.is_restricted,entertainments.language,entertainments.imdb_rating,entertainments.content_rating, entertainments.duration,entertainments.video_upload_type,GROUP_CONCAT(egm.genre_id) as genres,DATE_FORMAT(`entertainments`.`release_date`,"%Y") as release_year, entertainments.trailer_url,entertainments.video_url_input,entertainments.poster_url as poster_url,entertainments.thumbnail_url as thumbnail_url,entertainments.poster_tv_url as poster_tv_url,entertainments.trailer_url as base_url,entertainments.movie_access,entertainments.price,entertainments.purchase_type,entertainments.access_duration,entertainments.discount,entertainments.available_for')
                ->join('entertainment_gener_mapping as egm','egm.entertainment_id','=','entertainments.id')
                ->leftJoin('plan','plan.id','=','entertainments.plan_id')
                // ->leftJoin('continue_watch as cw','cw.entertainment_id','=','entertainments.id')
                // ->leftJoin('watchlists as w','w.entertainment_id','=','entertainments.id')
                ->whereIn('entertainments.id', $mostLikedMovies)
                ->where('type', 'movie')
                ->where('entertainments.status', 1)
                ->where('entertainments.release_date', '<=', Carbon::now()->format('Y-m-d'));

            isset(request()->is_restricted) && $builder = $builder->where('is_restricted', request()->is_restricted);
            (!empty(getCurrentProfileSession('is_child_profile')) && getCurrentProfileSession('is_child_profile') != 0) &&
                $builder = $builder->where('is_restricted',0);

            $builder = $builder->orderByRaw('FIELD(entertainments.id, ' . $mostLikedMovies->implode(',') . ')') // Preserve the order of IDs
                    ->groupBy('entertainments.id')
                    ->limit(10)
                    ->get();

            return $builder;
        }

        public function getEntertainmentViews($user, $profileId)
        {

            $viewedEntertainmentIds = EntertainmentView::where([
                ['user_id', '=', $user->id],
                ['profile_id', '=', $profileId]
            ])->pluck('entertainment_id')->toArray();


            $mostViewedMovies = EntertainmentView::whereNotIn('entertainment_id', $viewedEntertainmentIds)
                ->select('entertainment_id')
                ->groupBy('entertainment_id')
                ->orderByRaw('COUNT(*) DESC')
                ->limit(10)
                ->pluck('entertainment_id');

            $builder = Entertainment::selectRaw('entertainments.id,entertainments.name,entertainments.type,entertainments.plan_id,plan.level as plan_level,entertainments.description,entertainments.trailer_url_type,entertainments.is_restricted,entertainments.language,entertainments.imdb_rating,entertainments.content_rating, entertainments.duration,entertainments.video_upload_type,GROUP_CONCAT(egm.genre_id) as genres,DATE_FORMAT(`entertainments`.`release_date`,"%Y") as release_year, entertainments.trailer_url,entertainments.video_url_input,entertainments.poster_url as poster_url,entertainments.thumbnail_url as thumbnail_url,entertainments.poster_tv_url as poster_tv_url,entertainments.trailer_url as base_url')
                ->join('entertainment_gener_mapping as egm','egm.entertainment_id','=','entertainments.id')
                ->leftJoin('plan','plan.id','=','entertainments.plan_id')
                // ->leftJoin('continue_watch as cw','cw.entertainment_id','=','entertainments.id')
                // ->leftJoin('watchlists as w','w.entertainment_id','=','entertainments.id')
                ->whereIn('entertainments.id', $mostViewedMovies)
                ->where('type', 'movie')
                ->where('entertainments.status', 1)
                ->where('entertainments.release_date', '<=', Carbon::now()->format('Y-m-d'));

                isset(request()->is_restricted) && $builder = $builder->where('is_restricted', request()->is_restricted);
                (!empty(getCurrentProfileSession('is_child_profile')) && getCurrentProfileSession('is_child_profile') != 0) &&
                    $builder = $builder->where('is_restricted',0);

            $builder = $builder->orderByRaw('FIELD(entertainments.id, ' . $mostViewedMovies->implode(',') . ')') // Preserve the order of IDs
                ->groupBy('entertainments.id')
                ->get();
            return $builder;
        }

    public function getUserWatchlist($user, $profileId)
    {
        $watchlist = Watchlist::where('user_id', $user->id)
                                ->where('profile_id', $profileId)
                                ->with('entertainment')
                                ->get();

        $watchlist= WatchlistResource::collection($watchlist);

        return $watchlist;
    }

    public function  getFavoriteGener($user, $profileId)
    {

        $entertainmentIds = $user->watchHistories()
        ->where('profile_id', $profileId)
        ->pluck('entertainment_id')
        ->merge(
            Like::where('profile_id', $profileId)
                ->where('user_id', $user->id)
                ->where('is_like', true)
                ->pluck('entertainment_id')
        )
        ->unique();

        return EntertainmentGenerMapping::join('genres',function($q)
            {
                $q->on('genres.id','=','entertainment_gener_mapping.genre_id');
            })
            ->whereIn('entertainment_gener_mapping.entertainment_id', $entertainmentIds)
            ->where('genres.status',1)
            ->take(10)->inRandomOrder()
            ->groupBy('genres.id')
            ->pluck('genres.id');

        // return Genres::whereIn('id', $genreIds)->where('status',1)->take(10)->inRandomOrder()->get();

}

public function  getFavoritePersonality($user, $profileId)
{
    $entertainmentIds = $user->watchHistories()
    ->where('profile_id', $profileId)
    ->pluck('entertainment_id')
    ->merge(
        Like::where('profile_id', $profileId)
            ->where('user_id', $user->id)
            ->where('is_like', true)
            ->pluck('entertainment_id')
    )
    ->unique();


    return EntertainmentTalentMapping::join('cast_crew',function($q)
            {
                $q->on('cast_crew.id','=','entertainment_talent_mapping.talent_id');
            })
            ->whereIn('entertainment_talent_mapping.entertainment_id', $entertainmentIds)
            ->take(10)->inRandomOrder()
            ->groupBy('cast_crew.id')
            ->pluck('cast_crew.id');

        // $talent_id = EntertainmentTalentMapping::whereIn('entertainment_id', $entertainmentIds)
        //     ->distinct()
        //     ->pluck('talent_id');

        // return CastCrew::whereIn('id',$talent_id)->take(10)->inRandomOrder()->get();

}

public function getTrendingMoviesByCountry($user)
{
    $mobile = $user->mobile;

    $dialCode = null;


    if(!empty($mobile)) {

        try {

            $phoneUtil = PhoneNumberUtil::getInstance();

            $numberProto = $phoneUtil->parse($mobile, null);

            $dialCode = $numberProto->getCountryCode();

        }catch (\libphonenumber\NumberParseException $e) {
            // If region error occurs, set $dialCode to null
            $dialCode = null;
        }

    }
    $countryId = $dialCode ? Country::where('dial_code', $dialCode)->pluck('id')->toArray() : null;


    if (!$countryId) {
        return collect();
    }

    $builder = Entertainment::selectRaw('entertainments.id,entertainments.name,entertainments.type,entertainments.plan_id,plan.level as plan_level,entertainments.description,entertainments.trailer_url_type,entertainments.is_restricted,entertainments.language,entertainments.imdb_rating,entertainments.content_rating, entertainments.duration,entertainments.video_upload_type,GROUP_CONCAT(egm.genre_id) as genres,DATE_FORMAT(`entertainments`.`release_date`,"%Y") as release_year, entertainments.trailer_url,entertainments.video_url_input,entertainments.poster_url as poster_url,entertainments.thumbnail_url as thumbnail_url,entertainments.poster_tv_url as poster_tv_url,entertainments.trailer_url as base_url')
            ->join('entertainment_gener_mapping as egm','egm.entertainment_id','=','entertainments.id')
            ->leftJoin('plan','plan.id','=','entertainments.plan_id')
            ->Join('entertainment_country_mapping as ecm','ecm.entertainment_id','=','entertainments.id')
            // ->leftJoin('continue_watch as cw','cw.entertainment_id','=','entertainments.id')
            // ->leftJoin('watchlists as w','w.entertainment_id','=','entertainments.id')
            ->whereIn('entertainment_country_mapping.country_id', $countryId)
            ->withCount('entertainmentReviews')
            ->whereIn('entertainments.type', 'movie')
            ->where('entertainments.status', 1)
            ->where('entertainments.release_date', '<=', Carbon::now()->format('Y-m-d'));

            isset(request()->is_restricted) && $builder = $builder->where('is_restricted', request()->is_restricted);
            (!empty(getCurrentProfileSession('is_child_profile')) && getCurrentProfileSession('is_child_profile') != 0) &&
                $builder = $builder->where('is_restricted',0);

        $builder = $builder->orderBy('entertainment_reviews_count', 'desc')
            ->groupBy('entertainments.id')
            ->take(10)
            ->get();

        return $builder;

    // Entertainment::whereHas('entertainmentCountryMappings', function ($query) use ($countryId) {
    //         $query->whereIn('country_id', $countryId);
    //     })
    //     ->withCount('entertainmentReviews')
    //     ->where('type', 'movie')
    //     ->where('status', 1)
    //     ->whereDate('release_date', '<=', Carbon::now())
    //     ->orderBy('entertainment_reviews_count', 'desc')
    //     ->take(10)
    //     ->get();
     }

 }
