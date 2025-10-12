<?php

namespace Modules\Entertainment\Services;

use Modules\CastCrew\Models\CastCrew;
use Modules\Constant\Models\Constant;
use Modules\Entertainment\Repositories\MovieRepositoryInterface;
use Modules\Genres\Models\Genres;
use Illuminate\Support\Str;

class MovieService
{
    protected $movieRepository;

    public function __construct(MovieRepositoryInterface $movieRepository)
    {
        $this->movieRepository = $movieRepository;
    }
       
        public function importMovie($id)
        {
            $tmdb_id = $id;
            $configurationData = $this->getConfiguration();
    
            if (isset($configurationData['success']) && $configurationData['success'] === false) {
                return $configurationData;
            }
    
            $movieDetail = $this->getMovieDetail($id);

            if (isset($movieDetail['success']) && $movieDetail['success'] === false) {
                return  $movieDetail;
            }
    
            $movieVideoDetail = $this->getMovieVideoDetail($id);
            if (isset($movieVideoDetail['success']) && $movieVideoDetail['success'] === false) {
                return  $movieVideoDetail;
            }
    
            $castcrewDetail = $this->getCastCrewDetail($id);

            return $this->formatMovieData(  $tmdb_id,$movieDetail, $movieVideoDetail, $castcrewDetail, $configurationData);
        
        }

        private function getConfiguration()
        {
            $configuration = $this->movieRepository->getConfiguration();
            $configurationData= json_decode($configuration, true);
    
            while ($configurationData === null) {
                $configuration = $this->movieRepository->getConfiguration();
                  $configurationData= json_decode($configuration, true);
            }
            return $configurationData;
        }
    
        private function getMovieDetail($id)
        {
            $movieDetails = $this->movieRepository->getMovieDetails($id);
            $movieDetail = json_decode($movieDetails, true);
    
            while ($movieDetail === null) {
                $movieDetails = $this->movieRepository->getMovieDetails($id);
                $movieDetail = json_decode($movieDetails, true);
            }
            return $movieDetail;
        }
    
        private function getMovieVideoDetail($id)
        {
            $movieVideo = $this->movieRepository->getMovieVideo($id);
            $movieVideoDetail = json_decode($movieVideo, true);
    
            while ($movieVideoDetail === null) {
                $movieVideo = $this->movieRepository->getMovieVideo($id);
                $movieVideoDetail = json_decode($movieVideo, true);
            }
            return $movieVideoDetail;
        }
    
        private function getCastCrewDetail($id)
        {
            $castcrew = $this->movieRepository->getCastCrew($id);
            $castcrewDetail = json_decode($castcrew, true);
    
            while ($castcrewDetail === null) {
                $castcrew = $this->movieRepository->getCastCrew($id);
                $castcrewDetail = json_decode($castcrew, true);
            }
            return $castcrewDetail;
        }
    
        private function formatMovieData( $tmdb_id,$movieDetail, $movieVideoDetail, $castcrewDetail, $configurationData)
        {
            $actors = $this->processCast( $tmdb_id,$castcrewDetail['cast'], $configurationData, 'Acting','actor');
            $directors = $this->processCast($tmdb_id,$castcrewDetail['crew'], $configurationData, 'Directing','director');
            $language = $this->processLanguage($movieDetail);
            $genres = $this->processGenres($movieDetail['genres']);
            $videoData = $this->processVideoData($movieVideoDetail);
    
            return [
                'id'=>$tmdb_id,
                'poster_url' => $configurationData['images']['secure_base_url'] . 'original' . $movieDetail['poster_path'],
                'thumbnail_url' => $configurationData['images']['secure_base_url'] . 'original' . $movieDetail['backdrop_path'],
                'trailer_url_type' => $videoData['trailer_url_type'],
                'trailer_url' => $videoData['trailer_url'],
                'name' => $movieDetail['original_title'],
                'description' => $movieDetail['overview'],
                'duration' => $this->formatDuration($movieDetail['runtime']),
                'language' => $language,
                'genres' => $genres,
                'is_restricted' => $movieDetail['adult'],
                'release_date' => $movieDetail['release_date'],
                'actors' => $actors,
                'directors' => $directors,
                'movie_access' => 'free',
                'enable_quality' => true,
                'entertainmentStreamContentMappings' => $videoData['moive_list'],
                'video_url_type'=> $videoData['video_url_type'] ?? 'Local',
                'video_url'=>  $videoData['video_url'],
                'all_actors' => CastCrew::where('type', 'actor')->get(),
                'all_directors' => CastCrew::where('type', 'director')->get(),
                'all_language' => Constant::where('type', 'movie_language')->get(),
                'all_genres' => Genres::where('status', 1)->get(),
            ];
        }
    
        private function processCast($tmdb_id,$castData, $configurationData, $department, $type)
        {
            $result = [];
            $count = 0;
            $maxCount = 5;
    
            foreach ($castData as $cast) {
                if ($count >= $maxCount) break;
                if ($cast['known_for_department'] == $department) {
                    $castDetails = $this->getCrewDetail($cast['id']);
                    if (!empty($castDetails)) {
                        $castRecord = CastCrew::updateOrCreate(
                            ['name' => $castDetails['name'], 'dob' => $castDetails['birthday'], 'type'=> $type],
                            [
                                'name' => $castDetails['name'],
                                'type' =>$type,
                                'tmdb_id' => $tmdb_id, 
                                'file_url' => !empty($castDetails['profile_path']) 
                                ? $configurationData['images']['secure_base_url'] . 'original' . $castDetails['profile_path'] 
                                : setDefaultImage($castDetails['profile_path']),
                            
                                'bio' => $castDetails['biography'],
                                'place_of_birth' => $castDetails['place_of_birth'],
                                'dob' => $castDetails['birthday'],
                                'designation' => null,
                            ]
                        );
                        $result[] = $castRecord->id;
                        $count++;
                    }
                }
            }
            return $result;
        }
    
        private function getCrewDetail($id)
        {
            $crewDetails = $this->movieRepository->getCastCrewDetail($id);
            $crewDetail = json_decode($crewDetails, true);
    
            while ($crewDetail === null) {
                $crewDetails = $this->movieRepository->getCastCrewDetail($id);
                $crewDetail = json_decode($crewDetails, true);
            }
            return $crewDetail;
        }
    
        private function processLanguage($movieDetail)
        {
            $language = null;
    
            if (isset($movieDetail['spoken_languages']) && is_array($movieDetail['spoken_languages'])) {
                $spoken_languages = $movieDetail['spoken_languages'];
                if (!empty($spoken_languages)) {
                    $first_language = $spoken_languages[0];
                    $language = $first_language['name'];
    
                    Constant::updateOrCreate(
                        ['name' => $language, 'type' => 'movie_language'],
                        [
                            'name' => $language,
                            'value' => strtolower($language),
                            'type' => 'movie_language',
                            'status' => 1,
                        ]
                    );
                }
            }
            return $language;
        }
    
        private function processGenres($genres)
        {
            $genersIds = [];
            foreach ($genres as $genre) {
                $slug = Str::slug($genre['name'], '-');
                $genreRecord = Genres::updateOrCreate(
                    ['name' => $genre['name']],
                    ['name' => $genre['name'],
                    'slug' => $slug,
                     'status' => 1
                     ]
                );
                $genersIds[] = $genreRecord->id;
            }
            return $genersIds;
        }
    
        private function processVideoData($movieVideoDetail)
        {
            $trailer_url_type = null;
            $trailer_url = null;
            $moive_list = [];

            $video_url_type=null;
            $video_url=null;
    
            if (isset($movieVideoDetail['results']) && is_array($movieVideoDetail['results'])) {
                foreach ($movieVideoDetail['results'] as $video) {
                    if ($video['type'] == 'Trailer') {
                        $trailer_url_type = $video['site'];
                        $trailer_url = 'https://www.youtube.com/watch?v=' . $video['key'];
                    } else {

                        $video_url_type=$video['site'];
                        $video_url='https://www.youtube.com/watch?v='.$video['key'];

                        $moive_list[] = [
                            'video_quality_type' => $video['site'],
                            'video_quality' => $video['size'],
                            'quality_video' => 'https://www.youtube.com/watch?v=' . $video['key'],
                        ];
                    }
                }
            }

            return ['trailer_url_type' => $trailer_url_type, 'trailer_url' => $trailer_url, 'moive_list' => $moive_list ,'video_url_type'=> $video_url_type,'video_url'=>$video_url];
        }
    
        private function formatDuration($minutes)
        {
            $hours = floor($minutes / 60);
            $minutes = $minutes % 60;
            return sprintf('%02d:%02d', $hours, $minutes);
        }


  }
    


   
 
