<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MobileSettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

      if(env('IS_DUMMY_DATA')==false){


            \DB::table('mobile_settings')->delete();

        \DB::table('mobile_settings')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'Banner',
                'slug' => 'banner',
                'position' => 1,
                'value' => '1',
                'created_at' => '2024-07-12 10:28:06',
                'updated_at' => '2024-07-12 10:28:06',
                'deleted_at' => NULL,
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'Continue Watching',
                'slug' => 'continue-watching',
                'position' => 2,
                'value' => '1',
                'created_at' => '2024-07-12 10:28:21',
                'updated_at' => '2024-07-12 10:28:21',
                'deleted_at' => NULL,
            ),
            2 =>
            array (
                'id' => 3,
                'name' => 'Top 10',
                'slug' => 'top-10',
                'position' => 3,
                'value' => null,
                'created_at' => '2024-07-12 10:28:33',
                'updated_at' => '2024-07-12 10:43:17',
                'deleted_at' => NULL,
            ),
            3 =>
            array (
                'id' => 4,
                'name' => 'Advertisement',
                'slug' => 'advertisement',
                'position' => 4,
                'value' => '1',
                'created_at' => '2024-07-12 10:28:47',
                'updated_at' => '2024-07-12 10:28:47',
                'deleted_at' => NULL,
            ),
            4 =>
            array (
                'id' => 5,
                'name' => 'Latest Movies',
                'slug' => 'latest-movies',
                'position' => 5,
                'value' => null,
                'created_at' => '2024-07-12 10:29:02',
                'updated_at' => '2024-07-12 10:44:11',
                'deleted_at' => NULL,
            ),
            5 =>
            array (
                'id' => 6,
                'name' => 'Popular language',
                'slug' => 'enjoy-in-your-native-tongue',
                'position' => 6,
                'value' => null,
                'created_at' => '2024-07-12 10:29:20',
                'updated_at' => '2024-07-12 10:33:08',
                'deleted_at' => NULL,
            ),
            6 =>
            array (
                'id' => 7,
                'name' => 'Popular Movies',
                'slug' => 'popular-movies',
                'position' => 7,
                'value' => null,
                'created_at' => '2024-07-12 10:29:36',
                'updated_at' => '2024-07-12 10:48:33',
                'deleted_at' => NULL,
            ),
            7 =>
            array (
                'id' => 8,
                'name' => 'Top Channels',
                'slug' => 'top-channels',
                'position' => 8,
                'value' => null,
                'created_at' => '2024-07-12 10:30:54',
                'updated_at' => '2024-07-12 10:30:54',
                'deleted_at' => NULL,
            ),
            8 =>
            array (
                'id' => 9,
                'name' => 'Popular Personalities',
                'slug' => 'your-favorite-personality',
                'position' => 9,
                'value' => null,
                'created_at' => '2024-07-12 10:31:08',
                'updated_at' => '2024-07-12 10:47:13',
                'deleted_at' => NULL,
            ),
            9 =>
            array (
                'id' => 10,
                'name' => 'Free Movies',
                'slug' => '500-free-movies',
                'position' => 10,
                'value' => null,
                'created_at' => '2024-07-12 10:31:38',
                'updated_at' => '2024-07-12 10:47:34',
                'deleted_at' => NULL,
            ),
            10 =>
            array (
                'id' => 11,
                'name' => 'Genres',
                'slug' => 'genre',
                'position' => 11,
                'value' => null,
                'created_at' => '2024-07-12 10:31:52',
                'updated_at' => '2024-07-12 10:49:42',
                'deleted_at' => NULL,
            ),
            11 =>
            array (
                'id' => 12,
                'name' => 'Rate our app',
                'slug' => 'rate-our-app',
                'position' => 12,
                'value' => '1',
                'created_at' => '2024-07-12 10:32:08',
                'updated_at' => '2024-07-12 10:32:08',
                'deleted_at' => NULL,
            ),
            12 =>
            array (
                'id' => 13,
                'name' => 'Popular TV Show',
                'slug' => 'popular-tvshows',
                'position' => 13,
                'value' => null,
                'created_at' => '2024-07-12 10:29:36',
                'updated_at' => '2024-07-12 10:48:33',
                'deleted_at' => NULL,
            ),
            13 =>
            array (
                'id' => 14,
                'name' => 'Popular Videos',
                'slug' => 'popular-videos',
                'position' => 14,
                'value' => null,
                'created_at' => '2024-07-12 10:29:36',
                'updated_at' => '2024-07-12 10:48:33',
                'deleted_at' => NULL,
            ),
        ));

      }else{





        \DB::table('mobile_settings')->delete();

        \DB::table('mobile_settings')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'Banner',
                'slug' => 'banner',
                'position' => 1,
                'value' => '1',
                'created_at' => '2024-07-12 10:28:06',
                'updated_at' => '2024-07-12 10:28:06',
                'deleted_at' => NULL,
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'Continue Watching',
                'slug' => 'continue-watching',
                'position' => 2,
                'value' => '1',
                'created_at' => '2024-07-12 10:28:21',
                'updated_at' => '2024-07-12 10:28:21',
                'deleted_at' => NULL,
            ),
            2 =>
            array (
                'id' => 3,
                'name' => 'Top 10',
                'slug' => 'top-10',
                'position' => 3,
                'value' => '["35","69","22","49","76","89","94","95","99","102"]',
                'created_at' => '2024-07-12 10:28:33',
                'updated_at' => '2024-07-12 10:43:17',
                'deleted_at' => NULL,
            ),
            3 =>
            array (
                'id' => 4,
                'name' => 'Advertisement',
                'slug' => 'advertisement',
                'position' => 4,
                'value' => '1',
                'created_at' => '2024-07-12 10:28:47',
                'updated_at' => '2024-07-12 10:28:47',
                'deleted_at' => NULL,
            ),
            4 =>
            array (
                'id' => 5,
                'name' => 'Latest Movies',
                'slug' => 'latest-movies',
                'position' => 5,
                'value' => '["103","97","102","95","96","100","98","94"]',
                'created_at' => '2024-07-12 10:29:02',
                'updated_at' => '2024-07-12 10:44:11',
                'deleted_at' => NULL,
            ),
            5 =>
            array (
                'id' => 6,
                'name' => 'Popular language',
                'slug' => 'enjoy-in-your-native-tongue',
                'position' => 6,
                'value' => '["16","17","18","19","20" ,"21","22","23"]',
                'created_at' => '2024-07-12 10:29:20',
                'updated_at' => '2024-07-12 10:33:08',
                'deleted_at' => NULL,
            ),
            6 =>
            array (
                'id' => 7,
                'name' => 'Popular Movies',
                'slug' => 'popular-movies',
                'position' => 7,
                'value' => '["22","25","26","28","29","31","34","36","37","40","38"]',
                'created_at' => '2024-07-12 10:29:36',
                'updated_at' => '2024-07-12 10:48:33',
                'deleted_at' => NULL,
            ),
            7 =>
            array (
                'id' => 8,
                'name' => 'Top Channels',
                'slug' => 'top-channels',
                'position' => 8,
                'value' => '["1","2","3","4","5","6","7","8","9","10"]',
                'created_at' => '2024-07-12 10:30:54',
                'updated_at' => '2024-07-12 10:30:54',
                'deleted_at' => NULL,
            ),
            8 =>
            array (
                'id' => 9,
                'name' => 'Popular Personalities',
                'slug' => 'your-favorite-personality',
                'position' => 9,
                'value' => '["1","2","3","4","5","6","7","8","9","10"]',
                'created_at' => '2024-07-12 10:31:08',
                'updated_at' => '2024-07-12 10:47:13',
                'deleted_at' => NULL,
            ),
            9 =>
            array (
                'id' => 10,
                'name' => 'Free Movies',
                'slug' => '500-free-movies',
                'position' => 10,
                'value' => '["21","23","24","25","30","31","32","34","33","35"]',
                'created_at' => '2024-07-12 10:31:38',
                'updated_at' => '2024-07-12 10:47:34',
                'deleted_at' => NULL,
            ),
            10 =>
            array (
                'id' => 11,
                'name' => 'Genres',
                'slug' => 'genre',
                'position' => 11,
                'value' => '["1","2","3","4","5","6","7","8"]',
                'created_at' => '2024-07-12 10:31:52',
                'updated_at' => '2024-07-12 10:49:42',
                'deleted_at' => NULL,
            ),
            11 =>
            array (
                'id' => 12,
                'name' => 'Rate our app',
                'slug' => 'rate-our-app',
                'position' => 12,
                'value' => '1',
                'created_at' => '2024-07-12 10:32:08',
                'updated_at' => '2024-07-12 10:32:08',
                'deleted_at' => NULL,
            ),
            12 =>
            array (
                'id' => 13,
                'name' => 'Popular TV Show',
                'slug' => 'popular-tvshows',
                'position' => 13,
                'value' => '[4,6,1,2,3,8,10,12]',
                'created_at' => '2024-07-12 10:29:36',
                'updated_at' => '2024-07-12 10:48:33',
                'deleted_at' => NULL,
            ),
            13 =>
            array (
                'id' => 14,
                'name' => 'Popular Videos',
                'slug' => 'popular-videos',
                'position' => 14,
                'value' => '["1","2","3","4","5","12","14","15","17","18","19","20","25","35"]',
                'created_at' => '2024-07-12 10:29:36',
                'updated_at' => '2024-07-12 10:48:33',
                'deleted_at' => NULL,
            ),
        ));

      }


    }
}
