<?php

namespace Modules\Banner\Services;

use Modules\Banner\Repositories\BannerRepositoryInterface;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\DataTables;

class BannerService
{
    protected $bannerRepository;

    public function __construct( BannerRepositoryInterface $bannerRepository)
    {
        $this->bannerRepository = $bannerRepository;
    }

    public function getAll()
    {
        return $this->bannerRepository->all();
    }

    public function getById($id)
    {
        return $this->bannerRepository->find($id);
    }

    public function create(array $data, $request)
    {
        $cacheKey = 'banner_list';
        Cache::forget($cacheKey);

        $data['type_id'] = $request->input('type_id');
        $data['type_name'] = $request->input('type_name');

        $banner = $this->bannerRepository->create($data);

        return $banner;
    }

    public function update($id, array $data)
    {
        $cacheKey = 'banner_list';
        Cache::flush();

        return $this->bannerRepository->update($id, $data);
    }

    public function delete($id)
    {
        $cacheKey = 'banner_list';
        Cache::flush();

        return $this->bannerRepository->delete($id);
    }

    public function restore($id)
    {
        $cacheKey = 'banner_list';
        Cache::flush();
        return $this->bannerRepository->restore($id);
    }

    public function forceDelete($id)
    {
        $cacheKey = 'banner_list';
        Cache::flush();
        return $this->bannerRepository->forceDelete($id);
    }


}
