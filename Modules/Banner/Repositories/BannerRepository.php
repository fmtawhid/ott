<?php

namespace Modules\Banner\Repositories;

use Modules\Banner\Models\Banner;
use Illuminate\Support\Facades\Auth;

class BannerRepository implements BannerRepositoryInterface
{
    public function all()
    {
        return Banner::where('status', 1)
            ->orderBy('updated_at', 'desc')
            ->get();
    }

    public function find($id)
    {
        return Banner::withTrashed()
            ->whereNull('deleted_at')
            ->findOrFail($id);
    }

    public function create(array $data)
    {
        return Banner::create($data);
    }

    public function update($id, array $data)
    {
        $banner = Banner::findOrFail($id);
        $banner->update($data);
        return $banner;
    }

    public function delete($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->delete();
        return $banner;
    }

    public function restore($id)
    {
        $banner = Banner::withTrashed()->findOrFail($id);
        $banner->restore();
        return $banner;
    }

    public function forceDelete($id)
    {
        $banner = Banner::withTrashed()->findOrFail($id);
        $banner->forceDelete();
        return $banner;
    }

    public function query()
    {
        $query = Banner::query()->withTrashed();

        if (Auth::user()->hasRole('user')) {
            $query->whereNull('deleted_at');
        }

        return $query;
    }

    public function list($perPage, $searchTerm = null)
    {
        $query = Banner::query();

        if ($searchTerm) {
            $query->where('name', 'like', "%{$searchTerm}%");
        }

        $query->where('status', 1)
            ->orderBy('updated_at', 'desc');

        return $query->paginate($perPage);
    }
}
