<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SocialLoginResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'login_type' => $this->login_type,
            'gender' => $this->gender,
            'date_of_birth' => $this->date_of_birth,
            'email_verified_at' => $this->email_verified_at,
            'is_banned' => $this->is_banned,
            'is_subscribe' => $this->is_subscribe,
            'status' => $this->status,
            'pin' => $this->pin,
            'otp' => $this->otp,
            'last_notification_seen' => $this->last_notification_seen,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'api_token' => $this->api_token,
            'full_name' => $this->full_name,
            'is_user_exist' => true,
            'profile_image' => setBaseUrlWithFileName($this->file_url),
            'media' => $this->media,
            'plan_details' => $this->plan_details ?? null,
        ];
    }
}
