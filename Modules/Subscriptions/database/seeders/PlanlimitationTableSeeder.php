<?php

namespace Modules\Subscriptions\database\seeders;

use Illuminate\Database\Seeder;

class PlanlimitationTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('planlimitation')->delete();
        
        \DB::table('planlimitation')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'Video Cast',
                'slug' => 'video-cast',
                'description' => 'Enhance your viewing experience with our Video Cast feature. Seamlessly stream your favorite shows and movies from your device to your TV or other compatible screens. Enjoy high-quality playback and easy controls for a truly immersive entertainment experience.',
                'status' => 1,
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_by' => NULL,
                'created_at' => '2024-07-10 11:13:04',
                'updated_at' => '2024-07-10 11:13:04',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'Ads',
                'slug' => 'ads',
                'description' => 'Discover a new way to enjoy content with minimal interruptions through our Ads feature. Our strategically placed advertisements are designed to provide relevant and engaging information without overwhelming your viewing experience.',
                'status' => 1,
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_by' => NULL,
                'created_at' => '2024-07-10 11:14:45',
                'updated_at' => '2024-07-10 11:14:45',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'title' => 'Device Limit',
                'slug' => 'device-limit',
                'description' => 'Manage your device connections effortlessly with our Device Limit feature. Easily monitor and control the number of devices linked to your account, ensuring a secure and personalized streaming experience.',
                'status' => 1,
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_by' => NULL,
                'created_at' => '2024-07-10 11:16:10',
                'updated_at' => '2024-07-10 11:16:10',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'title' => 'Download Status',
                'slug' => 'download-status',
                'description' => 'Keep track of your content downloads with our Download Status feature. View the progress of your current downloads, check completed files, and manage your storage efficiently. This feature provides real-time updates, allowing you to pause, resume, or cancel downloads as needed, ensuring you have access to your favorite content anytime, even offline.',
                'status' => 1,
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_by' => NULL,
                'created_at' => '2024-07-10 11:17:41',
                'updated_at' => '2024-07-10 11:17:41',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'title' => 'Supported Device Type',
                'slug' => 'supported-device-type',
                'description' => 'Our platform supports a wide range of devices including smartphones, tablets, smart TVs, and gaming consoles. Enjoy seamless streaming on any device with optimized performance and high-quality playback.',
                'status' => 1,
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_by' => NULL,
                'created_at' => '2024-07-10 11:20:00',
                'updated_at' => '2024-07-10 11:20:00',
                'deleted_at' => NULL,
            ),
            array(
                'id' => 6,
                'title' => 'Profile Limit',
                'slug' => 'profile-limit',
                'description' => 'Manage and customize your streaming experience with our Profile Limit feature. Set limits on the number of profiles that can be created under a single account, ensuring each user enjoys a personalized experience while keeping account usage within your preferred parameters.',
                'status' => 1,
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_by' => NULL,
                'created_at' => '2024-09-19 12:00:00',
                'updated_at' => '2024-09-19 12:00:00',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}