<?php

namespace Modules\User\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class UserSearchHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'profile_id' => $this->profile_id,
            'search_query' => $this->search_query,
            'type' => $this->type,
            'search_id'=>$this->search_id,
            'file_url' => isset($this->type)
                        ? ($this->type == 'movie' || $this->type == 'tvshow'
                           ? setBaseUrlWithFileName(optional($this->entertainment)->poster_url)
                             : ($this->type == 'episode'
                            ? setBaseUrlWithFileName(optional($this->episode)->poster_url)
                               : ($this->type == 'video'
                                ? setBaseUrlWithFileName(optional($this->video)->poster_url)
                                 : ($this->type == 'castcrew'
                                   ? setBaseUrlWithFileName(optional($this->castcrew)->file_url)
                                         : null)))) : null,

        ];
    }
}
