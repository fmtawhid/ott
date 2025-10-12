<?php

namespace Modules\LiveTV\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Modules\LiveTV\Models\LiveTvCategory;

class LiveTvCategoryTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */

     public function run()
     {
         Schema::disableForeignKeyConstraints();


         $avatarPath = config('app.avatar_base_path');

         $liveTvCategories = [
            [
                'name' => 'News & Current Affairs',
                'file_url' => '/dummy-images/livetv/category/news_current_affairs.png',
                'description' => 'Stay informed with the latest updates from around the world. This category brings you live news broadcasts, in-depth analysis, and breaking news coverage. From politics to finance, and global events to local happenings, never miss a moment of what\'s happening. 📰🌍🕒',
                'status' => 1,
            ],
            [
                'name' => 'Sports & Action',
                'file_url' => '/dummy-images/livetv/category/sports_action.png',
                'description' => 'Catch all the live sports action from your favorite games and tournaments. Whether it\'s football, basketball, tennis, or any other sport, this category covers live matches, expert commentary, and thrilling highlights. Cheer for your teams and witness unforgettable moments. 🏆⚽🏀',
                'status' => 1,
            ],
            [
                'name' => 'Entertainment & Variety',
                'file_url' => '/dummy-images/livetv/category/entertainment_variety.png',
                'description' => 'Enjoy a diverse range of live entertainment shows, from reality TV and talent competitions to talk shows and award ceremonies. This category offers something for everyone, featuring your favorite stars and hosts bringing you laughter, drama, and excitement. 🎤🎬🎉',
                'status' => 1,
            ],
            [
                'name' => 'Music & Concerts',
                'file_url' => '/dummy-images/livetv/category/music_concerts.png',
                'description' => 'Experience live music like never before with concerts, festivals, and exclusive performances from top artists. This category brings the stage to your screen, allowing you to enjoy your favorite genres and discover new talents from the comfort of your home. 🎸🎤🎶',
                'status' => 1,
            ],
            [
                'name' => 'Educational & Documentary',
                'file_url' => '/dummy-images/livetv/category/educational_documentary.png',
                'description' => 'Expand your knowledge with live educational programs and documentaries covering a wide range of topics. From science and history to nature and technology, this category provides informative content that enlightens and inspires. Ideal for curious minds of all ages. 📚🔬🌿',
                'status' => 1,
            ],
            ];

                foreach ($liveTvCategories as $key => $liveTvCategory_data) {
                    $featureImage = $liveTvCategory_data['file_url'] ?? null;
                    $categoryData = Arr::except($liveTvCategory_data, ['file_url']);
                    $category = LiveTvCategory::create($categoryData);
                    if (isset($featureImage)) {
                        $originalUrl = $this->uploadToSpaces($featureImage);
                        if ($originalUrl) {
                            $category->file_url = extractFileNameFromUrl($originalUrl);
                            $category->save();
                        }
                    }


                Schema::enableForeignKeyConstraints();
        }
    }

    private function uploadToSpaces($publicPath)
    {
        $localFilePath = public_path($publicPath);
        $remoteFilePath = 'streamit-laravel/' . basename($publicPath);

        if (file_exists($localFilePath)) {
            // Get the active storage disk from the environment
            $disk = env('ACTIVE_STORAGE', 'local');

            if ($disk === 'local') {
                // Store in the public directory for local storage
                Storage::disk($disk)->put('public/' . $remoteFilePath, file_get_contents($localFilePath));
                return asset('storage/' . $remoteFilePath);
            } else {
                // Upload to the specified storage disk
                Storage::disk($disk)->put($remoteFilePath, file_get_contents($localFilePath));
                return Storage::disk($disk)->url($remoteFilePath);
            }
        }

        return false;
    }
}
