<?php

namespace Modules\Ad\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;
use Modules\Ad\Models\CustomAdsSetting;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class CustomAdsSettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        $customads = [
            [
                'id' => 1,
                'name' => 'BigSale',
                'type' => 'image',
                'url_type' => 'local',
                'placement' => 'home_page',
                'media' => '/dummy-images/ads/pexels-kyle-loftus-1280314238-32439172.jpg',
                'redirect_url' => NULL,
                'duration' => NULL,
                'skip_enabled' => 0,
                'skip_after' => NULL,
                'target_content_type' => NULL,
                'target_categories' => '[]',
                'max_views' => NULL,
                'is_enable' => 0,
                'status' => 1,
                'start_date' => Carbon::today()->toDateString(),
                'end_date' =>Carbon::today()->copy()->addYear()->toDateString() ,
                'created_at' => '2025-08-12 07:38:23',
                'updated_at' => '2025-08-12 07:38:23',
                'deleted_at' => NULL,
            ],
            [
                'id' => 2,
                'name' => 'MovieTicket',
                'type' => 'image',
                'url_type' => 'local',
                'placement' => 'home_page',
                'media' => '/dummy-images/ads/pexels-kyle-loftus-1280314238-32439172.jpg',
                'redirect_url' => NULL,
                'duration' => NULL,
                'skip_enabled' => 0,
                'skip_after' => NULL,
                'target_content_type' => NULL,
                'target_categories' => '[]',
                'max_views' => NULL,
                'is_enable' => 0,
                'status' => 1,
                'start_date' => Carbon::today()->toDateString(),
                'end_date' =>Carbon::today()->copy()->addYear()->toDateString() ,
                'created_at' => '2025-08-12 07:39:08',
                'updated_at' => '2025-08-12 07:39:08',
                'deleted_at' => NULL,
            ],
            [
                'id' => 3,
                'name' => 'EpisodePromo',
                'type' => 'image',
                'url_type' => 'local',
                'placement' => 'home_page',
                'media' => '/dummy-images/ads/pexels-minhle17vn-3062545.jpg',
                'redirect_url' => NULL,
                'duration' => NULL,
                'skip_enabled' => 0,
                'skip_after' => NULL,
                'target_content_type' => NULL,
                'target_categories' => '[]',
                'max_views' => NULL,
                'is_enable' => 0,
                'status' => 1,
                'start_date' => Carbon::today()->toDateString(),
                'end_date' =>Carbon::today()->copy()->addYear()->toDateString() ,
                'created_at' => '2025-08-12 07:40:35',
                'updated_at' => '2025-08-12 07:40:35',
                'deleted_at' => NULL,
            ],
            [
                'id' => 4,
                'name' => 'ServicePromo',
                'type' => 'image',
                'url_type' => 'local',
                'placement' => 'home_page',
                'media' => '/dummy-images/ads/pexels-ron-lach-9627162.jpg',
                'redirect_url' => NULL,
                'duration' => NULL,
                'skip_enabled' => 0,
                'skip_after' => NULL,
                'target_content_type' => NULL,
                'target_categories' => '[]',
                'max_views' => NULL,
                'is_enable' => 0,
                'status' => 1,
                'start_date' => Carbon::today()->toDateString(),
                'end_date' =>Carbon::today()->copy()->addYear()->toDateString() ,
                'created_at' => '2025-08-12 07:41:21',
                'updated_at' => '2025-08-12 07:41:21',
                'deleted_at' => NULL,
            ],
            [
                'id' => 5,
                'name' => 'GamingEvent',
                'type' => 'image',
                'url_type' => 'local',
                'placement' => 'player',
                'media' => '/dummy-images/ads/pexels-ron-lach-9627169.jpg',
                'redirect_url' => NULL,
                'duration' => NULL,
                'skip_enabled' => 0,
                'skip_after' => NULL,
                'target_content_type' => 'movie',
                'target_categories' => '[29,31,34,36,42,83]',
                'max_views' => NULL,
                'is_enable' => 0,
                'status' => 1,
                'start_date' => Carbon::today()->toDateString(),
                'end_date' =>Carbon::today()->copy()->addYear()->toDateString() ,
                'created_at' => '2025-08-12 07:43:53',
                'updated_at' => '2025-08-12 07:43:53',
                'deleted_at' => NULL,
            ],
            [
                'id' => 6,
                'name' => 'FashionLine',
                'type' => 'image',
                'url_type' => 'local',
                'placement' => 'player',
                'media' => '/dummy-images/ads/pexels-minhle17vn-3062545.jpg',
                'redirect_url' => NULL,
                'duration' => NULL,
                'skip_enabled' => 0,
                'skip_after' => NULL,
                'target_content_type' => 'video',
                'target_categories' => '[7,8,9,11,31,32,33,34]',
                'max_views' => NULL,
                'is_enable' => 0,
                'status' => 1,
                'start_date' => Carbon::today()->toDateString(),
                'end_date' =>Carbon::today()->copy()->addYear()->toDateString() ,
                'created_at' => '2025-08-12 07:51:40',
                'updated_at' => '2025-08-12 07:51:40',
                'deleted_at' => NULL,
            ],
            [
                'id' => 7,
                'name' => 'NewMusicAlbum',
                'type' => 'image',
                'url_type' => 'local',
                'placement' => 'banner',
                'media' => '/dummy-images/ads/pexels-kyle-loftus-1280314238-32439172.jpg',
                'redirect_url' => NULL,
                'duration' => NULL,
                'skip_enabled' => 0,
                'skip_after' => NULL,
                'target_content_type' => 'movie',
                'target_categories' => '[88,89,91,103]',
                'max_views' => NULL,
                'is_enable' => 0,
                'status' => 1,
                'start_date' => Carbon::today()->toDateString(),
                'end_date' =>Carbon::today()->copy()->addYear()->toDateString() ,
                'created_at' => '2025-08-12 07:53:36',
                'updated_at' => '2025-08-12 07:53:36',
                'deleted_at' => NULL,
            ],
            [
                'id' => 8,
                'name' => 'StreamingSvc',
                'type' => 'image',
                'url_type' => 'local',
                'placement' => 'banner',
                'media' => '/dummy-images/ads/pexels-ron-lach-9627169.jpg',
                'redirect_url' => NULL,
                'duration' => NULL,
                'skip_enabled' => 0,
                'skip_after' => NULL,
                'target_content_type' => 'video',
                'target_categories' => '[12,15,16]',
                'max_views' => NULL,
                'is_enable' => 0,
                'status' => 1,
                'start_date' => Carbon::today()->toDateString(),
                'end_date' =>Carbon::today()->copy()->addYear()->toDateString() ,
                'created_at' => '2025-08-12 07:55:05',
                'updated_at' => '2025-08-12 07:55:05',
                'deleted_at' => NULL,
            ],
            [
                'id' => 9,
                'name' => 'GamingPromo',
                'type' => 'image',
                'url_type' => 'local',
                'placement' => 'banner',
                'media' => '/dummy-images/ads/pexels-ron-lach-9627162.jpg',
                'redirect_url' => NULL,
                'duration' => NULL,
                'skip_enabled' => 0,
                'skip_after' => NULL,
                'target_content_type' => 'tvshow',
                'target_categories' => '[15,16,21,22]',
                'max_views' => NULL,
                'is_enable' => 0,
                'status' => 1,
                'start_date' => Carbon::today()->toDateString(),
                'end_date' =>Carbon::today()->copy()->addYear()->toDateString() ,
                'created_at' => '2025-08-12 07:56:26',
                'updated_at' => '2025-08-12 07:56:26',
                'deleted_at' => NULL,
            ],
        ];


        if (env('IS_DUMMY_DATA')) {
            foreach ($customads as $mediaData) {
                $custom = CustomAdsSetting::create($mediaData);
                 if ($mediaData['url_type'] == 'local') {
                    $uploadedUrl = $this->uploadToSpaces($mediaData['media']);

                    if ($uploadedUrl) {
                       $custom->media = extractFileNameFromUrl($uploadedUrl);
                       $custom->save();
                    }
                }
            }

            Schema::enableForeignKeyConstraints();
        }
    }

    private function uploadToSpaces($publicPath)
    {
        $localFilePath = public_path($publicPath);
        $remoteFilePath = 'streamit-laravel/' . basename($publicPath);
        if (file_exists($localFilePath)) {
            $disk = env('ACTIVE_STORAGE', 'local');

            if ($disk === 'local') {
                Storage::disk($disk)->put('public/' . $remoteFilePath, file_get_contents($localFilePath));
                return asset('storage/' . $remoteFilePath);
            } else {
                Storage::disk($disk)->put($remoteFilePath, file_get_contents($localFilePath));
                return Storage::disk($disk)->url($remoteFilePath);
            }
        }

        return false;
    }
}
