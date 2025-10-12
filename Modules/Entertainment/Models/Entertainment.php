<?php

namespace Modules\Entertainment\Models;

use App\Models\BaseModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Modules\Subscriptions\Models\Plan;
use Modules\Season\Models\Season;
use Modules\Episode\Models\Episode;
use Modules\Genres\Models\Genres;
use App\Models\Scopes\EntertainmentScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;

use Modules\Frontend\Models\PayPerView;

class Entertainment extends BaseModel
{

    use SoftDeletes;

    protected $table = 'entertainments';
    protected $genres;
    public function __construct()
    {
        $responseData = Cache::get('genres_v2');
        if(empty($responseData))
        {
            $responseData = Genres::get()->keyBy('id')->toArray();
            Cache::put('genres_v2', $responseData);
        }else{
            $this->genres = Cache::get('genres_v2');
        }
    }

    protected $fillable = [
    'name',
    'tmdb_id',
    'description',
    'trailer_url_type',
    'trailer_url',
    'poster_url',
    'thumbnail_url',
    'movie_access',
    'type', // movie,tv_show
    'plan_id',
    'status',
    'language',
    'IMDb_rating',
    'content_rating',
    'duration',
    'release_date',
    'is_restricted',
    'video_upload_type',
    'enable_quality',
    'video_url_input',
    'download_status',
    'download_type',
    'download_url',
    'enable_download_quality',
    'video_quality_url',
    'poster_tv_url',
    'price',
    'purchase_type',
    'access_duration',
    'discount',
    'available_for',
    'enable_subtitle',
    'meta_title', // Add SEO fields
    'meta_keywords', // Add SEO fields
    'meta_description', // Add SEO fields
    'seo_image', // Add SEO fields
    'google_site_verification', // Add SEO fields
    'canonical_url', // Add SEO fields
    'short_description', // Add SEO fields
];


      protected $casts = [
        'price' => 'integer',
        'plan_id' => 'integer',
        'discount' => 'integer',
    ];



    public function scopeReleased($query)
      {
          return $query->where(function ($q) {
              $q->whereDate('release_date', '<=', now())
                ->orWhereNull('release_date');
          });
      }



    public function getGenresAttribute($value)
    {
        return !empty($value) ? self::genres($value) : NULL;
    }

    public function getBaseUrlAttribute($value)
    {
        return !empty($value) ? setBaseUrlWithFileNameV2() : NULL;
    }

    // public function getPosterImageAttribute($value)
    // {
    //     return  !empty($value) ? setBaseUrlWithFileName($value) : NULL;
    // }

    private function genres($value)
    {
        $result = [];

        if (is_array($value)) {
            foreach ($value as $v) {
                if (isset($this->genres[$v])) {
                    $result[] = $this->genres[$v];
                }
            }
        }

        return $result;
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        //static::addGlobalScope(new EntertainmentScope);
    }

    public function entertainmentGenerMappings()
    {
        return $this->hasMany(EntertainmentGenerMapping::class,'entertainment_id','id')->with('genre');
    }
    public function entertainmentCountryMappings()
    {
        return $this->hasMany(EntertainmentCountryMapping::class,'entertainment_id','id')->with('country');
    }

    public function entertainmentStreamContentMappings()
    {
        return $this->hasMany(EntertainmentStreamContentMapping::class,'entertainment_id','id');
    }

    public function entertainmentDownloadMappings()
    {
        return $this->hasMany(EntertainmnetDownloadMapping::class,'entertainment_id','id');
    }


    public function EntertainmentDownload()
    {
        return $this->hasMany(EntertainmentDownload::class,'entertainment_id','id');
    }


    public function entertainmentTalentMappings()
    {
        return $this->hasMany(EntertainmentTalentMapping::class,'entertainment_id','id')->with('talentprofile');
    }

    public function plan()
    {
        return $this->hasOne(Plan::class, 'id', 'plan_id');
    }

    public function entertainmentReviews()
    {
        return $this->hasMany(Review::class,'entertainment_id','id');
    }

    public function entertainmentLike()
    {
        return $this->hasMany(Like::class,'entertainment_id','id');
    }

    public function entertainmentView()
    {
        return $this->hasMany(EntertainmentView::class, 'entertainment_id', 'id');
    }

    public function UserReminder()
    {
        return $this->hasMany(UserReminder::class,'entertainment_id','id');
    }

    public function UserRemind()
    {
        return $this->hasOne(UserReminder::class,'entertainment_id','id');
    }

    public function Watchlist()
    {
        return $this->hasMany(Watchlist::class,'entertainment_id','id');
    }


    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($entertainment) {

            if ($entertainment->isForceDeleting()) {

                $entertainment->entertainmentGenerMappings()->forceDelete();
                $entertainment->entertainmentStreamContentMappings()->forceDelete();
                $entertainment->entertainmentTalentMappings()->forceDelete();
                $entertainment->entertainmentReviews()->forceDelete();
                $entertainment->entertainmentDownloadMappings()->forceDelete();
                $entertainment->EntertainmentDownload()->forceDelete();
                $entertainment->entertainmentLike()->forceDelete();
                $entertainment->UserReminder()->forceDelete();
                $entertainment->Watchlist()->forceDelete();


            } else {

                $entertainment->entertainmentGenerMappings()->delete();
                $entertainment->entertainmentStreamContentMappings()->delete();
                $entertainment->entertainmentTalentMappings()->delete();
                $entertainment->entertainmentReviews()->delete();
                $entertainment->entertainmentDownloadMappings()->delete();
                $entertainment->EntertainmentDownload()->delete();
                $entertainment->entertainmentLike()->delete();
                $entertainment->UserReminder()->delete();
                $entertainment->Watchlist()->delete();

            }

        });

        static::restoring(function ($entertainment) {

            $entertainment->entertainmentGenerMappings()->withTrashed()->restore();
            $entertainment->entertainmentStreamContentMappings()->withTrashed()->restore();
            $entertainment->entertainmentTalentMappings()->withTrashed()->restore();
            $entertainment->entertainmentReviews()->withTrashed()->restore();
            $entertainment->entertainmentDownloadMappings()->withTrashed()->restore();
            $entertainment->EntertainmentDownload()->withTrashed()->restore();
            $entertainment->entertainmentLike()->withTrashed()->restore();
            $entertainment->UserReminder()->withTrashed()->restore();
            $entertainment->Watchlist()->withTrashed()->restore();
        });
    }

    public function season()
    {
        return $this->hasMany(Season::class, 'entertainment_id')->with('plan', 'episodes');
    }

    public function episodeV2()
    {
        return $this->hasMany(Episode::class,'entertainment_id');
    }


    public function episode()
    {
        return $this->hasMany(Episode::class,'entertainment_id')->with('plan','EpisodeStreamContentMapping');
    }

 public static function get_latest_movie($latestMovieIdsArray)
    {
        $builder = Entertainment::selectRaw('entertainments.id,entertainments.name,entertainments.type,entertainments.trailer_url as trailer_url,entertainments.plan_id,plan.level as plan_level,entertainments.description,entertainments.trailer_url_type,entertainments.is_restricted,entertainments.language,entertainments.imdb_rating,entertainments.content_rating, entertainments.duration,entertainments.video_upload_type,GROUP_CONCAT(egm.genre_id) as genres,DATE_FORMAT(`entertainments`.`release_date`,"%Y") as release_year, entertainments.poster_url as poster_url,entertainments.thumbnail_url as thumbnail_url,entertainments.poster_tv_url as poster_tv_url,entertainments.trailer_url as base_url,entertainments.video_url_input as video_url_input,entertainments.movie_access,entertainments.price,entertainments.purchase_type,entertainments.access_duration,entertainments.discount,entertainments.available_for,(select watched_time from  continue_watch where continue_watch.entertainment_id = entertainments.id and profile_id = '.getRequestedProfileId().' AND user_id = '.loggedUserId().' LIMIT 1) as watched_time, (CASE WHEN (select id from  watchlists where watchlists.entertainment_id = entertainments.id and user_id = '.loggedUserId().' LIMIT 1) THEN 1 ELSE 0 END) AS is_watch_list')
        ->join('entertainment_gener_mapping as egm','egm.entertainment_id','=','entertainments.id')
        ->leftJoin('plan','plan.id','=','entertainments.plan_id')
        ->whereIn('entertainments.id', $latestMovieIdsArray)
       ->where('entertainments.status', 1);

       isset(request()->is_restricted) && $builder = $builder->where('is_restricted', request()->is_restricted);
       (!empty(getCurrentProfileSession('is_child_profile')) && getCurrentProfileSession('is_child_profile') != 0) &&
           $builder = $builder->where('is_restricted',0);

        $builder = $builder->where('entertainments.release_date', '<=', Carbon::now()->format('Y-m-d'))
       ->groupBy('entertainments.id')
       ->get();
       return $builder;
    }



    public static function get_popular_movie($popularMovieIdsArray)
    {
        $builder = Entertainment::selectRaw('entertainments.id,entertainments.name,entertainments.type,entertainments.plan_id,plan.level as plan_level,entertainments.description,entertainments.trailer_url_type,entertainments.is_restricted,entertainments.language,entertainments.imdb_rating,entertainments.content_rating, entertainments.duration,entertainments.video_upload_type,GROUP_CONCAT(egm.genre_id) as genres,DATE_FORMAT(`entertainments`.`release_date`, "%Y") as release_year, entertainments.trailer_url,entertainments.video_url_input,entertainments.poster_url as poster_url,entertainments.thumbnail_url as thumbnail_url,entertainments.poster_tv_url as poster_tv_url,entertainments.trailer_url as base_url,entertainments.movie_access,entertainments.price,entertainments.purchase_type,entertainments.access_duration,entertainments.discount,entertainments.available_for,(select watched_time from  continue_watch where continue_watch.entertainment_id = entertainments.id and profile_id = '.getRequestedProfileId().' AND user_id = '.loggedUserId().' LIMIT 1) as watched_time, (CASE WHEN (select id from  watchlists where watchlists.entertainment_id = entertainments.id and user_id = '.loggedUserId().' LIMIT 1) THEN 1 ELSE 0 END) AS is_watch_list')
            ->join('entertainment_gener_mapping as egm','egm.entertainment_id','=','entertainments.id')
            ->leftJoin('plan','plan.id','=','entertainments.plan_id')
            ->whereIn('entertainments.id', $popularMovieIdsArray)
            ->where('entertainments.status', 1);

        isset(request()->is_restricted) && $builder = $builder->where('is_restricted', request()->is_restricted);
       (!empty(getCurrentProfileSession('is_child_profile')) && getCurrentProfileSession('is_child_profile') != 0) &&
           $builder = $builder->where('is_restricted',0);

           $builder = $builder->where('entertainments.release_date', '<=', Carbon::now()->format('Y-m-d'))
            ->groupBy('entertainments.id')
            ->get();

            return $builder;
    }

    public static function get_free_movie($movieIdsArray)
    {
        $builder = Entertainment::selectRaw('entertainments.id,entertainments.name,entertainments.type,entertainments.plan_id,plan.level as plan_level,entertainments.description,entertainments.trailer_url_type,entertainments.is_restricted,entertainments.language,entertainments.imdb_rating,entertainments.content_rating, entertainments.duration,entertainments.video_upload_type,GROUP_CONCAT(egm.genre_id) as genres,DATE_FORMAT(`entertainments`.`release_date`, "%Y") as release_year, entertainments.trailer_url,entertainments.video_url_input,entertainments.poster_url as poster_url,entertainments.thumbnail_url as thumbnail_url,entertainments.poster_tv_url as poster_tv_url,entertainments.trailer_url as base_url,entertainments.movie_access,(select watched_time from  continue_watch where continue_watch.entertainment_id = entertainments.id and profile_id = '.getRequestedProfileId().' AND user_id = '.loggedUserId().' LIMIT 1) as watched_time, (CASE WHEN (select id from  watchlists where watchlists.entertainment_id = entertainments.id and user_id = '.loggedUserId().' LIMIT 1) THEN 1 ELSE 0 END) AS is_watch_list')
                ->join('entertainment_gener_mapping as egm','egm.entertainment_id','=','entertainments.id')
                ->leftJoin('plan','plan.id','=','entertainments.plan_id')
                ->whereIn('entertainments.id', $movieIdsArray)
                ->where('entertainments.status', 1);

        isset(request()->is_restricted) && $builder = $builder->where('is_restricted', request()->is_restricted);
        (!empty(getCurrentProfileSession('is_child_profile')) && getCurrentProfileSession('is_child_profile') != 0) &&
            $builder = $builder->where('is_restricted',0);

                $builder = $builder->where('entertainments.release_date', '<=', Carbon::now()->format('Y-m-d'))
                 ->where('entertainments.status', 1)
                 ->where('entertainments.movie_access','free')
                ->groupBy('entertainments.id')
                ->get();

        return $builder;
    }


    public static function get_popular_tvshow($popular_tvshowIdsArray)
    {
        $builder = Entertainment::selectRaw('entertainments.id,entertainments.name,entertainments.type,entertainments.plan_id,plan.level as plan_level,entertainments.description,entertainments.trailer_url_type,entertainments.is_restricted,entertainments.language,entertainments.imdb_rating,entertainments.content_rating, entertainments.duration,entertainments.video_upload_type,GROUP_CONCAT(egm.genre_id) as genres,DATE_FORMAT(`entertainments`.`release_date`, "%Y") as release_year, entertainments.trailer_url,entertainments.video_url_input,entertainments.poster_url as poster_url,entertainments.thumbnail_url as thumbnail_url,entertainments.poster_tv_url as poster_tv_url,entertainments.trailer_url as base_url,entertainments.movie_access,entertainments.movie_access,entertainments.price,entertainments.purchase_type,entertainments.access_duration,entertainments.discount,entertainments.available_for,(select watched_time from  continue_watch where continue_watch.entertainment_id = entertainments.id and profile_id = '.getRequestedProfileId().' AND user_id = '.loggedUserId().' LIMIT 1) as watched_time, (CASE WHEN (select id from  watchlists where watchlists.entertainment_id = entertainments.id and user_id = '.loggedUserId().' LIMIT 1) THEN 1 ELSE 0 END) AS is_watch_list')
            ->join('entertainment_gener_mapping as egm','egm.entertainment_id','=','entertainments.id')
            ->leftJoin('plan','plan.id','=','entertainments.plan_id')
            ->whereIn('entertainments.id', $popular_tvshowIdsArray)
            ->where('entertainments.status', 1);

        isset(request()->is_restricted) && $builder = $builder->where('is_restricted', request()->is_restricted);
        (!empty(getCurrentProfileSession('is_child_profile')) && getCurrentProfileSession('is_child_profile') != 0) &&
            $builder = $builder->where('is_restricted',0);

            $builder = $builder->groupBy('entertainments.id')
            ->get();

        return $builder;
    }


    public static function get_entertainment_list()
    {
        $builder = Entertainment::selectRaw('entertainments.id,entertainments.name,entertainments.type,entertainments.plan_id,plan.level as plan_level,entertainments.description,entertainments.trailer_url_type,entertainments.is_restricted,entertainments.language,entertainments.imdb_rating,entertainments.content_rating, entertainments.duration,entertainments.video_upload_type,GROUP_CONCAT(egm.genre_id) as genres,DATE_FORMAT(`entertainments`.`release_date`, "%Y") as release_year, entertainments.trailer_url,entertainments.video_url_input,entertainments.poster_url as poster_url,entertainments.thumbnail_url as thumbnail_url,entertainments.poster_tv_url as poster_tv_url,entertainments.trailer_url as base_url,entertainments.movie_access,entertainments.price,entertainments.purchase_type,entertainments.access_duration,entertainments.discount,entertainments.available_for,(select watched_time from  continue_watch where continue_watch.entertainment_id = entertainments.id and profile_id = '.getRequestedProfileId().' AND user_id = '.loggedUserId().' LIMIT 1) as watched_time, (CASE WHEN (select id from  watchlists where watchlists.entertainment_id = entertainments.id and user_id = '.loggedUserId().' LIMIT 1) THEN 1 ELSE 0 END) AS is_watch_list')
            ->join('entertainment_gener_mapping as egm','egm.entertainment_id','=','entertainments.id')
            ->leftJoin('plan','plan.id','=','entertainments.plan_id')
            ->with([
                'entertainmentReviews' => function ($query) {
                    $query->whereBetween('rating', [4, 5])->take(6);
                }
            ])
            ->where('entertainments.status', 1)
            ->where('entertainments.type', 'movie')
            ->where('release_date', '<=', Carbon::now()->format('Y-m-d'));

        isset(request()->is_restricted) && $builder = $builder->where('is_restricted', request()->is_restricted);
        (!empty(getCurrentProfileSession('is_child_profile')) && getCurrentProfileSession('is_child_profile') != 0) &&
            $builder = $builder->where('is_restricted',0);

        $builder = $builder->groupBy('entertainments.id')
            ->get();

        return $builder;
    }


    public static function get_top_movie($topMovieIds)
    {
        $builder = Entertainment::selectRaw('entertainments.id,entertainments.name,entertainments.type,entertainments.plan_id,plan.level as plan_level,entertainments.description,entertainments.trailer_url_type,entertainments.is_restricted,entertainments.language,entertainments.movie_access,entertainments.price,entertainments.purchase_type,entertainments.access_duration,entertainments.discount,entertainments.available_for,entertainments.imdb_rating,entertainments.content_rating, entertainments.duration,entertainments.video_upload_type,GROUP_CONCAT(egm.genre_id) as genres,DATE_FORMAT(`entertainments`.`release_date`, "%Y") as release_year, entertainments.trailer_url,entertainments.video_url_input,entertainments.poster_url as poster_url,entertainments.thumbnail_url as thumbnail_url,entertainments.poster_tv_url as poster_tv_url,entertainments.trailer_url as base_url,entertainments.movie_access,(select watched_time from  continue_watch where continue_watch.entertainment_id = entertainments.id and profile_id = '.getRequestedProfileId().' AND user_id = '.loggedUserId().' LIMIT 1) as watched_time, (CASE WHEN (select id from  watchlists where watchlists.entertainment_id = entertainments.id and user_id = '.loggedUserId().' LIMIT 1) THEN 1 ELSE 0 END) AS is_watch_list')
                ->leftJoin('entertainment_gener_mapping as egm','egm.entertainment_id','=','entertainments.id')
                ->leftJoin('plan','plan.id','=','entertainments.plan_id')
                ->whereIn('entertainments.id', $topMovieIds)
                ->where('entertainments.status', 1)
                ->where('entertainments.release_date', '<=', Carbon::now()->format('Y-m-d'));

        isset(request()->is_restricted) && $builder = $builder->where('is_restricted', request()->is_restricted);
        (!empty(getCurrentProfileSession('is_child_profile')) && getCurrentProfileSession('is_child_profile') != 0) &&
            $builder = $builder->where('is_restricted',0);

        $builder = $builder->groupBy('entertainments.id')
                ->get();
        return $builder;
    }

    public static function get_more_items($episodeId,$genre_ids)
    {
        $builder = Entertainment::selectRaw('entertainments.id,entertainments.name,entertainments.type,entertainments.plan_id,plan.level as plan_level,entertainments.description,entertainments.trailer_url_type,entertainments.is_restricted,entertainments.language,entertainments.imdb_rating,entertainments.content_rating, entertainments.duration,entertainments.video_upload_type,GROUP_CONCAT(egm.genre_id) as genres,DATE_FORMAT(`entertainments`.`release_date`, "%Y") as release_year, entertainments.trailer_url,entertainments.video_url_input,entertainments.poster_url as poster_url,entertainments.thumbnail_url as thumbnail_url,entertainments.poster_tv_url as poster_tv_url,entertainments.trailer_url as base_url,entertainments.movie_access,(select watched_time from  continue_watch where continue_watch.entertainment_id = entertainments.id and profile_id = '.getRequestedProfileId().' AND user_id = '.loggedUserId().' LIMIT 1) as watched_time, (CASE WHEN (select id from  watchlists where watchlists.entertainment_id = entertainments.id and user_id = '.loggedUserId().' LIMIT 1) THEN 1 ELSE 0 END) AS is_watch_list')
                ->join('entertainment_gener_mapping as egm','egm.entertainment_id','=','entertainments.id')
                ->leftJoin('plan','plan.id','=','entertainments.plan_id')
                ->where('type', 'tvshow')
                ->where('entertainments.id', '!=', $episodeId)
                ->whereIn('egm.genre_id', $genre_ids);

        isset(request()->is_restricted) && $builder = $builder->where('is_restricted', request()->is_restricted);
        (!empty(getCurrentProfileSession('is_child_profile')) && getCurrentProfileSession('is_child_profile') != 0) &&
            $builder = $builder->where('is_restricted',0);

        $builder = $builder->orderBy('entertainments.id', 'desc')
                ->groupBy('entertainments.id')
                ->get();

        return $builder;
    }

    public static function get_first_tvshow($tvshow_id,$user_id,$profile_id)
    {
        $builder = Entertainment::selectRaw('entertainments.id,entertainments.name,entertainments.description,entertainments.type,entertainments.trailer_url_type,entertainments.plan_id,plan.level as plan_level,entertainments.movie_access,entertainments.price,entertainments.purchase_type,entertainments.access_duration,entertainments.discount,entertainments.available_for,entertainments.language,entertainments.imdb_rating,entertainments.content_rating,entertainments.duration,`entertainments`.`release_date`,DATE_FORMAT(`entertainments`.`release_date`, "%Y") as release_year,entertainments.is_restricted,entertainments.video_upload_type,entertainments.video_url_input,entertainments.enable_quality,entertainments.download_url,entertainments.poster_url as poster_image,entertainments.thumbnail_url as thumbnail_image,GROUP_CONCAT(egm.genre_id) as genre_ids,GROUP_CONCAT(egm.genre_id) as genres,entertainments.trailer_url,entertainments.trailer_url as base_url,entertainments.status,entertainments.created_by,entertainments.updated_by,entertainments.deleted_by,entertainments.created_at,entertainments.updated_at,entertainments.deleted_at,(CASE WHEN (select id from `watchlists` where `entertainment_id` = '.$tvshow_id.' and `user_id` = '.$user_id.' and `profile_id` = '.$profile_id.' and `watchlists`.`deleted_at` is null LIMIT 1) THEN 1 ELSE 0 END) AS is_watch_list,(CASE WHEN (select id from `likes` where `entertainment_id` = '.$tvshow_id.' and `user_id` = '.$user_id.' and `profile_id` = '.$profile_id.' and is_like = 1  and `likes`.`deleted_at` is null LIMIT 1) THEN 1 ELSE 0 END) AS is_likes')
                ->join('entertainment_gener_mapping as egm','egm.entertainment_id','=','entertainments.id')
                ->leftJoin('plan','plan.id','=','entertainments.plan_id')
                ->where('entertainments.id', $tvshow_id);

        isset(request()->is_restricted) && $builder = $builder->where('is_restricted', request()->is_restricted);
        (!empty(getCurrentProfileSession('is_child_profile')) && getCurrentProfileSession('is_child_profile') != 0) &&
            $builder = $builder->where('is_restricted',0);

        return $builder;
    }


    public static function get_movie($movieId,$user_id,$profile_id,$device_id)
    {
        $builder = Entertainment::selectRaw('entertainments.id,entertainments.name,entertainments.enable_quality,entertainments.download_status,entertainments.download_type,entertainments.download_url,entertainments.enable_download_quality,entertainments.movie_access,entertainments.price,entertainments.purchase_type,entertainments.access_duration,entertainments.discount,entertainments.available_for,entertainments.status,entertainments.enable_subtitle,(CASE WHEN (select id from `watchlists` where `entertainment_id` = '.$movieId.' and `user_id` = '.$user_id.' and `profile_id` = '.$profile_id.' and `watchlists`.`deleted_at` is null LIMIT 1) THEN 1 ELSE 0 END) AS is_watch_list,(CASE WHEN (select id from `likes` where `entertainment_id` = '.$movieId.' and `user_id` = '.$user_id.' and `profile_id` = '.$profile_id.' and is_like = 1  and `likes`.`deleted_at` is null LIMIT 1) THEN 1 ELSE 0 END) AS is_likes,(CASE WHEN (select id from `entertainment_downloads` where `entertainment_id` = '.$movieId.' and `device_id` = "'.$device_id.'" and `user_id` = '.$user_id.' and entertainment_type = "movie" and is_download = 1  and entertainment_downloads.`deleted_at` is null LIMIT 1) THEN 1 ELSE 0 END) AS is_download,reviews.id as your_review_id,reviews.review as your_review,reviews.rating as your_review_rating,reviews.updated_at as your_review_updated_at,reviews.created_at as your_review_created_at,reviews.user_id as your_review_user_id,users.first_name as your_review_first_name,users.last_name as your_review_last_name,users.file_url as your_review_file_url,GROUP_CONCAT(egm.genre_id) as genre_ids')
        ->join('entertainment_gener_mapping as egm','egm.entertainment_id','=','entertainments.id')
        ->leftJoin('reviews', function($q) use ($user_id) {
            $q->on('reviews.entertainment_id', '=', 'entertainments.id')
              ->where('reviews.user_id', $user_id)
              ->whereNull('reviews.deleted_at');
        })
        ->leftJoin('subtitles', function($q) use ($movieId) {
            $q->on('subtitles.entertainment_id', '=', 'entertainments.id')
              ->where('subtitles.type', 'movie')
              ->where('subtitles.entertainment_id', $movieId);
        })
        ->leftJoin('users','reviews.user_id','=','users.id')
        ->where('entertainments.id', $movieId);

        isset(request()->is_restricted) && $builder = $builder->where('is_restricted', request()->is_restricted);
        (!empty(getCurrentProfileSession('is_child_profile')) && getCurrentProfileSession('is_child_profile') != 0) &&
            $builder = $builder->where('is_restricted',0);

        return $builder;
    }

    public static function isPurchased($movieId,$type=null, $userId = null)
    {
        $userId = $userId ?? auth()->id();

        if (!$userId || !$movieId) return false;

        return PayPerView::where('user_id', $userId)
            ->where('movie_id', $movieId)
            ->where('type', $type)
            ->where(function ($query) {
                $query->whereNull('view_expiry_date')
                    ->orWhere('view_expiry_date', '>', now());
            })
            ->where(function ($query) {
                $query->whereNull('first_play_date')
                    ->orWhereRaw('DATE_ADD(first_play_date, INTERVAL access_duration DAY) > ?', [now()]);
            })
            ->exists();
    }


   public function entertainmentSubtitleMappings()
   {

       return $this->hasMany(Subtitle::class, 'entertainment_id', 'id');
   }

    public function subtitles()
    {
        return $this->entertainmentSubtitleMappings();
    }

}
