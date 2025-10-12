<?php

namespace Modules\Genres\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Modules\Genres\Models\Genres;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class GenresDatabaseSeeder extends Seeder
{

      public function run()
        {
            Schema::disableForeignKeyConstraints();


            $avatarPath = config('app.avatar_base_path');

            $geners = [
                [
                    'name' => 'Action',
                    'slug' => 'action',
                    'file_url' =>  '/dummy-images/genre/action_genre.png',
                    'description' => 'Action movies are packed with high-energy sequences, intense battles, and thrilling adventures. These films deliver non-stop excitement and adrenaline-pumping scenes that captivate audiences. 💥🏃‍♂️',
                    'status' => 1,

                ],
                [
                    'name' => 'Animation',
                    'file_url' => '/dummy-images/genre/animation_genre.png',
                    'slug' => 'animation',
                    'description' => 'Captivating animated stories that bring imaginative worlds and characters to life. These films use creative visuals and storytelling to enchant audiences of all ages. 🎨✨',
                    'status' => 1,
                ],

                [
                    'name' => 'Comedy',
                    'file_url' => '/dummy-images/genre/comedy_genre.png',
                    'slug' => 'comedy',
                    'description' => 'Light-hearted films designed to entertain and amuse with humor and wit. These movies offer a delightful escape filled with laughter and joy. 😂🎬',
                    'status' => 1,
                ],
                [
                    'name' => 'Historical',
                    'file_url' => '/dummy-images/genre/historical_genre.png',
                    'slug' => 'historical',
                    'description' => 'Movies that delve into significant historical events, figures, and eras. They offer a glimpse into the past, bringing history to life with compelling narratives. 📜🏰',
                    'status' => 1,
                ],

                [
                    'name' => 'Horror',
                    'file_url' =>'/dummy-images/genre/horror_genre.png',
                    'slug' => 'horror',
                    'description' => 'Spine-chilling movies that evoke fear and suspense, often featuring supernatural elements. These films are designed to haunt and thrill viewers. 👻🕯️',
                    'status' => 1,
                ],

                [
                    'name' => 'Inspirational',
                    'file_url' => '/dummy-images/genre/inspirational_genre.png',
                    'slug' => 'inspirational',
                    'description' => 'Uplifting films that motivate and inspire with stories of courage, perseverance, and triumph. They often highlight the resilience of the human spirit. 🌟💪',
                    'status' => 1,
                ],
                [
                    'name' => 'Romantic',
                    'file_url' => '/dummy-images/genre/romantic_genre.png',
                    'slug' => 'romantic',
                    'description' => 'Heartwarming stories focusing on love, relationships, and the complexities of romance. These films explore the beauty and challenges of romantic connections. 💖🌹',
                    'status' => 1,
                ],

                [
                    'name' => 'Thriller',
                    'file_url' => '/dummy-images/genre/thriller_genre.png',
                    'slug' => 'thriller',
                    'description' => 'High-stakes scenarios and intense suspense that keep you on the edge of your seat. Expect unexpected twists and heart-pounding moments. 🔪🎬',
                    'status' => 1,
                ],


            ];

            if (env('IS_DUMMY_DATA')) {
                foreach ($geners as $genersData) {
                    $posterPath = $genersData['file_url'] ?? null;

                    $gener = Genres::create(Arr::except($genersData, ['file_url']));
                    if (isset($posterPath)) {
                        $posterUrl = $this->uploadToSpaces($posterPath);
                        if ($posterUrl) {
                            $gener->file_url = extractFileNameFromUrl($posterUrl);
                        }
                    }

                    $gener->save();
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
