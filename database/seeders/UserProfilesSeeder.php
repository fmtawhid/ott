<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserProfilesSeeder extends Seeder

{
    public function run()
    {
        // Clear existing data
        \DB::table('user_profiles')->delete();
        
        // Insert new data
        \DB::table('user_profiles')->insert([
            [
                'user_id' => 1, 
                'about_self' => 'I am a passionate developer.',
                'expert' => 'Web Development',
                'facebook_link' => 'https://facebook.com/user1',
                'instagram_link' => 'https://instagram.com/user1',
                'twitter_link' => 'https://twitter.com/user1',
                'dribbble_link' => 'https://dribbble.com/user1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2, 
                'about_self' => 'Love creating content and engaging with my audience.',
                'expert' => 'Content Creation',
                'facebook_link' => 'https://facebook.com/user2',
                'instagram_link' => 'https://instagram.com/user2',
                'twitter_link' => 'https://twitter.com/user2',
                'dribbble_link' => 'https://dribbble.com/user2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3, 
                'about_self' => 'Tech enthusiast and blogger.',
                'expert' => 'Tech Blogging',
                'facebook_link' => 'https://facebook.com/user3',
                'instagram_link' => 'https://instagram.com/user3',
                'twitter_link' => 'https://twitter.com/user3',
                'dribbble_link' => 'https://dribbble.com/user3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more profiles as needed
        ]);
    }
}
