<?php

namespace Modules\Entertainment\database\seeders;

use Illuminate\Database\Seeder;

class WatchlistDatabaseSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('watchlists')->delete();
        
        \DB::table('watchlists')->insert(array (
            0 => 
            array (
                'id' => 1,
                'entertainment_id' => 1,
                'user_id' => 3,
                'profile_id'=>3,
                'created_at' => '2024-03-12 06:55:53',
                'updated_at' => '2024-03-12 06:55:53',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'entertainment_id' => 2,
                'user_id' => 3,
                'profile_id'=>3,
                'created_at' => '2024-04-12 06:56:39',
                'updated_at' => '2024-04-12 06:56:39',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'entertainment_id' => 33,
                'user_id' => 14,
                'profile_id'=>14,
                'created_at' => '2024-05-12 06:56:46',
                'updated_at' => '2024-05-12 06:56:46',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'entertainment_id' => 4,
                'user_id' => 3,
                'profile_id'=>3,
                'created_at' => '2024-07-12 06:57:19',
                'updated_at' => '2024-07-12 06:57:19',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'entertainment_id' => 5,
                'user_id' => 3,
                'profile_id'=>3,
                'created_at' => '2024-06-12 06:57:44',
                'updated_at' => '2024-06-12 06:57:44',
                'deleted_at' => NULL,
            ),

            5 => 
            array (
                'id' => 6,
                'entertainment_id' => 6,
                'user_id' => 3,
                'profile_id'=>3,
                'created_at' => '2024-04-12 06:57:44',
                'updated_at' => '2024-04-12 06:57:44',
                'deleted_at' => NULL,
            ),

            6 => 
            array (
                'id' => 7,
                'entertainment_id' => 7,
                'user_id' => 3,
                'profile_id'=>3,
                'created_at' => '2024-07-12 06:57:44',
                'updated_at' => '2024-07-12 06:57:44',
                'deleted_at' => NULL,
            ),

            7 => 
            array (
                'id' => 8,
                'entertainment_id' => 58,
                'user_id' => 3,
                'profile_id'=>3,
                'created_at' => '2024-05-12 06:57:44',
                'updated_at' => '2024-05-12 06:57:44',
                'deleted_at' => NULL,
            ),

            8 => 
            array (
                'id' => 9,
                'entertainment_id' => 9,
                'user_id' => 3,
                'profile_id'=>3,
                'created_at' => '2024-06-12 06:57:44',
                'updated_at' => '2024-06-12 06:57:44',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}