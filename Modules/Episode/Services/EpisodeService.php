<?php

namespace Modules\Episode\Services;

use Modules\Episode\Repositories\EpisodeRepositoryInterface;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Cache;

class EpisodeService
{
    protected $episodeRepository;

    public function __construct(EpisodeRepositoryInterface $episodeRepository)
    {
        $this->episodeRepository = $episodeRepository;
    }

    public function getAll()
    {
        return $this->episodeRepository->all();
    }

    public function getById($id)
    {
        return $this->episodeRepository->find($id);
    }



    public function create(array $data)
    {
        $cacheKey = 'episode_';
        Cache::forget($cacheKey);

        $data['trailer_url'] = ($data['trailer_url_type'] == 'Local') ? $data['trailer_video'] : $data['trailer_url'];
        $data['video_url_input'] = ($data['video_upload_type'] == 'Local') ? $data['video_file_input'] : $data['video_url_input'];
       $episode = $this->episodeRepository->create($data);

       if(isset($data['enable_quality']) && $data['enable_quality'] == 1) {
        $this->episodeRepository->saveQualityMappings(
            $episode->id,
            $data['video_quality'],
            $data['quality_video_url_input'],
            $data['video_quality_type'],
            $data['quality_video'],
        );
    }



        return $episode;
    }

    public function update($id, array $data)
    {
        $cacheKey = 'episode_'.$id;
        Cache::flush();

        $data['trailer_url'] = ($data['trailer_url_type'] == 'Local') ? $data['trailer_video'] : $data['trailer_url'];

        $data['video_url_input'] = ($data['video_upload_type'] == 'Local') ? $data['video_file_input'] : $data['video_url_input'];
        return $this->episodeRepository->update($id, $data);
    }

    public function delete($id)
    {
        $cacheKey = 'episode_'.$id;
        Cache::flush();


        return $this->episodeRepository->delete($id);
    }

    public function restore($id)
    {
        $cacheKey = 'episode_'.$id;
        Cache::flush();


        return $this->episodeRepository->restore($id);
    }

    public function forceDelete($id)
    {
        $cacheKey = 'episode_'.$id;
        Cache::flush();


        return $this->episodeRepository->forceDelete($id);
    }

    public function getDataTable(Datatables $datatable, $filter)
    {
        $query = $this->getFilteredData($filter);
        return $datatable->eloquent($query)
        ->editColumn('poster_url', function ($data) {
            $seasonName = optional($data->seasondata)->name;
            $type = 'episode';
            $imageUrl = setBaseUrlWithFileName($data->poster_url);
            return view('components.media-item', ['thumbnail' => $imageUrl, 'name' => $data->name, 'seasonName' => $seasonName, 'type' => $type])->render();
        })

        ->editColumn('entertainment_id', function ($data) {
            return optional($data->entertainmentdata)->name;
        })


        ->editColumn('season_id', function ($data) {
            return optional($data->seasondata)->name;
        })


        ->filterColumn('season_id', function ($data, $keyword) {
            if (!empty($keyword)) {
                $data->whereHas('seasondata', function ($q) use ($keyword) {
                    $q->where('name', 'like', '%' . $keyword . '%');
                });
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

        ->filterColumn('entertainment_id', function($query, $keyword) {
            $query->where('entertainment_id', $keyword);
        })

        ->filterColumn('entertainment_id', function ($data, $keyword) {
            if (!empty($keyword)) {
                $data->whereHas('entertainmentdata', function ($q) use ($keyword) {
                    $q->where('name', 'like', '%' . $keyword . '%');
                });
            }
        })


        ->filterColumn('season_id', function($query, $keyword) {
            $query->where('season_id', $keyword);
        })

          ->addColumn('check', function ($data) {
              return '<input type="checkbox" class="form-check-input select-table-row"  id="datatable-row-'.$data->id.'"  name="datatable_ids[]" value="'.$data->id.'" data-type="episode" onclick="dataTableRowCheck('.$data->id.',this)">';
          })
          ->addColumn('action', function ($data) {
              return view('episode::backend.episode.action', compact('data'));
          })
          ->editColumn('status', function ($row) {
            $checked = $row->status ? 'checked="checked"' : ''; // Check if status is active
            $disabled = $row->trashed() ? 'disabled' : ''; // Disable if the record is soft-deleted

            return '
                <div class="form-check form-switch">
                    <input type="checkbox" data-url="' . route('backend.episodes.update_status', $row->id) . '"
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
                        data-url="' . route('backend.episodes.update_is_restricted', $row->id) . '"
                        data-token="' . csrf_token() . '"
                        ' . $checked . ' ' . $disabled . '>
                </div>';
        })
        ->orderColumn('status', function ($query, $order) {
            $query->orderBy('status', $order);
        })
          ->editColumn('updated_at', fn($data) =>formatUpdatedAt($data->updated_at))
            ->orderColumns(['id'], '-:column $1')
            ->rawColumns(['action', 'status', 'check','poster_url','entertainment_id','season_id','plan_id','is_restricted'])
            ->toJson();
    }

    public function getFilteredData($filter)
    {
        $query = $this->episodeRepository->query();

        if (isset($filter['name'])) {
            $query->where('name', $filter['name']);
        }

        if (isset($filter['access'])) {
            $query->where('access', $filter['access']);
        }


        if (isset($filter['plan_id'])) {
            $query->where('plan_id', $filter['plan_id']);
        }

        if (isset($filter['entertainment_id'])) {
            $query->where('entertainment_id', $filter['entertainment_id']);
        }
        if (isset($filter['season_id'])) {
            $query->where('season_id', $filter['season_id']);
        }

        if (isset($filter['column_status'])) {
            $query->where('status', $filter['column_status']);
        }
        return $query;
    }

    public function getList($perPage, $searchTerm = null)
    {
        return $this->episodeRepository->list($perPage, $searchTerm);
    }


    public function storeDownloads(array $data, $id)
    {
        return $this->episodeRepository->storeDownloads($data, $id);
    }


    public function getEpisodeList($tvshow_id,$season_index){

     $curl = curl_init();

     $api_key=gettmdbapiKey();

     curl_setopt_array($curl, array(
       CURLOPT_URL => 'https://api.themoviedb.org/3/tv/'.$tvshow_id.'/season/'.$season_index.'?api_key='.$api_key,
       CURLOPT_RETURNTRANSFER => true,
       CURLOPT_ENCODING => '',
       CURLOPT_MAXREDIRS => 10,
       CURLOPT_TIMEOUT => 0,
       CURLOPT_FOLLOWLOCATION => true,
       CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
       CURLOPT_CUSTOMREQUEST => 'GET',
     ));

     $response = curl_exec($curl);

     curl_close($curl);

     return $response;

    }

    public function getConfiguration(){

        $api_key=gettmdbapiKey();

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.themoviedb.org/3/configuration?api_key='.$api_key,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
        ));

       $response = curl_exec($curl);

       curl_close($curl);

       return $response;

    }

    public function  getEpisodeDetails($tvshow_id,$season_id, $episode_id){

      $curl = curl_init();

     $api_key=gettmdbapiKey();

      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.themoviedb.org/3/tv/'.$tvshow_id.'/season/'.$season_id.'/episode/'.$episode_id.'?api_key='.$api_key,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
      ));

      $response = curl_exec($curl);

      curl_close($curl);

      return $response;

    }

    public function getEpisodevideo($tvshow_id,$season_id, $episode_id){

       $curl = curl_init();

       $api_key=gettmdbapiKey();

       curl_setopt_array($curl, array(
         CURLOPT_URL => 'https://api.themoviedb.org/3/tv/'.$tvshow_id.'/season/'.$season_id.'/episode/'.$episode_id.'/videos?api_key='.$api_key,
         CURLOPT_RETURNTRANSFER => true,
         CURLOPT_ENCODING => '',
         CURLOPT_MAXREDIRS => 10,
         CURLOPT_TIMEOUT => 0,
         CURLOPT_FOLLOWLOCATION => true,
         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
         CURLOPT_CUSTOMREQUEST => 'GET',
         CURLOPT_HTTPHEADER => array(
           'accept: application/json'
         ),
       ));

       $response = curl_exec($curl);

       curl_close($curl);

       return $response;
    }


}
