<?php

namespace Modules\Tax\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Modules\Tax\Models\Tax;
use Modules\MenuBuilder\Models\MenuBuilder;

class TaxDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('taxes')->delete();
        
        \DB::table('taxes')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'GST',
                'type' => 'Percentage',
                'value' => 18.0,
                'status' => 1,
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_by' => NULL,
                'created_at' => '2024-10-09 12:30:27',
                'updated_at' => '2024-10-09 12:30:27',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'CGST',
                'type' => 'Percentage',
                'value' => 9.0,
                'status' => 1,
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_by' => NULL,
                'created_at' => '2024-10-09 12:30:53',
                'updated_at' => '2024-10-09 12:32:17',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'title' => 'VAT',
                'type' => 'Percentage',
                'value' => 20.0,
                'status' => 1,
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_by' => NULL,
                'created_at' => '2024-10-09 12:34:57',
                'updated_at' => '2024-10-09 12:34:57',
                'deleted_at' => NULL,
            ),
        ));
    }
}
