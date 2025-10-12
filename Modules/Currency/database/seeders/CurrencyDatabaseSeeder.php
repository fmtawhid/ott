<?php

namespace Modules\Currency\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencyDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        \DB::table('currencies')->delete();

        \DB::table('currencies')->insert(array (
            0 =>
            array (
                'id' => 1,
                'currency_name' => 'United States Dollar',
                'currency_symbol' => '$',
                'currency_code' => 'USD',
                'is_primary' => 1,
                'currency_position' => 'left',
                'no_of_decimal' => 2,
                'thousand_separator' => ',',
                'decimal_separator' => '.',
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_by' => NULL,
                'created_at' => '2024-07-30 07:18:52',
                'updated_at' => '2024-07-30 07:19:18',
                'deleted_at' => NULL,
            ),
            1 =>
            array (
                'id' => 2,
                'currency_name' => 'Euro',
                'currency_symbol' => '€',
                'currency_code' => 'EUR',
                'is_primary' => 0,
                'currency_position' => 'left',
                'no_of_decimal' => 2,
                'thousand_separator' => ',',
                'decimal_separator' => '.',
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_by' => NULL,
                'created_at' => '2024-07-30 07:19:08',
                'updated_at' => '2024-07-30 07:19:08',
                'deleted_at' => NULL,
            ),
            2 =>
            array (
                'id' => 3,
                'currency_name' => 'Indian Rupee',
                'currency_symbol' => '₹',
                'currency_code' => 'INR',
                'is_primary' => 0,
                'currency_position' => 'left',
                'no_of_decimal' => 2,
                'thousand_separator' => ',',
                'decimal_separator' => '.',
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_by' => NULL,
                'created_at' => '2024-07-30 07:19:52',
                'updated_at' => '2024-07-30 07:19:52',
                'deleted_at' => NULL,
            ),
        ));


    }
}
