<?php

namespace Modules\Banner\Repositories;

interface BannerRepositoryInterface
{
    public function all();
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function restore($id);
    public function forceDelete($id);
    public function list($perPage, $searchTerm);
    public function query();


}


