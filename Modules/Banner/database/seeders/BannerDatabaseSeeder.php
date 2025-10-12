<?php

namespace Modules\Banner\database\seeders;

use Illuminate\Database\Seeder;

class BannerDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('banners')->delete();

        \DB::table('banners')->insert(array (
            0 =>
            array (
                'id' => 1,
                'title' => NULL,
                'file_url' => 'the_daring_player_poster.png',
                'poster_url' => 'the_daring_player_thumb.webp',
                'type' => 'movie',
                'type_id' => '27',
                'type_name' => 'The Daring Player',
                'status' => 1,
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_by' => NULL,
                'created_at' => '2024-10-08 05:18:48',
                'updated_at' => '2024-10-08 05:18:48',
                'deleted_at' => NULL,
                'banner_for' => 'home',
                'poster_tv_url' => 'the_daring_player_thumb.webp',
            ),
            1 =>
            array (
                'id' => 2,
                'title' => NULL,
                'file_url' => 'the_smiling_shadows_poster.png',
                'poster_url' => 'the_smiling_shadows_thumb.webp',
                'type' => 'tvshow',
                'type_id' => '1',
                'type_name' => 'The Smiling Shadows',
                'status' => 1,
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_by' => NULL,
                'created_at' => '2024-10-08 05:19:29',
                'updated_at' => '2024-10-08 05:19:29',
                'deleted_at' => NULL,
                'banner_for' => 'home',
                'poster_tv_url' => 'the_smiling_shadows_thumb.webp',
            ),
            2 =>
            array (
                'id' => 3,
                'title' => NULL,
                'file_url' => 'the_gunfighters_redemption_poster.png',
                'poster_url' => 'the_gunfighters_redemption_thumb.webp',
                'type' => 'movie',
                'type_id' => '23',
                'type_name' => 'The Gunfighter\'s Redemption',
                'status' => 1,
                'created_by' => 2,
                'updated_by' => 1,
                'deleted_by' => NULL,
                'created_at' => '2024-10-08 05:20:16',
                'updated_at' => '2025-04-22 10:55:00',
                'deleted_at' => NULL,
                'banner_for' => 'movie',
                'poster_tv_url' => 'the_gunfighters_redemption_thumb.webp',
            ),
            3 =>
            array (
                'id' => 4,
                'title' => NULL,
                'file_url' => 'daizys_enchanted_journey_poster.png',
                'poster_url' => 'daizys_enchanted_journey_thumb.webp',
                'type' => 'movie',
                'type_id' => '24',
                'type_name' => 'Daizy\'s Enchanted Journey',
                'status' => 1,
                'created_by' => 2,
                'updated_by' => 1,
                'deleted_by' => NULL,
                'created_at' => '2024-10-08 05:20:53',
                'updated_at' => '2025-04-22 10:54:48',
                'deleted_at' => NULL,
                'banner_for' => 'movie',
                'poster_tv_url' => 'daizys_enchanted_journey_thumb.webp',
            ),
            4 =>
            array (
                'id' => 5,
                'title' => NULL,
                'file_url' => 'seize_your_life.png',
                'poster_url' => 'seize_your_life.png',
                'type' => 'video',
                'type_id' => '2',
                'type_name' => 'Seize Your Life - Powerful Motivational Speech',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_by' => NULL,
                'created_at' => '2025-04-22 10:54:11',
                'updated_at' => '2025-04-22 10:54:11',
                'deleted_at' => NULL,
                'banner_for' => 'video',
                'poster_tv_url' => 'seize_your_life.png',
            ),
            5 =>
            array (
                'id' => 6,
                'title' => NULL,
                'file_url' => 'the_power_of_words_this_story_will_change_your_life.png',
                'poster_url' => 'the_power_of_words_this_story_will_change_your_life.png',
                'type' => 'video',
                'type_id' => '20',
                'type_name' => 'Life Changing Fitness Habits - Daily Healthy Tips',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_by' => NULL,
                'created_at' => '2025-04-22 10:54:25',
                'updated_at' => '2025-04-22 10:57:41',
                'deleted_at' => NULL,
                'banner_for' => 'video',
                'poster_tv_url' => 'the_power_of_words_this_story_will_change_your_life.png',
            ),
            6 =>
            array (
                'id' => 7,
                'title' => NULL,
                'file_url' => 'victory_vibes.png',
                'poster_url' => 'victory_vibes.png',
                'type' => 'video',
                'type_id' => '7',
                'type_name' => 'Victory Vibes',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_by' => NULL,
                'created_at' => '2025-04-22 10:54:36',
                'updated_at' => '2025-04-22 10:54:36',
                'deleted_at' => NULL,
                'banner_for' => 'home',
                'poster_tv_url' => 'victory_vibes.png',
            ),
            7 =>
            array (
                'id' => 8,
                'title' => NULL,
                'file_url' => 'veil_of_darkness_thumb.png',
                'poster_url' => 'veil_of_darkness_poster.png',
                'type' => 'tvshow',
                'type_id' => '5',
                'type_name' => 'Veil of Darkness',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_by' => NULL,
                'created_at' => '2025-04-22 10:55:18',
                'updated_at' => '2025-04-22 10:55:18',
                'deleted_at' => NULL,
                'banner_for' => 'tv_show',
                'poster_tv_url' => 'veil_of_darkness_thumb.png',
            ),
            8 =>
            array (
                'id' => 9,
                'title' => NULL,
                'file_url' => 'mcdoll_mayhem_thumb.png',
                'poster_url' => 'mcdoll_mayhem_poster.png',
                'type' => 'tvshow',
                'type_id' => '15',
                'type_name' => 'McDoll Mayhem',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_by' => NULL,
                'created_at' => '2025-04-22 10:55:31',
                'updated_at' => '2025-04-22 10:55:31',
                'deleted_at' => NULL,
                'banner_for' => 'tv_show',
                'poster_tv_url' => 'mcdoll_mayhem_thumb.png',
            ),
        ));

        }

    }


