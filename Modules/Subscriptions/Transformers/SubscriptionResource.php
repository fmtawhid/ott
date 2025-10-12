<?php

namespace Modules\Subscriptions\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {

        $discount = 0;

        $discount = ($this->amount / 100) * $this->discount_percentage;


        return array_merge(parent::toArray($request), [
            'discount_amount' =>  $discount , // Add your custom key-value pair here
        ]);
    }
}
