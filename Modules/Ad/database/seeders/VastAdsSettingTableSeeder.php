<?php

namespace Modules\Ad\database\seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class VastAdsSettingTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
    

        \DB::table('vast_ads_setting')->delete();
        
        \DB::table('vast_ads_setting')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'BigSale',
                'type' => 'pre-roll',
                'url' => 'https://basil79.github.io/vast-sample-tags/pg/vast.xml',
                'duration' => NULL,
                'target_type' => 'movie',
                'target_selection' => '[22,23,25,26,28,94,95,96]',
                'enable_skip' => 0,
                'skip_after' => NULL,
                'frequency' => NULL,
                'start_date' => Carbon::today()->toDateString(),
                'end_date' => Carbon::today()->copy()->addYear()->toDateString(),
                'is_enable' => 0,
                'status' => 1,
                'created_at' => '2025-07-25 06:04:17',
                'updated_at' => '2025-07-25 06:04:17',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'MovieTicket',
                'type' => 'mid-roll',
                'url' => 'https://basil79.github.io/vast-sample-tags/pg/vast.xml',
                'duration' => NULL,
                'target_type' => 'movie',
                'target_selection' => '[22,23,25,26,28,94,95,96]',
                'enable_skip' => 0,
                'skip_after' => NULL,
                'frequency' => NULL,
                'start_date' => Carbon::today()->toDateString(),
                'end_date' => Carbon::today()->copy()->addYear()->toDateString(),
                'is_enable' => 0,
                'status' => 1,
                'created_at' => '2025-07-25 06:06:03',
                'updated_at' => '2025-07-25 06:06:03',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'EpisodePromo',
                'type' => 'post-roll',
                'url' => 'https://basil79.github.io/vast-sample-tags/pg/vast.xml',
                'duration' => NULL,
                'target_type' => 'movie',
                'target_selection' => '[22,23,25,26,28,94,95,96]',
                'enable_skip' => 0,
                'skip_after' => NULL,
                'frequency' => NULL,
                'start_date' => Carbon::today()->toDateString(),
                'end_date' => Carbon::today()->copy()->addYear()->toDateString(),
                'is_enable' => 0,
                'status' => 1,
                'created_at' => '2025-07-25 06:07:32',
                'updated_at' => '2025-07-25 06:07:32',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'ServicePromo',
                'type' => 'overlay',
                'url' => 'https://raw.githubusercontent.com/InteractiveAdvertisingBureau/VAST_Samples/master/VAST%203.0%20Samples/Inline_Non-Linear_Tag-test.xml',
                'duration' => NULL,
                'target_type' => 'movie',
                'target_selection' => '[22,23,25,26,28,94,95,96]',
                'enable_skip' => 0,
                'skip_after' => NULL,
                'frequency' => NULL,
                'start_date' => Carbon::today()->toDateString(),
                'end_date' => Carbon::today()->copy()->addYear()->toDateString(),
                'is_enable' => 0,
                'status' => 1,
                'created_at' => '2025-07-25 06:09:01',
                'updated_at' => '2025-07-25 06:09:01',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'BigSale',
                'type' => 'pre-roll',
                'url' => 'https://basil79.github.io/vast-sample-tags/pg/vast.xml',
                'duration' => NULL,
                'target_type' => 'video',
                'target_selection' => '[1,2,3,4,5,17,26]',
                'enable_skip' => 0,
                'skip_after' => NULL,
                'frequency' => NULL,
                'start_date' => Carbon::today()->toDateString(),
                'end_date' => Carbon::today()->copy()->addYear()->toDateString(),
                'is_enable' => 0,
                'status' => 1,
                'created_at' => '2025-07-25 06:11:03',
                'updated_at' => '2025-07-25 06:11:03',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'MovieTicket',
                'type' => 'mid-roll',
                'url' => 'https://basil79.github.io/vast-sample-tags/pg/vast.xml',
                'duration' => NULL,
                'target_type' => 'video',
                'target_selection' => '[1,2,3,4,5,17,26]',
                'enable_skip' => 0,
                'skip_after' => NULL,
                'frequency' => NULL,
                'start_date' => Carbon::today()->toDateString(),
                'end_date' => Carbon::today()->copy()->addYear()->toDateString(),
                'is_enable' => 0,
                'status' => 1,
                'created_at' => '2025-07-25 06:12:26',
                'updated_at' => '2025-07-25 06:12:26',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'EpisodePromo',
                'type' => 'post-roll',
                'url' => 'https://basil79.github.io/vast-sample-tags/pg/vast.xml',
                'duration' => NULL,
                'target_type' => 'video',
                'target_selection' => '[1,2,3,4,5,17,26]',
                'enable_skip' => 0,
                'skip_after' => NULL,
                'frequency' => NULL,
                'start_date' => Carbon::today()->toDateString(),
                'end_date' => Carbon::today()->copy()->addYear()->toDateString(),
                'is_enable' => 0,
                'status' => 1,
                'created_at' => '2025-07-25 06:13:38',
                'updated_at' => '2025-07-25 06:13:38',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'ServicePromo',
                'type' => 'overlay',
                'url' => 'https://raw.githubusercontent.com/InteractiveAdvertisingBureau/VAST_Samples/master/VAST%203.0%20Samples/Inline_Non-Linear_Tag-test.xml',
                'duration' => NULL,
                'target_type' => 'video',
                'target_selection' => '[1,2,3,4,5,17,26]',
                'enable_skip' => 0,
                'skip_after' => NULL,
                'frequency' => NULL,
                'start_date' => Carbon::today()->toDateString(),
                'end_date' => Carbon::today()->copy()->addYear()->toDateString(),
                'is_enable' => 0,
                'status' => 1,
                'created_at' => '2025-07-25 06:17:56',
                'updated_at' => '2025-07-25 06:17:56',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'BigSale',
                'type' => 'pre-roll',
                'url' => 'https://basil79.github.io/vast-sample-tags/pg/vast.xml',
                'duration' => NULL,
                'target_type' => 'tvshow',
                'target_selection' => '[1,2,3,11,12,23,24,25]',
                'enable_skip' => 0,
                'skip_after' => NULL,
                'frequency' => NULL,
                'start_date' => Carbon::today()->toDateString(),
                'end_date' => Carbon::today()->copy()->addYear()->toDateString(),
                'is_enable' => 0,
                'status' => 1,
                'created_at' => '2025-07-25 06:19:54',
                'updated_at' => '2025-07-25 06:19:54',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'MovieTicket',
                'type' => 'mid-roll',
                'url' => 'https://basil79.github.io/vast-sample-tags/pg/vast.xml',
                'duration' => NULL,
                'target_type' => 'tvshow',
                'target_selection' => '[1,2,3,11,12,23,24,25]',
                'enable_skip' => 0,
                'skip_after' => NULL,
                'frequency' => NULL,
                'start_date' => Carbon::today()->toDateString(),
                'end_date' => Carbon::today()->copy()->addYear()->toDateString(), 
                'is_enable' => 0,
                'status' => 1,
                'created_at' => '2025-07-25 06:21:34',
                'updated_at' => '2025-07-25 06:21:34',
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'EpisodePromo',
                'type' => 'post-roll',
                'url' => 'https://basil79.github.io/vast-sample-tags/pg/vast.xml',
                'duration' => NULL,
                'target_type' => 'tvshow',
                'target_selection' => '[1,2,3,11,12,23,24,25]',
                'enable_skip' => 0,
                'skip_after' => NULL,
                'frequency' => NULL,
                'start_date' => Carbon::today()->toDateString(),
                'end_date' => Carbon::today()->copy()->addYear()->toDateString(),                
                'is_enable' => 0,
                'status' => 1,
                'created_at' => '2025-07-25 06:23:06',
                'updated_at' => '2025-07-25 06:23:06',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}