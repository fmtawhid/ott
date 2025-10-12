<?php

namespace Modules\Entertainment\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Genres\Transformers\GenresResource;
use Modules\Season\Models\Season;
use Modules\Entertainment\Models\UserReminder;
use Auth;

class ComingSoonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request)
    {
        $genre_data = [];
        $genres = $this->entertainmentGenerMappings;
        foreach($genres as $genre){
            $genre_data[] = $genre->genre;
        }

        $user_id=Auth::id();

        $profile_id=$request->has('profile_id') && $request->profile_id
        ? $request->profile_id
        : getCurrentProfile($user_id, $request);



        $season = Season::where('entertainment_id', $this->id)->latest()->first();
        $is_reminder = UserReminder::where('entertainment_id',$this->id)->where('profile_id',$profile_id)->first();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => strip_tags($this->description),
            'trailer_url_type' => $this->trailer_url_type,
            'episode_id' => $entertainment->id ?? null,
            'type' => $this->type,
            'trailer_url' => $this->trailer_url_type=='Local' ? setBaseUrlWithFileName($this->trailer_url) : $this->trailer_url,
            'language' => $this->language,
            'imdb_rating' => $this->IMDb_rating,
            'content_rating' => $this->content_rating,
            'release_date' => $this->release_date,
            'is_restricted' => $this->is_restricted,
            'season_name' => $season->name ?? null,
            'thumbnail_image' => setBaseUrlWithFileName($this->thumbnail_url),
            'is_remind' => !empty($is_reminder) ? $is_reminder->is_remind :0,
            'genres' => GenresResource::collection($genre_data),
            'is_userRemind'=> !empty($is_reminder) ? $is_reminder->is_remind :0,
        ];
    }
}
