<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSearchHistoriesSeeder extends Seeder
{
    public function run()
    {
        // Clear the user_search_histories table
        \DB::table('user_search_histories')->delete();
        
        // Insert records into the user_search_histories table
        \DB::table('user_search_histories')->insert([
            [
                'user_id' => 3, 
                'profile_id' => 3, 
                'search_query' => 'Shadow Pursuit',
                'search_id' => 4, // Movie or TV show ID
                'type' => 'tvshow', // Type can be 'movie' or 'tv_show'
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3, 
                'profile_id' => 3, 
                'search_query' => 'Wolfbound',
                'search_id' => 8,
                'type' => 'tvshow',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3, 
                'profile_id' => 3, 
                'search_query' => 'Road to Reconnection',
                'search_id' => 14,
                'type' => 'tvshow',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 4, 
                'profile_id' => 4,
                'search_query' => 'The Daring Player',
                'search_id' => 27,
                'type' => 'movie',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3, 
                'profile_id' => 3,
                'search_query' => 'Legacy of Antiquity: Origins of Civilization',
                'search_id' => 36,
                'type' => 'movie',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3, 
                'profile_id' => 3,
                'search_query' => 'Guardians of the Abyss: The Beast Awakens',
                'search_id' => 46,
                'type' => 'tvshow',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 4, 
                'profile_id' => 4,
                'search_query' => 'Blade of Chaos',
                'search_id' => 52,
                'type' => 'movie',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3, 
                'profile_id' => 3,
                'search_query' => 'Echoes of Valor',
                'search_id' => 6,
                'type' => 'video',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3, 
                'profile_id' => 3,
                'search_query' => 'Warrior\'s Dilemma',
                'search_id' => 11,
                'type' => 'video',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3, 
                'profile_id' => 3,
                'search_query' => 'School Hacks & Fun DIY Crafts',
                'search_id' => 15,
                'type' => 'video',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 4, 
                'profile_id' => 4,
                'search_query' => 'Motel of Nightmares',
                'search_id' => 21,
                'type' => 'video',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 4, 
                'profile_id' => 4,
                'search_query' => 'Mango Mousse Delight',
                'search_id' => 24,
                'type' => 'video',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
