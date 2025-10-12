<?php

namespace Modules\Language\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Language\Models\Language;

class LanguageDatabaseSeeder extends Seeder
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
         * Languages Seed
         * ------------------
         */

        // DB::table('languages')->truncate();
        // echo "Truncate: languages \n";

        \Modules\Language\Models\Language::factory()->count(20)->create();
        $rows = Language::all();
        echo " Insert: languages \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
