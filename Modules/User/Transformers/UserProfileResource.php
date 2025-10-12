<?php

namespace Modules\User\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Entertainment\Transformers\WatchlistResource;
use Modules\Entertainment\Transformers\ContinueWatchResource;
use Modules\Entertainment\Models\ContinueWatch;
use Modules\Entertainment\Models\Watchlist;

class UserProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request)
    {
        $continueWatch = ContinueWatch::where('user_id', $this->id)->where('profile_id', $request->profile_id)->get();
        $watchlist = Watchlist::where('user_id', $this->id)->where('profile_id', $request->profile_id)->get();

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
            'pin' => $this->pin,
            'otp' => $this->otp,
            'last_notification_seen' => $this->last_notification_seen,
            'is_user_exist' => true,
            'profile_image' => setBaseUrlWithFileName($this->file_url),
            'media' => $this->media,
            'plan_details' => $this->plan_details ?? null,
            'watchlists' => WatchlistResource::collection($watchlist),
            'continue_watch' => ContinueWatchResource::collection($continueWatch),
        ];
    }
}
