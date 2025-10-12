<?php

namespace Modules\Entertainment\database\seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class EntertainmentViewsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('entertainment_views')->delete();

        $currentYear = Carbon::now()->year;

        \DB::table('entertainment_views')->insert(array (
            0 =>
            array (
                'id' => 1,
                'entertainment_id' => 99,
                'user_id' => 4,
                 'profile_id'=>4,
                'created_at' => $this->getRandomDate($currentYear),
                'updated_at' => $this->getRandomDate($currentYear),
                'deleted_at' => NULL,
            ),
            1 =>
            array (
                'id' => 2,
                'entertainment_id' => 95,
                'user_id' => 5,
                'profile_id'=>5,
                'created_at' => '2024-04-12 06:56:39',
                'updated_at' => '2024-04-12 06:56:39',
                'deleted_at' => NULL,
            ),
            2 =>
            array (
                'id' => 3,
                'entertainment_id' => 35,
                'user_id' => 6,
                'profile_id'=>6,
                'created_at' => '2024-05-12 06:56:46',
                'updated_at' => '2024-05-12 06:56:46',
                'deleted_at' => NULL,
            ),
            3 =>
            array (
                'id' => 4,
                'entertainment_id' => 49,
                'user_id' => 7,
                'profile_id'=>7,
                'created_at' => '2024-07-12 06:57:19',
                'updated_at' => '2024-07-12 06:57:19',
                'deleted_at' => NULL,
            ),
            4 =>
            array (
                'id' => 5,
                'entertainment_id' => 69,
                'user_id' => 3,
                'profile_id'=>3,
                'created_at' => '2024-06-12 06:57:44',
                'updated_at' => '2024-06-12 06:57:44',
                'deleted_at' => NULL,
            ),

            5 =>
            array (
                'id' => 6,
                'entertainment_id' => 76,
                'user_id' => 8,
                 'profile_id'=>8,
                'created_at' => '2024-04-12 06:57:44',
                'updated_at' => '2024-04-12 06:57:44',
                'deleted_at' => NULL,
            ),

            6 =>
            array (
                'id' => 7,
                'entertainment_id' => 89,
                'user_id' => 9,
                'profile_id'=>9,
                'created_at' =>  $this->getRandomDate($currentYear),
                'updated_at' =>  $this->getRandomDate($currentYear),
                'deleted_at' => NULL,
            ),

            7 =>
            array (
                'id' => 8,
                'entertainment_id' => 102,
                'user_id' => 10,
                'profile_id'=>10,
                'created_at' => '2024-05-12 06:57:44',
                'updated_at' => '2024-05-12 06:57:44',
                'deleted_at' => NULL,
            ),

            8 =>
            array (
                'id' => 9,
                'entertainment_id' => 94,
                'user_id' => 11,
                 'profile_id'=>11,
                'created_at' =>  $this->getRandomDate($currentYear),
                'updated_at' =>  $this->getRandomDate($currentYear),
                'deleted_at' => NULL,
            ),
            9 =>
            array (
                'id' => 10,
                'entertainment_id' => 22,
                'user_id' => 12,
                 'profile_id'=>12,
                'created_at' => '2024-06-20 06:57:44',
                'updated_at' => '2024-06-20 06:57:44',
                'deleted_at' => NULL,
            ),
            10 =>
            array (
                'id' => 11,
                'entertainment_id' => 25,
                'user_id' => 13,
                 'profile_id'=>13,
                'created_at' => '2024-01-01 06:57:44',
                'updated_at' => '2024-01-01 06:57:44',
                'deleted_at' => NULL,
            ),
            11 =>
            array (
                'id' => 12,
                'entertainment_id' => 35,
                'user_id' => 4,
                 'profile_id'=>4,
                'created_at' =>  $this->getRandomDate($currentYear),
                'updated_at' =>  $this->getRandomDate($currentYear),
                'deleted_at' => NULL,
            ),
            12 =>
            array (
                'id' => 13,
                'entertainment_id' => 40,
                'user_id' => 5,
                 'profile_id'=>5,
                'created_at' => '2024-02-20 06:57:44',
                'updated_at' => '2024-02-20 06:57:44',
                'deleted_at' => NULL,
            ),
            13 =>
            array (
                'id' => 14,
                'entertainment_id' => 55,
                'user_id' => 6,
                 'profile_id'=>6,
                'created_at' => '2024-01-12 06:57:44',
                'updated_at' => '2024-01-12 06:57:44',
                'deleted_at' => NULL,
            ),
            14 =>
            array (
                'id' => 15,
                'entertainment_id' => 62,
                'user_id' => 7,
                 'profile_id'=>7,
                'created_at' =>  $this->getRandomDate($currentYear),
                'updated_at' =>  $this->getRandomDate($currentYear),
                'deleted_at' => NULL,
            ),
            15 =>
            array (
                'id' => 16,
                'entertainment_id' => 68,
                'user_id' => 3,
                 'profile_id'=>3,
                'created_at' => '2024-04-12 06:57:44',
                'updated_at' => '2024-04-12 06:57:44',
                'deleted_at' => NULL,
            ),
            16 =>
            array (
                'id' => 17,
                'entertainment_id' => 75,
                'user_id' => 10,
                 'profile_id'=>10,
                'created_at' =>  $this->getRandomDate($currentYear),
                'updated_at' =>  $this->getRandomDate($currentYear),
                'deleted_at' => NULL,
            ),
            17 =>
            array (
                'id' => 18,
                'entertainment_id' => 83,
                'user_id' => 12,
                 'profile_id'=>12,
                'created_at' => '2024-09-12 06:57:44',
                'updated_at' => '2024-09-12 06:57:44',
                'deleted_at' => NULL,
            ),
            18 =>
            array (
                'id' => 19,
                'entertainment_id' => 89,
                'user_id' => 13,
                 'profile_id'=>13,
                'created_at' => '2024-10-12 06:57:44',
                'updated_at' => '2024-10-12 06:57:44',
                'deleted_at' => NULL,
            ),
            19 =>
            array (
                'id' => 20,
                'entertainment_id' => 93,
                'user_id' => 15,
                 'profile_id'=>15,
                'created_at' =>  $this->getRandomDate($currentYear),
                'updated_at' =>  $this->getRandomDate($currentYear),
                'deleted_at' => NULL,
            ),
            20 =>
            array (
                'id' => 21,
                'entertainment_id' => 99,
                'user_id' => 4,
                 'profile_id'=>4,
                'created_at' => '2024-09-12 06:57:44',
                'updated_at' => '2024-09-12 06:57:44',
                'deleted_at' => NULL,
            ),
            21 =>
            array (
                'id' => 22,
                'entertainment_id' => 101,
                'user_id' => 5,
                 'profile_id'=>5,
                'created_at' =>  $this->getRandomDate($currentYear),
                'updated_at' =>  $this->getRandomDate($currentYear),
                'deleted_at' => NULL,
            ),
            22 =>
            array (
                'id' => 23,
                'entertainment_id' => 102,
                'user_id' => 12,
                 'profile_id'=>12,
                'created_at' =>  $this->getRandomDate($currentYear),
                'updated_at' =>  $this->getRandomDate($currentYear),
                'deleted_at' => NULL,
            ),

        ));


    }
     /**
     * Generate a random date in the current year.
     *
     * @param int $year
     * @return string
     */
    private function getRandomDate($year)
    {
        $today = Carbon::today();

        // If it's the current year, don't allow months beyond the current month
        $maxMonth = $year == $today->year ? $today->month : 12;

        // Pick a random month from 1 to maxMonth
        $month = rand(1, $maxMonth);

        // Restrict max day if month == today's month
        $maxDay = ($year == $today->year && $month == $today->month)
            ? $today->day
            : cal_days_in_month(CAL_GREGORIAN, $month, $year);

        $day = rand(1, $maxDay);

        $date = Carbon::createFromDate($year, $month, $day);

        // Prevent future *time* on today
        if ($date->isToday()) {
            $date->setTime(rand(0, now()->hour), rand(0, 59), rand(0, 59));
        } else {
            $date->setTime(rand(0, 23), rand(0, 59), rand(0, 59));
        }

        return $date->format('Y-m-d H:i:s');
    }

}
