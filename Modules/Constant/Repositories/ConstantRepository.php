<?php

namespace Modules\Constant\Repositories;

use Modules\Constant\Models\Constant;
use Auth;

class ConstantRepository implements ConstantRepositoryInterface
{
    public function all()
    {
        $query = Constant::query();

        $query->where('status', 1)
            ->orderBy('updated_at', 'desc')->get();

        return $query;
    }

    public function find($id)
    {
        $constant = Constant::query();

        if (Auth::user()->hasRole('user')) {
            $constant->whereNull('deleted_at'); // Only show non-trashed genres
        }

        $constant = $constant->withTrashed()->findOrFail($id);

        return $constant;
    }

    public function create(array $data)
    {
        return Constant::create($data);
    }

    public function update($id, array $data)
    {
        $constant = Constant::findOrFail($id);

        $constant->update($data);

       
        return $constant;
    }

    public function delete($id)
    {
        $constant = Constant::findOrFail($id);
        $constant->delete();
        return $constant;
    }

    public function restore($id)
    {
        $constant = Constant::withTrashed()->findOrFail($id);
        $constant->restore();
        return $constant;
    }

    public function forceDelete($id)
    {
        $constant = Constant::withTrashed()->findOrFail($id);
        $constant->forceDelete();
        return $constant;
    }

    public function query()
    {

        $constant = Constant::query()->withTrashed();

        if (Auth::user()->hasRole('user')) {
            $constant->whereNull('deleted_at');
        }

        return $constant;

    }

    public function list($perPage, $searchTerm = null)
    {
        $query = Constant::query();

        if ($searchTerm) {
            $query->where('name', 'like', "%{$searchTerm}%");
        }

        $query->where('status', 1)
            ->orderBy('updated_at', 'desc');

        return $query->paginate($perPage);
    }

}




