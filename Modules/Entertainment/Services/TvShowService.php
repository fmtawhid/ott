<?php

namespace Modules\Entertainment\Services;

use Modules\Entertainment\Repositories\EntertainmentRepositoryInterface;
use  Modules\Genres\Repositories\GenreRepositoryInterface;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class TvShowService
{
    protected $entertainmentRepository;
    protected $genresRepository;

    public function __construct( EntertainmentRepositoryInterface $entertainmentRepository, GenreRepositoryInterface $genresRepository)
    {
        $this->entertainmentRepository = $entertainmentRepository;
        $this->genresRepository = $genresRepository;
    }

    public function getAll()
    {
        return $this->entertainmentRepository->all();
    }

    public function getById($id)
    {
        return $this->entertainmentRepository->find($id);
    }

    public function create(array $data)
    {

        $cacheKey1 = 'movie_';
        $cacheKey2 = 'tvshow_';

        Cache::forget($cacheKey1);
        Cache::forget($cacheKey2);

        $data['poster_url'] = setDefaultImage($data['poster_url']);
        $data['thumbnail_url'] = setDefaultImage($data['thumbnail_url']);

        $data['trailer_url'] = ($data['trailer_url_type'] == 'Local') ? $data['trailer_video'] : $data['trailer_url'];

        $data['video_url_input'] = ($data['video_upload_type'] == 'Local') ? $data['video_file_input'] : $data['video_url_input'];

        $entertainment = $this->entertainmentRepository->create($data);

        if (!empty($data['genres'])) {
            $this->entertainmentRepository->saveGenreMappings($data['genres'], $entertainment->id);
        }

        if (!empty($data['actors'])) {
            $this->entertainmentRepository->saveTalentMappings($data['actors'], $entertainment->id);
        }

        if (!empty($data['directors'])) {
            $this->entertainmentRepository->saveTalentMappings($data['directors'], $entertainment->id);
        }

        if (isset($data['enable_quality']) && $data['enable_quality'] == 1) {


            $this->entertainmentRepository->saveQualityMappings(
                $entertainment->id,
                $data['video_quality'],
                $data['quality_video_url_input'],
                $data['video_quality_type']
            );
        }


        $notification_data = [
            'id' => $entertainment->id,
            'name' => $entertainment->name,
            'posterimage' => $entertainment->poster_url ?? null,
            'type' => $entertainment->type,
            'release_date' => $entertainment->release_date ?? null,
            'description' => $entertainment->description ?? null,
        ];

        $this->SendPushNotification($notification_data);

        return $entertainment;
    }


    public function update($id, array $data)
    {
        $entertainment = $this->entertainmentRepository->find($id);

        if($entertainment->type=='movie'){

            $cacheKey = 'movie_'.$id;
            Cache::flush();


          }else{

            $cacheKey = 'tvshow_'.$id;
            Cache::flush();


          }

        $data['trailer_url'] = ($data['trailer_url_type'] == 'Local') ? $data['trailer_video'] : $data['trailer_url'];

        $data['video_url_input'] = ($data['video_upload_type'] == 'Local') ? $data['video_file_input'] : $data['video_url_input'];

        return $this->entertainmentRepository->update($id, $data);
    }

    public function delete($id)
    {
         $entertainment = $this->entertainmentRepository->find($id);

        if($entertainment->type=='movie'){

            $cacheKey = 'movie_'.$id;
            Cache::flush();


          }else{

            $cacheKey = 'tvshow_'.$id;
            Cache::flush();


          }

        return $this->entertainmentRepository->delete($id);
    }

    public function restore($id)
    {
        $entertainment = $this->entertainmentRepository->find($id);

        if($entertainment->type=='movie'){

            $cacheKey = 'movie_'.$id;
            Cache::flush();

          }else{

            $cacheKey = 'tvshow_'.$id;
            Cache::flush();


          }

        return $this->entertainmentRepository->restore($id);
    }

    public function forceDelete($id)
    {
        $entertainment = $this->entertainmentRepository->find($id);

        if($entertainment->type=='movie'){

            $cacheKey = 'movie_'.$id;
            Cache::flush();


          }else{

            $cacheKey = 'tvshow_'.$id;
            Cache::flush();


          }

        return $this->entertainmentRepository->forceDelete($id);
    }

    public function getDataTable(Datatables $datatable, $filter, $type)
    {
        $query = $this->getFilteredData($filter, $type)
    ->withCount([
        'entertainmentLike' => function ($query) use ($type) {
            $query->where('is_like', 1)->where('type', $type);
        },
        'entertainmentView' => function ($query)  { }
    ]);

        return $datatable->eloquent($query)
        ->editColumn('thumbnail_url', function ($data) {
            $genres = $this->entertainmentRepository->movieGenres($data->id);
            $type = 'tvshow';
            $releaseDate = $data->release_date ? formatDate($data->release_date) : '';
            $imageUrl =setBaseUrlWithFileName($data->thumbnail_url);
            return view('components.media-item', ['thumbnail' => $imageUrl, 'name' => $data->name,'genre'=>implode(', ', $genres->toArray()),'releaseDate'=>$releaseDate, 'type' => $type])->render();

        })

        ->addColumn('like_count', function ($data) {
            return $data->entertainment_like_count > 0 ? $data->entertainment_like_count : '-';
        })
        ->orderColumn('like_count', 'entertainment_like_count $1')

        ->addColumn('watch_count', function ($data) {
            return $data->entertainment_view_count > 0 ? $data->entertainment_view_count : '-';
        })

        ->orderColumn('watch_count', 'entertainment_view_count $1')

        ->filterColumn('thumbnail_url', function ($query, $keyword) {
            if (!empty($keyword)) {
                $query->where('name', 'like', '%' . $keyword . '%');
            }
        })
        ->editColumn('plan_id', function ($data) {
            return $data->access === 'pay-per-view' ? '-' : optional($data->plan)->name ?? '-';
        })

        ->filterColumn('plan_id', function ($query, $keyword) {
            if (!empty($keyword)) {
                $query->whereHas('plan', function ($query) use ($keyword) {
                    $query->where('name', 'like', '%' . $keyword . '%');
                });
            }
        })

        ->editColumn('language', function ($data) {
            // Capitalize the first letter of the language value
            $language = optional($data->language) ? ucfirst($data->language) : '-';
            return $language;
        })
        ->addColumn('check', function ($data) {
            return '<input type="checkbox" class="form-check-input select-table-row"  id="datatable-row-'.$data->id.'"  name="datatable_ids[]" value="'.$data->id.'" data-type="entertainment" onclick="dataTableRowCheck('.$data->id.',this)">';
        })
        ->addColumn('action', function ($data) {
            return view('entertainment::backend.tvshows.action', compact('data'));
        })
        ->editColumn('status', function ($row) {
            $checked = $row->status ? 'checked="checked"' : ''; // Check if status is active
            $disabled = $row->trashed() ? 'disabled' : ''; // Disable if the record is soft-deleted

            return '
                <div class="form-check form-switch">
                    <input type="checkbox" data-url="' . route('backend.entertainments.update_status', $row->id) . '"
                        data-token="' . csrf_token() . '" class="switch-status-change form-check-input"
                        id="datatable-row-' . $row->id . '" name="status" value="' . $row->id . '" ' . $checked . ' ' . $disabled . '>
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
                        data-url="' . route('backend.entertainments.update_is_restricted', $row->id) . '"
                        data-token="' . csrf_token() . '"
                        ' . $checked . ' ' . $disabled . '>
                </div>';
        })


        ->editColumn('updated_at', fn($data) =>formatUpdatedAt($data->updated_at))
            ->orderColumns(['id'], '-:column $1')
            ->rawColumns(['action', 'status', 'check','thumbnail_url','is_restricted'])
            ->toJson();
    }

    public function getFilteredData($filter, $type)
    {
        $query = $this->entertainmentRepository->query();

        if($type!=null){

            $query = $query->where('type',$type);
        }

        if (isset($filter['moive_name'])) {
            $query->where('name', 'like', '%' . $filter['moive_name'] . '%');
        }

        if (isset($filter['plan_id'])) {
            $query->where('plan_id', $filter['plan_id']);
        }

        if (isset($filter['movie_access'])) {
            $query->where('movie_access', $filter['movie_access']);
        }

        if (isset($filter['language'])) {
            $query->where('language', $filter['language']);
        }

        if (isset($filter['gener'])) {
            $query->whereHas('entertainmentGenerMappings', function ($q) use ($filter) {
                $q->where('genre_id', $filter['gener']);
            });
        }

        if (isset($filter['column_status'])) {
            $query->where('status', $filter['column_status']);
        }

        return $query;
    }

    public function storeDownloads(array $data, $id)
    {
        return $this->entertainmentRepository->storeDownloads($data, $id);
    }



    public function getEntertainmentList($perPage, $searchTerm = null)
    {
        return $this->entertainmentRepository->list($perPage, $searchTerm);
    }

    public function SendPushNotification($data)
    {
        $heading = [
            "en" => $data['name']
        ];

        $content = [
            "en" => $data['description']
        ];

        return fcm([
            'to' => 'all_user',
            'collapse_key' => 'type_a',
            'notification' => [
                'body' => $content,
                'title' => $heading,
            ],
        ]);
    }


}
