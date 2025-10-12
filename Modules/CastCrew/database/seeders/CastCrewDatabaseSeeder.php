<?php

namespace Modules\CastCrew\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Arr;
use Modules\CastCrew\Models\CastCrew;
use Illuminate\Support\Facades\Storage;

class CastCrewDatabaseSeeder extends Seeder

{

      public function run()
        {
            Schema::disableForeignKeyConstraints();


            $avatarPath = config('app.avatar_base_path');

            $castAndCrew = [
                [
                    'name' => 'Michael Johnson',
                    'type' => 'actor',
                    'file_url' => '/dummy-images/castcrew/actor/michael_johnson.png',
                    'bio' => 'Versatile actor known for his dynamic roles in action and drama films. 🎬',
                    'place_of_birth' => 'New York, USA',
                    'dob' => '1985-04-13',
                    'designation' => 'Main Actor',
                ],
                [
                    'name' => 'James Williams',
                    'type' => 'actor',
                    'file_url' => '/dummy-images/castcrew/actor/james_williams.png',
                    'bio' => 'Acclaimed actor with a knack for bringing complex characters to life. 🎭',
                    'place_of_birth' => 'Los Angeles, USA',
                    'dob' => '1980-04-14',
                    'designation' => 'Main Actor',
                ],
                [
                    'name' => 'Robert Brown',
                    'type' => 'actor',
                    'file_url' => '/dummy-images/castcrew/actor/robert_brown.png',
                    'bio' => 'Renowned actor famed for his powerful performances in thrillers. 🔪',
                    'place_of_birth' => 'Chicago, USA',
                    'dob' => '1990-02-07',
                    'designation' => 'Actor',
                ],
                [
                    'name' => 'David Jones',
                    'type' => 'actor',
                    'file_url' => '/dummy-images/castcrew/actor/david_jones.png',
                    'bio' => 'Award-winning actor known for his captivating roles in historical dramas. 📜',
                    'place_of_birth' => 'London, UK',
                    'dob' => '1985-08-04',
                    'designation' => 'Actor',
                ],
                [
                    'name' => 'John Miller',
                    'type' => 'actor',
                    'file_url' => '/dummy-images/castcrew/actor/john_miller.png',
                    'bio' => 'Charismatic actor celebrated for his comedic timing and charm. 😂',
                    'place_of_birth' => 'Toronto, Canada',
                    'dob' => '1982-12-09',
                    'designation' => 'Actor',
                ],
                [
                    'name' => 'Daniel Anderson',
                    'type' => 'actor',
                    'file_url' => '/dummy-images/castcrew/actor/daniel_anderson.png',
                    'bio' => 'Talented actor known for his intense and compelling performances in horror films. 👻',
                    'place_of_birth' => 'Sydney, Australia',
                    'dob' => '1990-09-07',
                    'designation' => 'Voice Actor',
                ],
                [
                    'name' => 'Matthew Clark',
                    'type' => 'actor',
                    'file_url' => '/dummy-images/castcrew/actor/matthew_clark.png',
                    'bio' => 'Dynamic actor recognized for his roles in inspirational and motivational films. 🌟',
                    'place_of_birth' => 'Dublin, Ireland',
                    'dob' => '1980-01-10',
                    'designation' => 'Voice Actor',
                ],
                [
                    'name' => 'Andrew Martinez',
                    'type' => 'actor',
                    'file_url' => '/dummy-images/castcrew/actor/andrew_martinez.png',
                    'bio' => 'Acclaimed actor with a strong presence in romantic films. 💖',
                    'place_of_birth' => 'Madrid, Spain',
                    'dob' => '1986-01-23',
                    'designation' => 'Actor',
                ],
                [
                    'name' => 'Joshua Rodriguez',
                    'type' => 'actor',
                    'file_url' => '/dummy-images/castcrew/actor/joshua_rodriguez.png',
                    'bio' => 'Renowned for his action-packed roles and high-energy performances. 💥',
                    'place_of_birth' => 'Mexico City, Mexico',
                    'dob' => '1985-07-19',
                    'designation' => 'Actor',
                ],
                [
                    'name' => 'Christopher Lopez',
                    'type' => 'actor',
                    'file_url' => '/dummy-images/castcrew/actor/christopher_lopez.png',
                    'bio' => 'Versatile actor known for his roles in both comedy and drama. 🎭',
                    'place_of_birth' => 'Buenos Aires, Argentina',
                    'dob' => '1991-06-13',
                    'designation' => 'Main Actor',
                ],
                [
                    'name' => 'Emily Johnson',
                    'type' => 'actor',
                    'file_url' => '/dummy-images/castcrew/actor/emily_johnson.png',
                    'bio' => 'Talented actress known for her captivating performances in dramas. 🎬',
                    'place_of_birth' => 'New York, USA',
                    'dob' => '1993-01-05',
                    'designation' => 'Main Actress',
                ],
                [
                    'name' => 'Laura Turner',
                    'type' => 'actor',
                    'file_url' => '/dummy-images/castcrew/actor/laura_turner.png',
                    'bio' => 'Renowned actress with a flair for bringing historical characters to life. 📜',
                    'place_of_birth' => 'Los Angeles, USA',
                    'dob' => '1990-08-18',
                    'designation' => 'Main Actress',
                ],
                [
                    'name' => 'Olivia Martinez',
                    'type' => 'actor',
                    'file_url' => '/dummy-images/castcrew/actor/olivia_martinez.png',
                    'bio' => 'Acclaimed actress known for her dynamic roles in romantic films. 💖',
                    'place_of_birth' => 'Madrid, Spain',
                    'dob' => '1992-03-10',
                    'designation' => 'Actress',
                ],
                [
                    'name' => 'Isabella Brown',
                    'type' => 'actor',
                    'file_url' => '/dummy-images/castcrew/actor/isabella_brown.png',
                    'bio' => 'Versatile actress with a talent for both comedy and drama. 😂',
                    'place_of_birth' => 'London, UK',
                    'dob' => '1995-06-08',
                    'designation' => 'Actress',
                ],
                [
                    'name' => 'Lily Clark',
                    'type' => 'actor',
                    'file_url' => '/dummy-images/castcrew/actor/lily_clark.png',
                    'bio' => 'Celebrated actress known for her intense performances in thrillers. 🔪',
                    'place_of_birth' => 'Toronto, Canada',
                    'dob' => '1997-05-06',
                    'designation' => 'Voice Actress',
                ],
                [
                    'name' => 'Charlotte Garcia',
                    'type' => 'actor',
                    'file_url' => '/dummy-images/castcrew/actor/charlotte_garcia.png',
                    'bio' => 'Acclaimed actress renowned for her roles in horror films. 👻',
                    'place_of_birth' => 'Sydney, Australia',
                    'dob' => '1991-02-05',
                    'designation' => 'Voice Actress',
                ],
                [
                    'name' => 'Amelia Martinez',
                    'type' => 'actor',
                    'file_url' => '/dummy-images/castcrew/actor/amelia_martinez.png',
                    'bio' => 'Dynamic actress recognized for her roles in inspirational movies. 🌟',
                    'place_of_birth' => 'Mexico City, Mexico',
                    'dob' => '1994-07-21',
                    'designation' => 'Actress',
                ],
                [
                    'name' => 'Jessica Adams',
                    'type' => 'actor',
                    'file_url' => '/dummy-images/castcrew/actor/jessica_adams.png',
                    'bio' => 'Talented actress known for her compelling performances in action films. 💥',
                    'place_of_birth' => 'Dublin, Ireland',
                    'dob' => '1992-08-15',
                    'designation' => 'Actress',
                ],
                [
                    'name' => 'Megan Collins',
                    'type' => 'actor',
                    'file_url' => '/dummy-images/castcrew/actor/megan_collins.png',
                    'bio' => 'Versatile actress known for her roles in both romantic and drama films. 💖',
                    'place_of_birth' => 'Seoul, South Korea',
                    'dob' => '1988-03-08',
                    'designation' => 'Actress',
                ],
                [
                    'name' => 'Grace Taylor',
                    'type' => 'actor',
                    'file_url' => '/dummy-images/castcrew/actor/grace_taylor.png',
                    'bio' => 'Acclaimed actress celebrated for her performances in historical dramas. 📜',
                    'place_of_birth' => 'Cape Town, South Africa',
                    'dob' => '1989-02-11',
                    'designation' => 'Actress',
                ],
                [
                    'name' => 'Thomas Smith',
                    'type' => 'director',
                    'file_url' => '/dummy-images/castcrew/director/thomas_smith.png',
                    'bio' => 'Visionary director known for his innovative storytelling and cinematic techniques. 🎬',
                    'place_of_birth' => 'New York, USA',
                    'dob' => '1985-04-13',
                    'designation' => 'Director',
                ],
                [
                    'name' => 'William Johnson',
                    'type' => 'director',
                    'file_url' => '/dummy-images/castcrew/director/william_johnson.png',
                    'bio' => 'Acclaimed director with a flair for intense action sequences. 💥',
                    'place_of_birth' => 'Los Angeles, USA',
                    'dob' => '1980-04-14',
                    'designation' => 'Director',
                ],
                [
                    'name' => 'Henry Taylor',
                    'type' => 'director',
                    'file_url' => '/dummy-images/castcrew/director/henry_taylor.png',
                    'bio' => 'Renowned director known for his compelling historical dramas. 📜',
                    'place_of_birth' => 'Chicago, USA',
                    'dob' => '1990-02-07',
                    'designation' => 'Director',
                ],
                [
                    'name' => 'Charles Wilson',
                    'type' => 'director',
                    'file_url' => '/dummy-images/castcrew/director/charles_wilson.png',
                    'bio' => 'Award-winning director famous for his work in horror films. 👻',
                    'place_of_birth' => 'London, UK',
                    'dob' => '1985-08-04',
                    'designation' => 'Director',
                ],
                [
                    'name' => 'George Harris',
                    'type' => 'director',
                    'file_url' => '/dummy-images/castcrew/director/george_harris.png',
                    'bio' => 'Innovative director known for his unique approach to comedy. 😂',
                    'place_of_birth' => 'Toronto, Canada',
                    'dob' => '1982-12-09',
                    'designation' => 'Director',
                ],
                [
                    'name' => 'Anthony Clark',
                    'type' => 'director',
                    'file_url' => '/dummy-images/castcrew/director/anthony_clark.png',
                    'bio' => 'Talented director celebrated for his inspirational and motivational films. 🌟',
                    'place_of_birth' => 'Sydney, Australia',
                    'dob' => '1980-04-18',
                    'designation' => 'Director',
                ],
                [
                    'name' => 'Edward Lewis',
                    'type' => 'director',
                    'file_url' => '/dummy-images/castcrew/director/edward_lewis.png',
                    'bio' => 'Dynamic director recognized for his work in romantic films. 💖',
                    'place_of_birth' => 'Dublin, Ireland',
                    'dob' => '1982-01-11',
                    'designation' => 'Director',
                ],
                [
                    'name' => 'Daniel Walker',
                    'type' => 'director',
                    'file_url' => '/dummy-images/castcrew/director/daniel_walker.png',
                    'bio' => 'Acclaimed director known for his thrilling and suspenseful films. 🔪',
                    'place_of_birth' => 'Madrid, Spain',
                    'dob' => '1981-05-12',
                    'designation' => 'Director',
                ],
                [
                    'name' => 'Matthew Collins',
                    'type' => 'director',
                    'file_url' => '/dummy-images/castcrew/director/matthew_collins.png',
                    'bio' => 'Renowned for his action-packed films and high-energy direction. 🎥',
                    'place_of_birth' => 'Mexico City, Mexico',
                    'dob' => '1983-02-18',
                    'designation' => 'Director',
                ],
                [
                    'name' => 'Richard King',
                    'type' => 'director',
                    'file_url' => '/dummy-images/castcrew/director/richard_king.png',
                    'bio' => 'Celebrated director known for his masterful storytelling in drama. 🎭',
                    'place_of_birth' => 'Buenos Aires, Argentina',
                    'dob' => '1987-03-27',
                    'designation' => 'Director',
                ],
                [
                    'name' => 'Sophia Williams',
                    'type' => 'director',
                    'file_url' => '/dummy-images/castcrew/director/sophia_williams.png',
                    'bio' => 'Acclaimed director known for her profound and emotional storytelling. 🎬',
                    'place_of_birth' => 'New York, USA',
                    'dob' => '1989-06-15',
                    'designation' => 'Director',
                ],
                [
                    'name' => 'Emma Thompson',
                    'type' => 'director',
                    'file_url' => '/dummy-images/castcrew/director/emma_thompson.png',
                    'bio' => 'Visionary director celebrated for her work in romantic films. 💖',
                    'place_of_birth' => 'Los Angeles, USA',
                    'dob' => '1990-08-16',
                    'designation' => 'Director',
                ],
                [
                    'name' => 'Abigail Thompson',
                    'type' => 'director',
                    'file_url' => '/dummy-images/castcrew/director/abigail_thompson.png',
                    'bio' => 'Renowned director known for her historical dramas and biopics. 📜',
                    'place_of_birth' => 'Madrid, Spain',
                    'dob' => '1992-06-21',
                    'designation' => 'Director',
                ],
                [
                    'name' => 'Natalie Parker',
                    'type' => 'director',
                    'file_url' => '/dummy-images/castcrew/director/natalie_parker.png',
                    'bio' => 'Award-winning director famous for her suspenseful thrillers. 🔪',
                    'place_of_birth' => 'London, UK',
                    'dob' => '1991-07-25',
                    'designation' => 'Director',
                ],
                [
                    'name' => 'Mili Davis',
                    'type' => 'director',
                    'file_url' => '/dummy-images/castcrew/director/mili_davis.png',
                    'bio' => 'Talented director known for her innovative approach to comedy. 😂',
                    'place_of_birth' => 'Toronto, Canada',
                    'dob' => '1988-08-10',
                    'designation' => 'Director',
                ],
                [
                    'name' => 'Chloe Mitchell',
                    'type' => 'director',
                    'file_url' => '/dummy-images/castcrew/director/chloe_mitchell.png',
                    'bio' => 'Dynamic director recognized for her powerful horror films. 👻',
                    'place_of_birth' => 'Sydney, Australia',
                    'dob' => '1989-12-25',
                    'designation' => 'Director',
                ],
                [
                    'name' => 'Sarah Foster',
                    'type' => 'director',
                    'file_url' => '/dummy-images/castcrew/director/sarah_foster.png',
                    'bio' => 'Acclaimed director known for her inspirational and motivational films. 🌟',
                    'place_of_birth' => 'Mexico City, Mexico',
                    'dob' => '1987-08-24',
                    'designation' => 'Director',
                ],
                [
                    'name' => 'Victoria Evans',
                    'type' => 'director',
                    'file_url' => '/dummy-images/castcrew/director/victoria_evans.png',
                    'bio' => 'Visionary director celebrated for her thrilling and suspenseful films. 🔪',
                    'place_of_birth' => 'London, UK',
                    'dob' => '1986-11-27',
                    'designation' => 'Director',
                ],
                [
                    'name' => 'Ava Brown',
                    'type' => 'director',
                    'file_url' => '/dummy-images/castcrew/director/ava_brown.png',
                    'bio' => 'Renowned for her action-packed and high-energy films. 💥',
                    'place_of_birth' => 'Toronto, Canada',
                    'dob' => '1988-09-06',
                    'designation' => 'Director',
                ],
                [
                    'name' => 'Sophia Lee',
                    'type' => 'director',
                    'file_url' => '/dummy-images/castcrew/director/sophia_lee.png',
                    'bio' => 'Celebrated director known for her compelling drama films. 🎭',
                    'place_of_birth' => 'Sydney, Australia',
                    'dob' => '1991-08-30',
                    'designation' => 'Director',
                ],

            ];

            if (env('IS_DUMMY_DATA')) {
                foreach ($castAndCrew as $genersData) {
                    $posterPath = $genersData['file_url'] ?? null;
                    $gener = CastCrew::create(Arr::except($genersData, ['file_url']));

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
