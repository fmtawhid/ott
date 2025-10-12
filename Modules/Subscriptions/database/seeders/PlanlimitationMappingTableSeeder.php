<?php

namespace Modules\Subscriptions\database\seeders;

use Illuminate\Database\Seeder;

class PlanlimitationMappingTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('planlimitation_mapping')->delete();

        \DB::table('planlimitation_mapping')->insert(array (
            0 =>
            array (
                'id' => 1,
                'plan_id' => 1,
                'planlimitation_id' => 1,
                'limitation_slug' => 'video-cast',
                'limitation_value' => 1,
                'limit' => NULL,
            ),
            1 =>
            array (
                'id' => 2,
                'plan_id' => 1,
                'planlimitation_id' => 2,
                'limitation_slug' => 'ads',
                'limitation_value' => 1,
                'limit' => NULL,
            ),
            2 =>
            array (
                'id' => 3,
                'plan_id' => 1,
                'planlimitation_id' => 3,
                'limitation_slug' => 'device-limit',
                'limitation_value' => 1,
                'limit' => '1',
            ),
            3 =>
            array (
                'id' => 4,
                'plan_id' => 1,
                'planlimitation_id' => 4,
                'limitation_slug' => 'download-status',
                'limitation_value' => 1,
                'limit' => '{"480p":1,"720p":1,"1080p":1,"1440p":0,"2K":0,"4K":0,"8K":0}',
            ),
            4 =>
            array (
                'id' => 5,
                'plan_id' => 2,
                'planlimitation_id' => 1,
                'limitation_slug' => 'video-cast',
                'limitation_value' => 1,
                'limit' => NULL,
            ),
            5 =>
            array (
                'id' => 6,
                'plan_id' => 2,
                'planlimitation_id' => 2,
                'limitation_slug' => 'ads',
                'limitation_value' => 0,
                'limit' => NULL,
            ),
            6 =>
            array (
                'id' => 7,
                'plan_id' => 2,
                'planlimitation_id' => 3,
                'limitation_slug' => 'device-limit',
                'limitation_value' => 1,
                'limit' => '2',
            ),
            7 =>
            array (
                'id' => 8,
                'plan_id' => 2,
                'planlimitation_id' => 4,
                'limitation_slug' => 'download-status',
                'limitation_value' => 1,
                'limit' => '{"480p":1,"720p":1,"1080p":1,"1440p":1,"2K":0,"4K":0,"8K":0}',
            ),
            8 =>
            array (
                'id' => 9,
                'plan_id' => 3,
                'planlimitation_id' => 1,
                'limitation_slug' => 'video-cast',
                'limitation_value' => 1,
                'limit' => NULL,
            ),
            9 =>
            array (
                'id' => 10,
                'plan_id' => 3,
                'planlimitation_id' => 2,
                'limitation_slug' => 'ads',
                'limitation_value' => 0,
                'limit' => NULL,
            ),
            10 =>
            array (
                'id' => 11,
                'plan_id' => 3,
                'planlimitation_id' => 3,
                'limitation_slug' => 'device-limit',
                'limitation_value' => 1,
                'limit' => '5',
            ),
            11 =>
            array (
                'id' => 12,
                'plan_id' => 3,
                'planlimitation_id' => 4,
                'limitation_slug' => 'download-status',
                'limitation_value' => 1,
                'limit' => '{"480p":1,"720p":1,"1080p":1,"1440p":1,"2K":1,"4K":0,"8K":0}',
            ),
            12 =>
            array (
                'id' => 13,
                'plan_id' => 4,
                'planlimitation_id' => 1,
                'limitation_slug' => 'video-cast',
                'limitation_value' => 1,
                'limit' => NULL,
            ),
            13 =>
            array (
                'id' => 14,
                'plan_id' => 4,
                'planlimitation_id' => 2,
                'limitation_slug' => 'ads',
                'limitation_value' => 0,
                'limit' => NULL,
            ),
            14 =>
            array (
                'id' => 15,
                'plan_id' => 4,
                'planlimitation_id' => 3,
                'limitation_slug' => 'device-limit',
                'limitation_value' => 1,
                'limit' => '8',
            ),
            15 =>
            array (
                'id' => 16,
                'plan_id' => 4,
                'planlimitation_id' => 4,
                'limitation_slug' => 'download-status',
                'limitation_value' => 1,
                'limit' => '{"480p":1,"720p":1,"1080p":1,"1440p":1,"2K":1,"4K":1,"8K":1}',
            ),
            16 =>
            array (
                'id' => 17,
                'plan_id' => 1,
                'planlimitation_id' => 5,
                'limitation_slug' => 'supported-device-type',
                'limitation_value' => 1,
                'limit' => '{"tablet":"0","laptop":"0","mobile":"1","tv":"0"}',
            ),

            17 =>
            array (
                'id' => 18,
                'plan_id' => 1,
                'planlimitation_id' => 6,
                'limitation_slug' => 'profile-limit',
                'limitation_value' => 1,
                'limit' => 2,
            ),
            18 =>
            array (
                'id' => 19,
                'plan_id' => 2,
                'planlimitation_id' => 5,
                'limitation_slug' => 'supported-device-type',
                'limitation_value' => 1,
                'limit' => '{"tablet":"1","laptop":"0","mobile":"1","tv":"0"}',
            ),

            19 =>
            array (
                'id' => 20,
                'plan_id' => 2,
                'planlimitation_id' => 6,
                'limitation_slug' => 'profile-limit',
                'limitation_value' => 1,
                'limit' => 3,
            ),
            20 =>
            array (
                'id' => 21,
                'plan_id' => 3,
                'planlimitation_id' => 5,
                'limitation_slug' => 'supported-device-type',
                'limitation_value' => 1,
                'limit' => '{"tablet":"0","laptop":"1","mobile":"1","tv":"1"}',
            ),

            21 =>
            array (
                'id' => 22,
                'plan_id' => 3,
                'planlimitation_id' => 6,
                'limitation_slug' => 'profile-limit',
                'limitation_value' => 1,
                'limit' => 3,
            ),
            22 =>
            array (
                'id' => 23,
                'plan_id' => 4,
                'planlimitation_id' => 5,
                'limitation_slug' => 'supported-device-type',
                'limitation_value' => 1,
                'limit' => '{"tablet":"1","laptop":"1","mobile":"1","tv":"1"}',
            ),

            23 =>
            array (
                'id' => 24,
                'plan_id' => 4,
                'planlimitation_id' => 6,
                'limitation_slug' => 'profile-limit',
                'limitation_value' => 1,
                'limit' => 4,
            ),
        ));


    }
}
