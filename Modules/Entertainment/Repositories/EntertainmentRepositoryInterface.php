<?php

namespace Modules\Entertainment\Repositories;

interface EntertainmentRepositoryInterface
{
    public function all();
    public function movieGenres($id);
    public function moviecountries($id);
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function restore($id);
    public function forceDelete($id);
    public function list($filters);
    public function query();
    public function saveGenreMappings(array $data,$id);
    public function saveCountryMappings(array $data,$id);
    public function saveTalentMappings(array $data,$id);
    public function saveQualityMappings($id, array $videoQuality, array $qualityVideoUrl, array $videoQualityType, array $qualityVideoFile);
    public function storeDownloads( array $data,$id);

}
