<?php

namespace Modules\Entertainment\Trait;

use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Distributions\F;

trait ImportMovieTrait
{

    public function getConfiguration(){

        $api_key=gettmdbapiKey();

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.themoviedb.org/3/configuration?api_key='.$api_key,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
        ));

       $response = curl_exec($curl);

       curl_close($curl);

       return $response;

    }

    public function getMovieDetails($movie_id){

      $curl = curl_init();

      $api_key=gettmdbapiKey();

      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.themoviedb.org/3/movie/'.$movie_id.'?api_key='.$api_key,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
      ));

       $response = curl_exec($curl);

       curl_close($curl);

       return $response;

    }

    public function getMovieVideo($movie_id){

      $curl = curl_init();

      $api_key=gettmdbapiKey();

      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.themoviedb.org/3/movie/'.$movie_id.'/videos?api_key='.$api_key,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
          'accept: application/json'
        ),
      ));

      $response = curl_exec($curl);

      curl_close($curl);

      return $response;


    }

    public function getCastCrew($movie_id){

      $curl = curl_init();

      $api_key=gettmdbapiKey();

      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.themoviedb.org/3/movie/'.$movie_id.'/credits?api_key='.$api_key,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
          'accept: application/json'
        ),
      ));

      $response = curl_exec($curl);

      curl_close($curl);

      return $response;

    }

 public function getCrewDetials($cast_id){

     $curl = curl_init();
     $api_key=gettmdbapiKey();

     curl_setopt_array($curl, array(
       CURLOPT_URL => 'https://api.themoviedb.org/3/person/'.$cast_id.'?api_key='.$api_key,
       CURLOPT_RETURNTRANSFER => true,
       CURLOPT_ENCODING => '',
       CURLOPT_MAXREDIRS => 10,
       CURLOPT_TIMEOUT => 0,
       CURLOPT_FOLLOWLOCATION => true,
       CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
       CURLOPT_CUSTOMREQUEST => 'GET',
       CURLOPT_HTTPHEADER => array(
         'accept: application/json'
       ),
     ));

     $response = curl_exec($curl);

     curl_close($curl);

     return $response;
 }


 public function getTVShowDetails($tv_show_id){

      $curl = curl_init();

      $api_key=gettmdbapiKey();

      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.themoviedb.org/3/tv/'.$tv_show_id.'?api_key='.$api_key,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
          'accept: application/json'
        ),
      ));

     $response = curl_exec($curl);

     curl_close($curl);

     return $response;
 }

 public function getTVShowVideos($tv_show_id){

  $curl = curl_init();

  $api_key=gettmdbapiKey();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.themoviedb.org/3/tv/'.$tv_show_id.'/videos?api_key='.$api_key,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
        'accept: application/json'
      ),
    ));

  $response = curl_exec($curl);

   curl_close($curl);

   return $response;

 }


 public function getTvCastCrew($tv_show_id){

  $curl = curl_init();

  $api_key=gettmdbapiKey();

  curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.themoviedb.org/3/tv/'.$tv_show_id.'/credits?api_key='.$api_key,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
  ));

  $response = curl_exec($curl);

  curl_close($curl);

  return $response;

 }







}
