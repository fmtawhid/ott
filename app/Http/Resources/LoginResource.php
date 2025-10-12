<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $planDetails = $this->plan_details;
        if($planDetails){
            $planDetails->plan_type = json_decode($planDetails->plan_type);
        }

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
            'last_notification_seen' => $this->last_notification_seen,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'api_token' => $this->api_token,
            'full_name' => $this->full_name,
            'pin' => $this->pin ?? "",
            'otp' => $this->otp,
            'is_user_exist' => true,
            'profile_image' => $this->media->pluck('original_url')->first(),
            'media' => $this->media,
            'plan_details' => $planDetails ?? null,
            'session_id' => $this->session_id,
        ];
    }
}
