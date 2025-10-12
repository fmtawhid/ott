<?php

namespace Database\Seeders\Auth;

use App\Events\Backend\UserCreated;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use App\Models\Address;
use App\Models\UserMultiProfile;
use Laravolt\Avatar\Facade as Avatar;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Class UserTableSeeder.
 */
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seed.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        // Add the master administrator, user id of 1
        $avatarPath = config('app.avatar_base_path');
        
         if(env('IS_DUMMY_DATA')==false){

            
             
             $users = [
            
            [
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'email' => 'admin@streamit.com',
                'password' => Hash::make('12345678'),
                'mobile' => '+12123567890',
                'date_of_birth' => fake()->date,
                'file_url' => '/dummy-images/profile/admin/super_admin.png',
                'gender' => 'female',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'user_type' => 'admin',
                'is_subscribe' => 0,
            ],
            [
                'first_name' => 'Ivan',
                'last_name' => 'Norris',
                'email' => 'demo@streamit.com',
                'password' => Hash::make('12345678'),
                'mobile' => '+12124567899',
                'date_of_birth' => fake()->date,
                'file_url' => '/dummy-images/profile/admin/demo_admin.png',
                'gender' => 'male',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'user_type' => 'demo_admin',
                'is_subscribe' => 0,
            ]
            
         ];
            
          
          
         }else{
             
             
       

        $users = [
             
            
          
            [
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'email' => 'admin@streamit.com',
                'password' => Hash::make('12345678'),
                'mobile' => '+12123567890',
                'date_of_birth' => fake()->date,
                'file_url' => '/dummy-images/profile/admin/super_admin.png',
                'gender' => 'female',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'user_type' => 'admin',
                'is_subscribe' => 0,
            ],
            [
                'first_name' => 'Ivan',
                'last_name' => 'Norris',
                'email' => 'demo@streamit.com',
                'password' => Hash::make('12345678'),
                'mobile' => '+12124567899',
                'date_of_birth' => fake()->date,
                'file_url' => '/dummy-images/profile/admin/demo_admin.png',
                'gender' => 'male',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'user_type' => 'demo_admin',
                'is_subscribe' => 0,
            ],
            
            //user

            // [
            //     'first_name' => 'John',
            //     'last_name' => 'Doe',
            //     'email' => 'john@streamit.com',
            //     'password' => Hash::make('12345678'),
            //     'mobile' => '1-4578952512',
            //     'date_of_birth' =>fake()->date, // Replacefake()->date with the actual date of birth
            //     'profile_image' => '/dummy-images/profile/user/john.png'),
            //     'gender' => 'male',
            //     'email_verified_at' => Carbon::now(),
            //     'created_at' => Carbon::now(),
            //     'updated_at' => Carbon::now(),
            //     'user_type' => 'user',
            //     'is_subscribe' => 0,
            // ]

            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john@gmail.com',
                'password' => Hash::make('12345678'),
                'mobile' => '+911234567890',
                'login_type'=>'otp',
                'date_of_birth' => '1990-02-13',
                'login_type'=>'otp',
                'address' => '101 Pine Lane Miami, FL 33101 United States',
                'gender' => 'male',
                'status' => 1,
                'file_url' => '/dummy-images/profile/user/john.png',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'user_type' => 'user',
                'is_subscribe' => 1,
            ],
            [
                'first_name' => 'Tristan',
                'last_name' => 'Erickson',
                'email' => 'tristan@gmail.com',
                'password' => Hash::make('12345678'),
                'mobile' => '+447911123456',
                'login_type'=>'otp',
                'date_of_birth' => '1992-05-21',
                'address' => '46 Oxford Road London, W1D 1BS United Kingdom',
                'gender' => 'male',
                'status' => 1,
                'file_url' => '/dummy-images/profile/user/tristan.png',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'user_type' => 'user',
                'is_subscribe' => 1,
            ],
            [
                'first_name' => 'Felix',
                'last_name' => 'Harris',
                'email' => 'felix@gmail.com',
                'password' => Hash::make('12345678'),
                'mobile' => '+12124567890',
                'login_type'=>'otp',
                'date_of_birth' => '1996-02-02',
                'address' => '3 Queen Street Sydney, NSW 2000 Australia',
                'gender' => 'male',
                'status' => 1,
                'file_url' => '/dummy-images/profile/user/felix.png',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'user_type' => 'user',
                'is_subscribe' => 1,
            ],
            [
                'first_name' => 'Harry',
                'last_name' => 'Victoria',
                'email' => 'harry@gmail.com',
                'password' => Hash::make('12345678'),
                'mobile' => '+447911123456',
                'login_type'=>'otp',
                'date_of_birth' => '1987-07-08',
                'address' => '11 Rue de Rivoli Paris, 75001 France',
                'gender' => 'male',
                'status' => 1,
                'file_url' => '/dummy-images/profile/user/harry.png',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'user_type' => 'user',
                'is_subscribe' => 1,
            ],
            [
                'first_name' => 'Jorge',
                'last_name' => 'Perez',
                'email' => 'jorge@gmail.com',
                'password' => Hash::make('12345678'),
                'mobile' => '+496912345678',
                'login_type'=>'otp',
                'date_of_birth' => '1991-01-01',
                'address' => '20 Kurfürstendamm Berlin, 10719 Germany',
                'gender' => 'male',
                'status' => 1,
                'file_url' => '/dummy-images/profile/user/jorge.png',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'user_type' => 'user',
                'is_subscribe' => 0,
            ],
            [
                'first_name' => 'Joy',
                'last_name' => 'Hanry',
                'email' => 'joy@gmail.com',
                'password' => Hash::make('12345678'),
                'mobile' => '+81312345678',
                'login_type'=>'otp',
                'date_of_birth' => '1993-07-10',
                'address' => '3 Shibuya Street Tokyo, 150-0002 Japan',
                'gender' => 'male',
                'status' => 1,
                'file_url' => '/dummy-images/profile/user/joy.png',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'user_type' => 'user',
                'is_subscribe' => 1,
            ],
            [
                'first_name' => 'Deborah',
                'last_name' => 'Thomas',
                'email' => 'deborah@gmail.com',
                'password' => Hash::make('12345678'),
                'mobile' => '+81312355678',
                'login_type'=>'otp',
                'date_of_birth' => '1992-03-26',
                'address' => '7 Maple Avenue Toronto, ON M5H 2N2 Canada',
                'gender' => 'female',
                'status' => 1,
                'file_url' => '/dummy-images/profile/user/deborah.png',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'user_type' => 'user',
                'is_subscribe' => 1,
            ],
            [
                'first_name' => 'Katie',
                'last_name' => 'Brown',
                'email' => 'katie@gmail.com',
                'password' => Hash::make('12345678'),
                'mobile' => '+12124467890',
                'login_type'=>'otp',
                'date_of_birth' => '1994-08-16',
                'address' => '14 Gran Vía Madrid, 28013 Spain',
                'gender' => 'female',
                'status' => 1,
                'file_url' => '/dummy-images/profile/user/katie.png',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'user_type' => 'user',
                'is_subscribe' => 1,
            ],
            [
                'first_name' => 'Dorothy',
                'last_name' => 'Erickson',
                'email' => 'dorothy@gmail.com',
                'password' => Hash::make('12345678'),
                'mobile' => '+12124577890',
                'login_type'=>'otp',
                'date_of_birth' => '1989-10-10',
                'address' => '50 Paulista Avenue São Paulo, SP 01310-100 Brazil',
                'gender' => 'female',
                'status' => 1,
                'file_url' => '/dummy-images/profile/user/dorothy.png',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'user_type' => 'user',
                'is_subscribe' => 0,
            ],
            [
                'first_name' => 'Lisa',
                'last_name' => 'Lucas',
                'email' => 'lisa@gmail.com',
                'password' => Hash::make('12345678'),
                'mobile' => '+12124567790',
                'login_type'=>'otp',
                'date_of_birth' => '1993-08-03',
                'address' => '6 Sheikh Zayed Road Dubai, 00000 United Arab Emirates',
                'gender' => 'female',
                'status' => 1,
                'file_url' => '/dummy-images/profile/user/lisa.png',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'user_type' => 'user',
                'is_subscribe' => 0,
            ],
            [
                'first_name' => 'Tracy',
                'last_name' => 'Jones',
                'email' => 'tracy@gmail.com',
                'password' => Hash::make('12345678'),
                'mobile' => '+913465656789',
                'login_type'=>'otp',
                'date_of_birth' => '1990-11-19',
                'address' => '71 Orchard Road Singapore, 238838 Singapore',
                'gender' => 'female',
                'status' => 1,
                'file_url' => '/dummy-images/profile/user/tracy.png',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'user_type' => 'user',
                'is_subscribe' => 0,
            ],
            [
                'first_name' => 'Stella',
                'last_name' => 'Green',
                'email' => 'stella@gmail.com',
                'password' => Hash::make('12345678'),
                'mobile' => '+913465756789',
                'login_type'=>'otp',
                'date_of_birth' => '1991-12-18',
                'address' => '15 Redwood Way Phoenix, AZ 85001 United States',
                'gender' => 'female',
                'status' => 1,
                'file_url' => '/dummy-images/profile/user/stella.png',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'user_type' => 'user',
                'is_subscribe' => 1,
            ]


        ];
        
         }


      
            foreach ($users as $key => $user_data) {
                $featureImage = $user_data['file_url'] ?? null;
                $userData = Arr::except($user_data, ['file_url']);
                $user = User::create($userData);

                $user->assignRole($user_data['user_type']);
                event(new UserCreated($user));


                if (isset($featureImage) &&  $featureImage !='') {


                  $profile_image = $this->uploadToSpaces($featureImage);

                 if ($profile_image) {
                    $user->file_url = extractFileNameFromUrl($profile_image);
                  }

                }

                $user->save();

                $this->createOrUpdateProfile($user);
            }

            Schema::enableForeignKeyConstraints();
    }

    private function uploadToSpaces($publicPath)
    {

       $localFilePath = public_path($publicPath);
       $remoteFilePath = 'streamit-laravel/' . basename($publicPath);



       if (file_exists($localFilePath)) {           // Get the active storage disk from the environment
           $disk = env('ACTIVE_STORAGE', 'local');

           if ($disk === 'local') {
               // Store in the public directory for local storage
               Storage::disk($disk)->put('public/' . $remoteFilePath, file_get_contents($localFilePath));

            //    dd(asset('storage/' . $remoteFilePath));
               return asset('storage/' . $remoteFilePath);
           } else {

            // dd( $disk);
               // Upload to the specified storage disk
               Storage::disk($disk)->put($remoteFilePath, file_get_contents($localFilePath));
               return Storage::disk($disk)->url($remoteFilePath);
           }


       }

       return false;
   }




    private function createOrUpdateProfile(User $user)
    {
        $name = $user->first_name . ' ' . $user->last_name;

        UserMultiProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'name' => $name,
                'avatar' => $this->generateAvatar($name), // Generate avatar based on name
            ]
        );
    }

    private function attachFeatureImage($model, $publicPath)
    {
        if (!env('IS_DUMMY_DATA_IMAGE')) return false;

        $file = new \Illuminate\Http\File($publicPath);

        $media = $model->addMedia($file)->preservingOriginal()->toMediaCollection('file_url');

        return $media->getUrl();
    }

    // Generate avatar based on user name and store it
    private function generateAvatar($name)
    {
        $name = $name ?? Str::random(10);

        $fileName = Str::random(10) . '.png';
        $filePath = 'avatars/' . $fileName;

        if (!Storage::exists('public/avatars')) {
            Storage::makeDirectory('public/avatars');
        }

        Avatar::create($name)->save(storage_path('app/public/' . $filePath));

        return asset('storage/' . $filePath);
    }
}
