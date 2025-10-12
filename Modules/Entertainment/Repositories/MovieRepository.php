<?php

namespace Modules\Entertainment\Repositories;


class MovieRepository implements MovieRepositoryInterface
{

    private $api_key = '55e89e24a03a87fa84d7d96abe40d4dd';

    private function executeCurl($url, $headers = []) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => $headers,
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    public function getConfiguration(){

        $url = 'https://api.themoviedb.org/3/configuration?api_key=' . $this->api_key;
        return $this->executeCurl($url);
    }

    public function getMovieDetails($id)
    {
        $url = 'https://api.themoviedb.org/3/movie/' . $id . '?api_key=' . $this->api_key;
        return $this->executeCurl($url);
        
    }

    public function getCastCrew($id)
    {
        $url = 'https://api.themoviedb.org/3/movie/' . $id . '/credits?api_key=' . $this->api_key;
        $headers = array('accept: application/json');
        return $this->executeCurl($url, $headers);
        
    }

    public function getCastCrewDetail($id)
    {
        $url = 'https://api.themoviedb.org/3/person/' . $id . '?api_key=' . $this->api_key;
        $headers = array('accept: application/json');
        return $this->executeCurl($url, $headers);
        
    }

    public function getMovieVideo($id) {
        $url = 'https://api.themoviedb.org/3/movie/' . $id . '/videos?api_key=' . $this->api_key;
        $headers = array('accept: application/json');
        return $this->executeCurl($url, $headers);
    }


}
