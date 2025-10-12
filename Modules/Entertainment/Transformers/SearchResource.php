<?php

namespace Modules\Entertainment\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Entertainment\Transformers\MoviesResource;

class SearchResource extends JsonResource
{

    public function toArray($request) 
    {
        $popularMovies = $this->where('IMDb_rating', '>=', 5);
         
        return [
            'popular_movies' => MoviesResource::collection($popularMovies->take(5)),
            'trending_movies' => MoviesResource::collection($this->take(5)),
        ];
    }
}
