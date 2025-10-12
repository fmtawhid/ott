<?php

namespace Modules\Video\Services;

use Modules\Video\Repositories\VideoRepositoryInterface;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class VideoService
{
    protected $videoRepository;

    public function __construct(VideoRepositoryInterface $videoRepository)
    {
        $this->videoRepository = $videoRepository;
    }

    public function getAllVideos()
    {
        return $this->videoRepository->all();
    }

    public function getVideoById($id)
    {
        return $this->videoRepository->find($id);
    }

    public function createVideo(array $data)
    {
        $cacheKey = 'video_list';
        Cache::forget($cacheKey);
        $data['poster_url'] = setDefaultImage($data['poster_url']);

        $data['slug'] = Str::slug($data['name']);
        return $this->videoRepository->create($data);
    }

    public function updateVideo($id, array $data)
    {
        $cacheKey = 'video_list';
        Cache::forget($cacheKey);
        return $this->videoRepository->update($id, $data);
    }

    public function deleteVideo($id)
    {
        $cacheKey = 'video_list';
        Cache::forget($cacheKey);
        return $this->videoRepository->delete($id);
    }

    public function restoreVideo($id)
    {
        $cacheKey = 'video_list';
        Cache::forget($cacheKey);
        return $this->videoRepository->restore($id);
    }

    public function forceDeleteVideo($id)
    {
        $cacheKey = 'video_list';
        Cache::forget($cacheKey);
        return $this->videoRepository->forceDelete($id);
    }

    public function getDataTable(Datatables $datatable, $filter)
    {
        $query = $this->getFilteredData($filter);
        return $datatable->eloquent($query)

        ->editColumn('poster_url', function ($data) {
            $type = 'video';
            $imageUrl = setBaseUrlWithFileName($data->poster_url);
            return view('components.media-item', ['thumbnail' => $imageUrl , 'name' => $data->name, 'type' => $type])->render();
        })

          ->addColumn('check', function ($data) {
              return '<input type="checkbox" class="form-check-input select-table-row"  id="datatable-row-'.$data->id.'"  name="datatable_ids[]" value="'.$data->id.'" data-type="video" onclick="dataTableRowCheck('.$data->id.', this)">';
          })
          ->addColumn('action', function ($data) {
              return view('video::backend.video.action', compact('data'));
          })
        ->editColumn('plan_id', function ($data) {
            return in_array($data->access, ['pay-per-view', 'free']) ? '-' : optional($data->plan)->name ?? '-';
        })

            ->filterColumn('plan_id', function ($query, $keyword) {
                if (!empty($keyword)) {
                    $query->whereHas('plan', function ($query) use ($keyword) {
                        $query->where('name', 'like', '%' . $keyword . '%');
                    });
                }
            })

            ->editColumn('access', function ($data) {
                return $data->access ?? '-';
            })
            ->editColumn('status', function ($row) {
                $checked = $row->status ? 'checked="checked"' : ''; // Check if the status is true
                $disabled = $row->trashed() ? 'disabled' : ''; // Disable if the record is soft-deleted

                return '
                    <div class="form-check form-switch ">
                        <input type="checkbox" data-url="' . route('backend.videos.update_status', $row->id) . '"
                               data-token="' . csrf_token() . '" class="switch-status-change form-check-input"
                               id="datatable-row-' . $row->id . '" name="status" value="' . $row->id . '"
                               ' . $checked . ' ' . $disabled . '>
                    </div>
                ';
            })

            ->editColumn('is_restricted', function ($row) {
                $checked = $row->is_restricted ? 'checked' : '';
                $disabled = $row->trashed() ? 'disabled' : '';

                return '
                    <div class="form-check form-switch">
                        <input type="checkbox"
                            class="switch-status-change form-check-input"
                            data-id="' . $row->id . '"
                            data-url="' . route('backend.videos.update_is_restricted', $row->id) . '"
                            data-token="' . csrf_token() . '"
                            ' . $checked . ' ' . $disabled . '>
                    </div>';
            })
            ->orderColumn('status', function ($query, $order) {
                $query->orderBy('status', $order);
            })
        ->editColumn('updated_at', fn($data) =>formatUpdatedAt($data->updated_at))
        ->rawColumns(['action', 'status', 'check','poster_url','plan_id','access','is_restricted'])
        ->orderColumns(['id'], '-:column $1')
        ->toJson();
    }

    public function getFilteredData($filter)
    {
        $query = $this->videoRepository->query();

        if (isset($filter['column_status'])) {
            $query->where('status', $filter['column_status']);
        }

        if (isset($filter['name'])) {
            $query->where('name', 'like', '%' . $filter['name'] . '%');
        }

        return $query;
    }

    public function getVideosList($perPage, $searchTerm = null)
    {
        return $this->videoRepository->list($perPage, $searchTerm);
    }

    public function storeDownloads(array $data, $id)
    {
        return $this->videoRepository->storeDownloads($data, $id);
    }

}
