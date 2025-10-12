<?php

namespace Modules\Episode\Repositories;

interface EpisodeRepositoryInterface
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
    public function saveQualityMappings($id, array $videoQuality, array $qualityVideoUrl, array $videoQualityType,array $qualityVideoFile);
    public function storeDownloads( array $data,$id);


}
