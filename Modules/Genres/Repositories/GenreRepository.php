<?php

namespace Modules\Genres\Repositories;

use Modules\Genres\Models\Genres;
use Auth;

class GenreRepository implements GenreRepositoryInterface
{
    public function all()
    {
        $query = Genres::query();

        $query->where('status', 1)
              ->orderBy('updated_at', 'desc')->get();

        return $query;
    }

    public function find($id)
    {
        $genreQuery = Genres::query();

        if (Auth::user()->hasRole('user')) {
            $genreQuery->whereNull('deleted_at'); // Only show non-trashed genres
        }

        $genre = $genreQuery->withTrashed()->findOrFail($id);

        $genre->file_url = setBaseUrlWithFileName($genre->file_url);

        return $genre;
    }

    public function create(array $data)
    {
        return Genres::create($data);
    }

    public function update($id, array $data)
    {
        $genre = Genres::findOrFail($id);
        $genre->update($data);
        return $genre;
    }

    public function delete($id)
    {
        $genre = Genres::findOrFail($id);
        $genre->delete();
        return $genre;
    }

    public function restore($id)
    {
        $genre = Genres::withTrashed()->findOrFail($id);
        $genre->restore();
        return $genre;
    }

    public function forceDelete($id)
    {
        $genre = Genres::withTrashed()->findOrFail($id);
        $genre->forceDelete();
        return $genre;
    }

    public function query()
    {

        $genreQuery=Genres::query()->withTrashed();

        if(Auth::user()->hasRole('user') ) {
            $genreQuery->whereNull('deleted_at');
        }

        return $genreQuery;

    }

    public function list($perPage, $searchTerm = null)
    {
        $query = Genres::query();

        if ($searchTerm) {
            $query->where('name', 'like', "%{$searchTerm}%");
        }

        $query->where('status', 1)
              ->orderBy('updated_at', 'desc');

        return $query->paginate($perPage);
    }


}
