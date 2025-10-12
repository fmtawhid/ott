<?php

namespace Modules\Entertainment\Repositories;

interface TvshowRepositoryInterface
{
   
    public function getConfiguration();
    public function getTvshowDetails($id);
    public function getCastCrewDetail($id);
    public function getCastCrew($id);
    public function getTvshowVideo($id);

    
    
}