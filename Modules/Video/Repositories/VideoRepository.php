<?php

namespace Modules\Video\Repositories;

use Modules\Video\Models\Video;
use Auth;
use Modules\Video\Models\VideoDownloadMapping;

class VideoRepository implements VideoRepositoryInterface
{
    public function all()
    {
        $query = Video::query();

        $query->where('status', 1)
            ->orderBy('updated_at', 'desc')->get();

        return $query;
    }

    public function find($id)
    {
        $videoQuery = Video::query();

        if (Auth::user()->hasRole('user')) {
            $videoQuery->whereNull('deleted_at'); // Only show non-trashed Video
        }

        $video = $videoQuery->withTrashed()->findOrFail($id);

        return $video;
    }

    public function create(array $data)
    {
        return Video::create($data);
    }

    public function update($id, array $data)
    {
        $video = Video::findOrFail($id);
        $video->update($data);
        return $video;
    }

    public function delete($id)
    {
        $video = Video::findOrFail($id);
        $video->delete();
        return $video;
    }

    public function restore($id)
    {
        $video = Video::withTrashed()->findOrFail($id);
        $video->restore();
        return $video;
    }

    public function forceDelete($id)
    {
        $video = Video::withTrashed()->findOrFail($id);
        $video->forceDelete();
        return $video;
    }

    public function query()
    {

        $videoQuery = Video::query()->withTrashed();

        if (Auth::user()->hasRole('user')) {
            $videoQuery->whereNull('deleted_at');
        }

        return $videoQuery;

    }

    public function list($perPage, $searchTerm = null)
    {
        $query = Video::query();

        if ($searchTerm) {
            $query->where('name', 'like', "%{$searchTerm}%");
        }

        $query->where('status', 1)
            ->orderBy('updated_at', 'desc');

        return $query->paginate($perPage);
    }
    public function storeDownloads(array $data, $id)
    {
        $video = Video::withTrashed()->findOrFail($id);
        $video->update($data);

        VideoDownloadMapping::where('video_id', $id)->forceDelete();

        if (isset($data['enable_download_quality']) && $data['enable_download_quality'] == 1) {
            $quality_video_download_type = $data['quality_video_download_type'];
            $video_download_quality = $data['video_download_quality'];
            $download_quality_video_url = $data['download_quality_video_url'];

            if (!empty($quality_video_download_type) && !empty($video_download_quality) && !empty($download_quality_video_url)) {
                foreach ($quality_video_download_type as $index => $qualityType) {
                    if ($qualityType != '' && $video_download_quality[$index] != '' && $download_quality_video_url[$index] != '') {
                        VideoDownloadMapping::create([
                            'video_id' => $video->id,
                            'url' => $download_quality_video_url[$index],
                            'type' => $qualityType,
                            'quality' => $video_download_quality[$index]
                        ]);
                    }
                }
            }
        }
    }


}
