<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(\Modules\NotificationTemplate\database\seeders\NotificationTemplateSeeder::class);
    }
}
