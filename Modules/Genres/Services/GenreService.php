<?php

namespace Modules\Genres\Services;

use Modules\Genres\Repositories\GenreRepositoryInterface;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class GenreService
{
    protected $genreRepository;

    public function __construct(GenreRepositoryInterface $genreRepository)
    {
        $this->genreRepository = $genreRepository;
    }

    public function getAllGenres()
    {
        return $this->genreRepository->all();
    }

    public function getGenreById($id)
    {
        return $this->genreRepository->find($id);
    }

    public function createGenre(array $data)
    {
        $cacheKey = 'genres_';
        Cache::forget($cacheKey);

        $data['slug'] = Str::slug($data['name']);
        // $data['file_url'] = setDefaultImage($data['file_url']);
        return $this->genreRepository->create($data);
    }

    public function updateGenre($id, array $data)
    {
        $cacheKey = 'genres_';
        Cache::forget($cacheKey);
        return $this->genreRepository->update($id, $data);
    }

    public function deleteGenre($id)
    {
        $cacheKey = 'genres_';
        Cache::forget($cacheKey);
        return $this->genreRepository->delete($id);
    }

    public function restoreGenre($id)
    {
        $cacheKey = 'genres_';
        Cache::forget($cacheKey);
        return $this->genreRepository->restore($id);
    }

    public function forceDeleteGenre($id)
    {
        $cacheKey = 'genres_';
        Cache::forget($cacheKey);
        return $this->genreRepository->forceDelete($id);
    }

    public function getDataTable(Datatables $datatable, $filter)
    {
        $query = $this->getFilteredData($filter);
        return $datatable->eloquent($query)
            ->addColumn('check', function ($row) {
                return '<input type="checkbox" class="form-check-input select-table-row"  id="datatable-row-' . $row->id . '"  name="datatable_ids[]" value="' . $row->id . '" data-type="genres" onclick="dataTableRowCheck(' . $row->id . ',this)">';
            })
            ->editColumn('image', function ($data) {

                $imageUrl = setBaseUrlWithFileName($data->file_url);
                return view('components.image-name', ['image' => $imageUrl, 'name' => $data->name])->render();
            })
            ->addColumn('action', function ($data) {
                return view('genres::backend.genres.action', compact('data'));
            })
            ->editColumn('status', function ($row) {
                $checked = $row->status ? 'checked="checked"' : '';
                $disabled = $row->trashed() ? 'disabled' : '';
                return '
                    <div class="form-check form-switch">
                        <input type="checkbox" data-url="' . route('backend.genres.update_status', $row->id) . '"
                            data-token="' . csrf_token() . '" class="switch-status-change form-check-input"
                            id="datatable-row-' . $row->id . '" name="status" value="' . $row->id . '" ' . $checked . ' ' . $disabled . '>
                    </div>
                ';
            })
            ->editColumn('updated_at', function ($data) {
                $diff = Carbon::now()->diffInHours($data->updated_at);
                return $diff < 25 ? $data->updated_at->diffForHumans() : $data->updated_at->isoFormat('llll');
            })
            ->orderColumns(['id'], '-:column $1')
            ->rawColumns(['action', 'status', 'check', 'image'])
            ->toJson();
    }

    public function getFilteredData($filter)
    {
        $query = $this->genreRepository->query();

        if (isset($filter['column_status'])) {
            $query->where('status', $filter['column_status']);
        }

        if (isset($filter['name'])) {
            $query->where('name', 'like', '%' . $filter['name'] . '%');
        }

        return $query;
    }

    public function getGenresList($perPage, $searchTerm = null)
    {
        return $this->genreRepository->list($perPage, $searchTerm);
    }


}
