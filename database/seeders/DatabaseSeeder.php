<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Schema;
use Modules\LiveTV\database\seeders\LiveTvCategoryTableSeeder;
use Modules\LiveTV\database\seeders\LiveTvChannelTableSeeder;
use Modules\Ad\database\seeders\VastAdsSettingTableSeeder;
use Modules\Ad\database\seeders\CustomAdsSettingTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {


        \Artisan::call('cache:clear');
        Schema::disableForeignKeyConstraints();
        $file = new Filesystem;

        $file->cleanDirectory('storage/app/public');


        if (env('IS_DUMMY_DATA') == false) {

            $this->call(AuthTableSeeder::class);
            $this->call(SettingSeeder::class);
            $this->call(\Modules\World\database\seeders\WorldDatabaseSeeder::class);
            $this->call(\Modules\Constant\database\seeders\ConstantDatabaseSeeder::class);
            $this->call(\Modules\Page\database\seeders\PageDatabaseSeeder::class);
            $this->call(\Modules\Subscriptions\database\seeders\PlanTableSeeder::class);
            $this->call(\Modules\Subscriptions\database\seeders\PlanlimitationTableSeeder::class);
            $this->call(\Modules\NotificationTemplate\database\seeders\NotificationTemplateSeeder::class);
            $this->call(\Modules\Tax\database\seeders\TaxDatabaseSeeder::class);
            $this->call(\Modules\Currency\database\seeders\CurrencyDatabaseSeeder::class);
            $this->call(MobileSettingsTableSeeder::class);
        } else {



            $this->call(AuthTableSeeder::class);
            $this->call(SettingSeeder::class);
            $this->call(UserProfilesSeeder::class);
            $this->call(UserSearchHistoriesSeeder::class);
            $this->call(UserWatchHistoriesSeeder::class);
            $this->call(\Modules\World\database\seeders\WorldDatabaseSeeder::class);
            $this->call(\Modules\Banner\database\seeders\BannerDatabaseSeeder::class);
            $this->call(\Modules\Constant\database\seeders\ConstantDatabaseSeeder::class);
            $this->call(\Modules\Genres\database\seeders\GenresDatabaseSeeder::class);
            $this->call(\Modules\CastCrew\database\seeders\CastCrewDatabaseSeeder::class);
            $this->call(\Modules\Entertainment\database\seeders\EntertainmentDatabaseSeeder::class);
            $this->call(\Modules\Entertainment\database\seeders\ReviewDatabaseSeeder::class);
            $this->call(\Modules\Season\database\seeders\SeasonDatabaseSeeder::class);
            $this->call(\Modules\Episode\database\seeders\EpisodeDatabaseSeeder::class);
            $this->call(\Modules\Page\database\seeders\PageDatabaseSeeder::class);
            $this->call(\Modules\Subscriptions\database\seeders\PlanTableSeeder::class);
            $this->call(\Modules\Subscriptions\database\seeders\PlanlimitationTableSeeder::class);
            $this->call(\Modules\Subscriptions\database\seeders\SubscriptionsTableSeeder::class);
            $this->call(\Modules\Subscriptions\database\seeders\PlanlimitationMappingTableSeeder::class);
            $this->call(\Modules\Subscriptions\database\seeders\SubscriptionsTransactionsTableSeeder::class);
            $this->call(\Modules\Video\database\seeders\VideoDatabaseSeeder::class);
            $this->call(\Modules\NotificationTemplate\database\seeders\NotificationTemplateSeeder::class);
            $this->call(\Modules\Entertainment\database\seeders\EntertainmentViewsTableSeeder::class);
            $this->call(\Modules\Entertainment\database\seeders\WatchlistDatabaseSeeder::class);
            $this->call(\Modules\Entertainment\database\seeders\LikesTableSeeder::class);
            $this->call(\Modules\FAQ\database\seeders\FAQDatabaseSeeder::class);
            $this->call(\Modules\Tax\database\seeders\TaxDatabaseSeeder::class);
            $this->call(\Modules\Entertainment\database\seeders\ContinueWatchTableSeeder::class);
            $this->call(\Modules\Currency\database\seeders\CurrencyDatabaseSeeder::class);
            $this->call(LiveTvCategoryTableSeeder::class);
            $this->call(LiveTvChannelTableSeeder::class);
            $this->call(MobileSettingsTableSeeder::class);
            $this->call(VastAdsSettingTableSeeder::class);
            $this->call(CustomAdsSettingTableSeeder::class);
            Schema::enableForeignKeyConstraints();
            \Artisan::call('cache:clear');
        }

        \Artisan::call('cache:clear');
        \Artisan::call('storage:link');

        chmod(storage_path('app/public/avatars'), 0775);
        chmod(storage_path('app/public/streamit-laravel'), 0775);
    }
}
