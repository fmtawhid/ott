<?php

namespace Modules\LiveTV\Repositories;

use Modules\LiveTV\Models\LiveTvChannel;
use Modules\LiveTV\Models\TvChannelStreamContentMapping;

class LiveTvChannelRepository implements LiveTvChannelRepositoryInterface
{
    public function all()
    {
        return LiveTvChannel::where('status', 1)
            ->orderBy('updated_at', 'desc')
            ->get();
    }

    public function find($id)
    {
        return LiveTvChannel::withTrashed()
            ->whereNull('deleted_at')
            ->findOrFail($id);
    }

    public function create(array $data)
    {
        $LiveTvChannel = LiveTvChannel::create($data);

        if (!empty($data['stream_type'])) {
            TvChannelStreamContentMapping::create([
                'tv_channel_id' => $LiveTvChannel->id,
                'type' => $data['type'],
                'stream_type' => $data['stream_type'],
                'embedded' => $data['embedded'],
                'server_url' => $data['server_url'],
                'server_url1' => $data['server_url1'],
            ]);
        }

        return $LiveTvChannel;
    }

    public function update($id, array $data)
    {
        $LiveTv = LiveTvChannel::findOrFail($id);

        $LiveTv->update($data);

        if (isset($data['enable_quality']) && $data['enable_quality'] == 1) {
            $this->updateQualityMappings($LiveTv->id, $data);
        }
        return $LiveTv;
    }

    public function delete($id)
    {
        $LiveTv = LiveTvChannel::findOrFail($id);
        $LiveTv->delete();
        return $LiveTv;
    }

    public function restore($id)
    {
        $LiveTv = LiveTvChannel::withTrashed()->findOrFail($id);
        $LiveTv->restore();
        return $LiveTv;
    }

    public function forceDelete($id)
    {
        $LiveTv = LiveTvChannel::withTrashed()->findOrFail($id);
        $LiveTv->forceDelete();
        return $LiveTv;
    }

    public function query()
    {

        $LiveTv = LiveTvChannel::query()->withTrashed();

        if (Auth::user()->hasRole('user')) {
            $LiveTv->whereNull('deleted_at');
        }

        return $LiveTv;

    }

    public function list($perPage, $searchTerm = null)
    {
        $query = LiveTvChannel::query();

        if ($searchTerm) {
            $query->where('name', 'like', "%{$searchTerm}%");
        }

        $query->where('status', 1)
            ->orderBy('updated_at', 'desc');

        return $query->paginate($perPage);
    }



}
