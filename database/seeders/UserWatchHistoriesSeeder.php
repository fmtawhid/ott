<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserWatchHistoriesSeeder extends Seeder
{
    public function run()
    {
        // Clear the user_search_histories table
        \DB::table('user_watch_histories')->delete();
        
        // Insert records into the user_search_histories table
        \DB::table('user_watch_histories')->insert([
            [
                'entertainment_id' => 101,
                'user_id' => 3,
                'profile_id' => 3,
                'entertainment_type' => 'movie', 
                'created_by' => 3,
                'updated_by' => 3,
                'deleted_by' => null,
            ],
            [
                'entertainment_id' => 15,
                'user_id' => 3,
                'profile_id' => 3,
                'entertainment_type' => 'tvshow', 
                'created_by' => 3,
                'updated_by' => 3,
                'deleted_by' => null,
            ],
            [
                'entertainment_id' => 35,
                'user_id' => 3,
                'profile_id' => 3,
                'entertainment_type' => 'movie',
                'created_by' => 3,
                'updated_by' => 3,
                'deleted_by' => null,

            ],
            [
                'entertainment_id' => 12,
                'user_id' => 4,
                'profile_id' => 4,
                'entertainment_type' => 'tvshow', 
                'created_by' => 4,
                'updated_by' => 4,
                'deleted_by' => null,
            ],
            [
                'entertainment_id' => 15,
                'user_id' => 4,
                'profile_id' => 4,
                'entertainment_type' => 'video', 
                'created_by' => 4,
                'updated_by' => 4,
                'deleted_by' => null,
            ],
            [
                'entertainment_id' => 10,
                'user_id' => 4,
                'profile_id' => 4,
                'entertainment_type' => 'video', 
                'created_by' => 4,
                'updated_by' => 4,
                'deleted_by' => null,
            ],
            [
                'entertainment_id' => 5,
                'user_id' => 3,
                'profile_id' => 3,
                'entertainment_type' => 'video', 
                'created_by' => 3,
                'updated_by' => 3,
                'deleted_by' => null,
            ],
            [
                'entertainment_id' => 65,
                'user_id' => 3,
                'profile_id' => 3,
                'entertainment_type' => 'movie', 
                'created_by' => 3,
                'updated_by' => 3,
                'deleted_by' => null,
            ],
            [
                'entertainment_id' => 2,
                'user_id' => 4,
                'profile_id' => 4,
                'entertainment_type' => 'tvshow', 
                'created_by' => 4,
                'updated_by' => 4,
                'deleted_by' => null,
            ],
            [
                'entertainment_id' => 8,
                'user_id' => 3,
                'profile_id' => 3,
                'entertainment_type' => 'video', 
                'created_by' => 3,
                'updated_by' => 3,
                'deleted_by' => null,
            ],
            [
                'entertainment_id' => 18,
                'user_id' => 4,
                'profile_id' => 4,
                'entertainment_type' => 'video', 
                'created_by' => 4,
                'updated_by' => 4,
                'deleted_by' => null,
            ],
            [
                'entertainment_id' => 18,
                'user_id' => 3,
                'profile_id' => 3,
                'entertainment_type' => 'tvshow', 
                'created_by' => 3,
                'updated_by' => 3,
                'deleted_by' => null,
            ],

          
        ]);
    }
}
