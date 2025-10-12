<?php

namespace Modules\User\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Entertainment\Transformers\WatchlistResource;
use Modules\Entertainment\Transformers\ContinueWatchResource;
use Modules\Entertainment\Transformers\ContinueWatchResourceV2;
use Modules\Entertainment\Transformers\WatchlistResourceNew;

class UserProfileResourceV2 extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request)
    {

        $continueWatch = $this->continueWatchnew;
        $watchlist = $this->watchList;

        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => $this->first_name.' '.$this->last_name,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'gender' => $this->gender,
            'date_of_birth' => $this->date_of_birth,
            'login_type' => $this->login_type,
            'email_verified_at' => $this->email_verified_at,
            'is_banned' => $this->is_banned,
            'is_subscribe' => $this->is_subscribe,
            'status' => $this->status,
            'last_notification_seen' => $this->last_notification_seen,
            'is_user_exist' => true,
            'profile_image' => setBaseUrlWithFileName($this->file_url),
            'media' => $this->media,
            'plan_details' => $this->plan_details ?? null,
            'watchlists' => WatchlistResource::collection($watchlist),
            'continue_watch' => ContinueWatchResourceV2::collection($continueWatch),
        ];
    }
}
