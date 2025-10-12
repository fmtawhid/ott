<?php

namespace Modules\LiveTV\Services;

use Modules\LiveTV\Models\LiveTvChannel;
use Modules\LiveTV\Repositories\LiveTvChannelRepositoryInterface;
use Modules\LiveTV\Models\TvChannelStreamContentMapping;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Cache;

class LiveTvChannelService
{
    protected $liveTvChannelRepository;

    public function __construct(LiveTvChannelRepositoryInterface $liveTvChannelRepository)
    {
        $this->liveTvChannelRepository = $liveTvChannelRepository;
    }

    public function getAll()
    {
        return $this->liveTvChannelRepository->all();
    }

    public function getById($id)
    {
        return $this->liveTvChannelRepository->find($id);
    }

    public function create(array $data, $request)
    {
        $cacheKey = 'livetv_channel_list';
        Cache::forget($cacheKey);

        if ($request->type === 't_url') {
            $data['stream_type'] = $request->input('stream_type');
            $data['server_url'] = $request->input('server_url');
            $data['server_url1'] = $request->input('server_url1');
            $data['embedded'] = null;
        } else if ($request->type === 't_embedded') {
            $data['stream_type'] = $request->input('stream_type');
            $data['server_url'] = null;
            $data['server_url1'] = null;
            $data['embedded'] = $request->input('embedded');
        }

        $liveTvChannel = $this->liveTvChannelRepository->create($data);

        if ($request->hasFile('poster_url')) {
            $file = $request->file('poster_url');
            StoreMediaFile($liveTvChannel, $file, 'poster_url');

            $bannerData = $this->liveTvChannelRepository->find($liveTvChannel->id);
            $liveTvChannel->poster_url = $bannerData->poster_url;
            $liveTvChannel->save();
        }

        if (!empty($liveTvChannel) && !empty($data['stream_type'])) {
            $mappingstream = [
                'tv_channel_id' => $liveTvChannel->id,
                'type' => $data['type'],
                'stream_type' => $data['stream_type'],
                'embedded' => $data['embedded'],
                'server_url' => $data['server_url'],
                'server_url1' => $data['server_url1'],
            ];

            TvChannelStreamContentMapping::create($mappingstream);
        }

        return $liveTvChannel;
    }
    public function update($id, array $data)
    {
        $cacheKey = 'livetv_channel_list';
        Cache::forget($cacheKey);
        return $this->liveTvChannelRepository->update($id, $data);
    }

    public function delete($id)
    {
        $cacheKey = 'livetv_channel_list';
        Cache::forget($cacheKey);
        return $this->liveTvChannelRepository->delete($id);
    }

    public function restore($id)
    {
        $cacheKey = 'livetv_channel_list';
        Cache::forget($cacheKey);
        return $this->liveTvChannelRepository->restore($id);
    }

    public function forceDelete($id)
    {
        $cacheKey = 'livetv_channel_list';
        Cache::forget($cacheKey);
        return $this->liveTvChannelRepository->forceDelete($id);
    }

}
