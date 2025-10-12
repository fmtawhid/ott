<?php

namespace Modules\Episode\Repositories;

use Modules\Episode\Models\Episode;
use Modules\Episode\Models\EpisodeStreamContentMapping;
use Modules\Episode\Models\EpisodeDownloadMapping;
use Auth;

class EpisodeRepository implements EpisodeRepositoryInterface
{
    public function all()
    {
        $query = Episode::query();

        $query->where('status', 1)
              ->orderBy('updated_at', 'desc')->get();

        return $query;
    }

    public function find($id)
    {
        $episode = Episode::query();

        if (Auth::user()->hasRole('user')) {
            $episode->whereNull('deleted_at'); // Only show non-trashed genres
        }

        $episode = $episode->withTrashed()->findOrFail($id);

        return $episode;
    }

    public function create(array $data)
    {
        return Episode::create($data);
    }

    public function update($id, array $data)
    {
        $episode = Episode::findOrFail($id);

        $episode->update($data);

        if (isset($data['enable_quality']) && $data['enable_quality'] == 1) {
            $this->updateQualityMappings($episode->id, $data);
        }
        return $episode;
    }

    public function delete($id)
    {
        $episode = Episode::findOrFail($id);
        $episode->delete();
        return $episode;
    }

    public function restore($id)
    {
        $episode = Episode::withTrashed()->findOrFail($id);
        $episode->restore();
        return $episode;
    }

    public function forceDelete($id)
    {
        $episode = Episode::withTrashed()->findOrFail($id);
        $episode->forceDelete();
        return $episode;
    }

    public function query()
    {

        $episode=Episode::query()->withTrashed();

        if(Auth::user()->hasRole('user') ) {
            $episode->whereNull('deleted_at');
        }

        return $episode;

    }

    public function list($perPage, $searchTerm = null)
    {
        $query = Episode::query();

        if ($searchTerm) {
            $query->where('name', 'like', "%{$searchTerm}%");
        }

        $query->where('status', 1)
              ->orderBy('updated_at', 'desc');

        return $query->paginate($perPage);
    }

    public function saveQualityMappings($episodeId, array $videoQuality, array $qualityVideoUrl, array $videoQualityType, array $qualityVideoFile)
    {
        foreach ($videoQuality as $index => $quality) {
            if ($quality != '' && ($qualityVideoUrl[$index] != '' || $qualityVideoFile[$index] != '') && $videoQualityType[$index] != '') {
                EpisodeStreamContentMapping::create([
                    'episode_id' => $episodeId,
                    'url' => $qualityVideoUrl[$index] ?? extractFileNameFromUrl($qualityVideoFile[$index]),
                    'type' => $videoQualityType[$index],
                    'quality' => $quality,
                ]);
            }
        }
    }



    protected function updateQualityMappings($episodeId, $requestData)
    {
        $qualityVideoUrlInput = $requestData['quality_video_url_input'] ?? [];
        $qualityVideo = $requestData['quality_video'] ?? [];

    $Quality_video_url = array_map(function($urlInput, $index) use ($qualityVideo) {
        return $urlInput !== null ? $urlInput : ($qualityVideo[$index] ?? null);
    }, $qualityVideoUrlInput, array_keys($qualityVideoUrlInput));
        $videoQuality = $requestData['video_quality'];
        $videoQualityType = $requestData['video_quality_type'];

        if (!empty($videoQuality) && !empty($Quality_video_url) && !empty($videoQualityType)) {
            EpisodeStreamContentMapping::where('episode_id', $episodeId)->forceDelete();
            foreach ($videoQuality as $index => $videoquality) {
                if ($videoquality != '' && $Quality_video_url[$index] != '' && $videoQualityType[$index]) {
                    $url = isset($Quality_video_url[$index])
                    ? ($videoQualityType[$index] == 'Local'
                        ? extractFileNameFromUrl($Quality_video_url[$index])
                        : $Quality_video_url[$index])
                    : null;
                    $type = $videoQualityType[$index] ?? null;
                    $quality = $videoquality;

                    EpisodeStreamContentMapping::create([
                        'episode_id' => $episodeId,
                        'url' => $url,
                        'type' => $type,
                        'quality' => $quality
                    ]);
                }
            }
        }
    }

    public function storeDownloads(array $data, $id)
    {
        $episode = Episode::withTrashed()->findOrFail($id);

        $episode->update($data);

        EpisodeDownloadMapping::where('episode_id', $id)->forceDelete();

        if (isset($data['enable_download_quality']) && $data['enable_download_quality'] == 1) {
            $quality_video_download_type = $data['quality_video_download_type'];
            $video_download_quality = $data['video_download_quality'];
            $download_quality_video_url = $data['download_quality_video_url'];

            if (!empty($quality_video_download_type) && !empty($video_download_quality) && !empty($download_quality_video_url)) {
                foreach ($quality_video_download_type as $index => $qualityType) {
                    if ($qualityType != '' && $video_download_quality[$index] != '' && $download_quality_video_url[$index] != '') {
                        EpisodeDownloadMapping::create([
                            'episode_id' => $episode->id,
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
