<?php

namespace Modules\Page\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id'   => $this->id,
            'slug' => $this->slug,
            'name' => $this->name,
            'url'  => route('backend.copyurl', ['slug' =>  $this->slug])
        ];
    }
}
