<?php

namespace Modules\Constant\database\seeders;

use Illuminate\Database\Seeder;
use Modules\Constant\Models\Constant;
use Illuminate\Support\Facades\DB;

class ConstantDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Disable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        /*
         * Constants Seed
         * ------------------
         */
        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $arr1 = [
         

            [
                'type' => 'language',
                'value' => 'en',
                'name' => 'English',
                'sequence' => 1,
            ],
            [
                'type' => 'language',
                'value' => 'br',
                'name' => 'বাংলা',
                'sequence' => 2,
            ],
            [
                'type' => 'language',
                'value' => 'ar',
                'name' => 'العربی',
                'sequence' => 3,
            ],
            [
                'type' => 'language',
                'value' => 'vi',
                'name' => 'Vietnamese',
                'sequence' => 4,
            ],
           
        
            [
                'type' => 'PAYMENT_STATUS',
                'name' => 'Paid',
                'value' => '1',
            ],

            [
                'type' => 'PAYMENT_STATUS',
                'name' => 'Pending',
                'value' => '0',
            ],

            [
                'type' => 'PAYMENT_STATUS',
                'name' => 'Pending',
                'value' => '0',
            ],


            [
                'type' => 'upload_type',
                'name' => 'Local',
                'value' => 'Local',
            ],
            [
                'type' => 'upload_type',
                'name' => 'URL',
                'value' => 'URL',
            ],
            [
                'type' => 'upload_type',
                'name' => 'YouTube',
                'value' => 'YouTube',
            ],
            [
                'type' => 'upload_type',
                'name' => 'HLS',
                'value' => 'HLS',
            ],
            [
                'type' => 'upload_type',
                'name' => 'Vimeo',
                'value' => 'Vimeo',
            ],
            [
                'type' => 'upload_type',
                'name' => 'x265',
                'value' => 'x265',
            ],
            [
                'type' => 'movie_language',
                'name' => 'English',
                'value' => 'english',
            ],

            [
                'type' => 'movie_language',
                'name' => 'Hindi',
                'value' => 'hindi',
            ],

            [
                'type' => 'movie_language',
                'name' => 'Tamil',
                'value' => 'tamil',
            ],


            [
                'type' => 'movie_language',
                'name' => 'Telugu',
                'value' => 'telugu',
            ],

            [
                'type' => 'movie_language',
                'name' => 'Malayalam',
                'value' => 'malayalam',
            ],
            [
                'type' => 'movie_language',
                'name' => 'Spanish',
                'value' => 'spanish',
            ],
            [
                'type' => 'movie_language',
                'name' => 'French',
                'value' => 'french',
            ],
            [
                'type' => 'movie_language',
                'name' => 'Arabic',
                'value' => 'arabic',
            ],
            [
                'type' => 'movie_language',
                'name' => 'German',
                'value' => 'german',
            ],
            [
                'type' => 'video_quality',
                'name' => '480p',
                'value' => '480p',
            ],

            [
                'type' => 'video_quality',
                'name' => '720p',
                'value' => '720p',
            ],

            [
                'type' => 'video_quality',
                'name' => '1080p',
                'value' => '1080p',
            ],
            [
                'type' => 'video_quality',
                'name' => '1440p',
                'value' => '1440p',
            ],
            [
                'type' => 'video_quality',
                'name' => '2K',
                'value' => '2K',
            ],
            [
                'type' => 'video_quality',
                'name' => '4K',
                'value' => '4K',
            ],
            [
                'type' => 'video_quality',
                'name' => '8K',
                'value' => '8K',
            ],
            [
                'type' => 'STREAM_TYPE',
                'name' => 'URL',
                'value' => 'URL',
            ],
            [
                'type' => 'STREAM_TYPE',
                'name' => 'YouTube',
                'value' => 'YouTube',
            ],
            [
                'type' => 'STREAM_TYPE',
                'name' => 'HLS',
                'value' => 'HLS',
            ],
            [
                'type' => 'STREAM_TYPE',
                'name' => 'Vimeo',
                'value' => 'Vimeo',
            ],
            [
                'type' => 'STREAM_TYPE',
                'name' => 'Embedded',
                'value' => 'Embedded',
            ],
            [
                'type' => 'STREAM_TYPE',
                'name' => 'x265',
                'value' => 'x265',
            ],


            [
                'type' => 'subtitle_language',
                'value' => 'en',
                'name' => 'English',
                'sequence' => 1,
            ],
            [
                'type' => 'subtitle_language',
                'value' => 'fr',
                'name' => 'French',
                'sequence' => 2,
            ],
            [
                'type' => 'subtitle_language',
                'value' => 'ar',
                'name' => 'Arebic',
                'sequence' => 3,
            ],
            [
                'type' => 'subtitle_language',
                'value' => 'vi',
                'name' => 'Vietnamese',
                'sequence' => 4,
            ],
            [
                'type' => 'subtitle_language',
                'value' => 'es',
                'name' => 'Spanish',
                'sequence' => 5,
            ],
            [
                'type' => 'subtitle_language',
                'value' => 'nl',
                'name' => 'Dutch',
                'sequence' => 7,
            ],
            [
                'type' => 'subtitle_language',
                'value' => 'pt',
                'name' => 'Portuguese',
                'sequence' => 6,
            ],
           
            
        ];

        foreach ($arr1 as $key => $val) {
            Constant::create($val);
        }
    }
}
