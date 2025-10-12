<?php

namespace Modules\Banner\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Entertainment\Models\Entertainment;
use Modules\LiveTV\Models\LiveTvChannel;
use Modules\Entertainment\Transformers\MoviesResource;
use Modules\Entertainment\Transformers\TvshowResource;
use Modules\LiveTV\Transformers\LiveTvChannelResource;
use Modules\Entertainment\Models\Watchlist;
use Illuminate\Support\Facades\Crypt;
use Modules\Video\Models\Video;
use Modules\Video\Transformers\VideoResource;

class SliderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function __construct($resource, $userId = null)
    {
        parent::__construct($resource);
        $this->userId = $userId;
    }

    public function toArray($request): array
    {
        $entertainment = null;
        $data = null;

        switch ($this->type) {
            case 'movie':
            case 'tvshow':

                $entertainment = Entertainment::with('plan')->select('*');

                isset(request()->is_restricted) && $entertainment = $entertainment->where('is_restricted', request()->is_restricted);
                (!empty(getCurrentProfileSession('is_child_profile')) && getCurrentProfileSession('is_child_profile') != 0) &&
                    $entertainment = $entertainment->where('is_restricted',0);

                   $entertainment = $entertainment->where('id',$this->type_id)->first();

                if ($entertainment) {
                    $entertainment['is_watch_list'] = WatchList::where('entertainment_id', $this->type_id)
                        ->where('user_id', $this->userId)
                        ->where('profile_id',$request->profile_id)
                        ->exists();

                    $entertainment->user_id = $this->user_id ?? null;
                    $data = $this->type === 'movie' ? new MoviesResource($entertainment) : new TvshowResource($entertainment);
                }
                break;

            case 'livetv':

                $livetv = LiveTvChannel::find($this->type_id);
                if ($livetv) {
                    $data = new LiveTvChannelResource($livetv);
                }
                break;
            case 'video':
                $video = Video::select('*');

                isset(request()->is_restricted) && $video = $video->where('is_restricted', request()->is_restricted);
                (!empty(getCurrentProfileSession('is_child_profile')) && getCurrentProfileSession('is_child_profile') != 0) &&
                    $video = $video->where('is_restricted',0);

                   $video = $video->where('id',$this->type_id)->first();
                if ($video) {
                    $video->user_id = $this->user_id ?? null;
                    $data = new VideoResource($video);
                }
                break;
        }

        return [
            'id' => $this->id,
            'title' => $this->name,
            'poster_url' => setBaseUrlWithFileName($this->poster_url),
            'file_url' => setBaseUrlWithFileName($this->file_url),
            'type' => $this->type,
            'data' => $data,
            'poster_tv_image' => setBaseUrlWithFileName($this->poster_tv_url),
        ];
    }
}
