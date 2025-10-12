<?php

namespace Modules\CastCrew\Repositories;

use Modules\CastCrew\Models\CastCrew;
use Auth;

class CastCrewRepository implements CastCrewRepositoryInterface
{
    public function all()
    {
        return CastCrew::all();
    }

    public function find($id)
    {
        $genreQuery = CastCrew::query();

        if (Auth::user()->hasRole('user')) {
            $genreQuery->whereNull('deleted_at'); // Only show non-trashed genres
        }

        $genre = $genreQuery->withTrashed()->findOrFail($id);
        $genre->file_url = setBaseUrlWithFileName($genre->file_url);
        return $genre;
    }

    public function create(array $data)
    {
        return CastCrew::create($data);
    }

    public function update($id, array $data)
    {
        $genre = CastCrew::findOrFail($id);
        $genre->update($data);
        return $genre;
    }

    public function delete($id)
    {
        $genre = CastCrew::findOrFail($id);
        $genre->delete();
        return $genre;
    }

    public function restore($id)
    {
        $genre = CastCrew::withTrashed()->findOrFail($id);
        $genre->restore();
        return $genre;
    }

    public function forceDelete($id)
    {
        $genre = CastCrew::withTrashed()->findOrFail($id);
        $genre->forceDelete();
        return $genre;
    }

    public function query()
    {

        $genreQuery=CastCrew::query()->withTrashed();

        if(Auth::user()->hasRole('user') ) {
            $genreQuery->whereNull('deleted_at');
        }

        return $genreQuery;

    }

    public function list($perPage, $searchTerm = null)
    {
        $query = CastCrew::query();

        if ($searchTerm) {
            $query->where('name', 'like', "%{$searchTerm}%");
        }

        $query->where('status', 1)
              ->orderBy('updated_at', 'desc');

        return $query->paginate($perPage);
    }


}
