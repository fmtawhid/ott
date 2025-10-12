<?php

namespace Modules\Entertainment\Repositories;

interface MovieRepositoryInterface
{
   
    public function getConfiguration();
    public function getMovieDetails($id);
    public function getCastCrewDetail($id);
    public function getCastCrew($id);
    public function getMovieVideo($id);

    
    
}