<?php

namespace App\Models;

use App\Models\Presenters\UserPresenter;
use App\Models\Traits\HasHashedMediaTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Modules\Subscriptions\Models\Subscription;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Permission\Traits\HasRoles;
use Modules\Entertainment\Models\Watchlist;
use Modules\Entertainment\Models\ContinueWatch;
use Laravolt\Avatar\Facade as Avatar;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class User extends Authenticatable implements HasMedia, MustVerifyEmail
{
    use HasFactory;
    use HasRoles;
    use Notifiable;
    use SoftDeletes;
    use HasHashedMediaTrait;
    use UserPresenter;
    use HasApiTokens;

    const CUSTOM_FIELD_MODEL = 'App\Models\User';

    protected $guarded = [
        'id',
        'updated_at',
        '_token',
        '_method',
        'password_confirmation',
    ];

    protected $dates = [
        'deleted_at',
        'date_of_birth',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'user_setting' => 'array',
        'pin' => 'string',
    ];

    protected $appends = ['full_name', 'profile_image'];

    public function getFullNameAttribute() // notice that the attribute name is in CamelCase.
    {
        return $this->first_name.' '.$this->last_name;
    }




    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function providers()
    {
        return $this->hasMany('App\Models\UserProvider');
    }

    /**
     * Get the list of users related to the current User.
     *
     * @return [array] roels
     */
    public function getRolesListAttribute()
    {
        return array_map('intval', $this->roles->pluck('id')->toArray());
    }

    /**
     * Route notifications for the Slack channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return string
     */
    public function routeNotificationForSlack($notification)
    {
        return env('SLACK_NOTIFICATION_WEBHOOK');
    }

    /**
     * Get all of the service_providers for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptionPackage()
    {

    return $this->hasOne(Subscription::class, 'user_id', 'id')
    ->where('status', config('constant.SUBSCRIPTION_STATUS.ACTIVE'))
    ->latest();
    }

    public function subscriptionPackageList()
    {

    return $this->hasMany(Subscription::class, 'user_id', 'id')
    ->where('status', config('constant.SUBSCRIPTION_STATUS.ACTIVE'))->orderBy('id', 'desc');

    }



    public function subscriptiondata()
    {
        return $this->hasMany(Subscription::class, 'user_id', 'id')->orderBy('start_date', 'desc');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1)->where('is_banned', 0);
    }

    public function devices()
    {
        return $this->hasMany(Device::class, 'user_id', 'id');
    }

    public function scopeCalenderResource($query)
    {
        $query->where('show_in_calender', 1);
    }

    protected function getProfileImageAttribute()
    {
        $media = $this->getFirstMediaUrl('profile_image');

        return isset($media) && ! empty($media) ? $media : asset(config('app.avatar_base_path').'avatar.webp');
    }


    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function scopeSetRole($query, $user)
    {

       $user_id = $user->id;
       auth()->user()->hasRole(['admin', 'demo_admin','user']);
    }

    public function watchList()
    {
        return $this->hasMany(Watchlist::class, 'user_id', 'id')->with('entertainment');
    }

    public function continueWatchnew()
    {
        return $this->hasMany(ContinueWatch::class, 'user_id', 'id');
    }

    public function continueWatch()
    {
        return $this->hasMany(ContinueWatch::class, 'user_id', 'id')->with('entertainment', 'episode');
    }

    public function userMultiProfile()
    {
        return $this->hasMany(UserMultiProfile::class, 'user_id', 'id');
    }
    public function generateAvatar($name = null)
    {
        // If no name is provided, use the user's name or a random string
        $name = $name ?? $this->first_name ?? Str::random(10);

        // Generate a random file name
        $fileName = Str::random(10) . '.png';
        $filePath = 'avatars/' . $fileName;

        // Ensure the 'avatars' directory exists
        if (!Storage::exists('public/avatars')) {
            Storage::makeDirectory('public/avatars');
        }

        // Create the avatar and save it to the storage folder (publicly accessible)
        Avatar::create($name)->save(storage_path('app/public/' . $filePath));

        // Generate the public URL for the saved avatar
        return asset('storage/' . $filePath);
    }
    public function createOrUpdateProfileWithAvatar(array $data = [])
    {
        $user = auth()->user();

        // Check if the user already has a profile
        $profile = UserMultiProfile::where('user_id', $this->id)->first();

        // If no profile exists, create a new one
        if (!$profile) {
            $profile = new UserMultiProfile();
            $profile->user_id = $this->id;
        }

        // Update or set profile fields
        $profile->name = $this->first_name ?? $data['name'] ?? $profile->name;
        $profile->avatar = $this->generateAvatar($profile->name); // Generate a new avatar

        // Additional data can be added if passed (e.g., other profile fields)
        foreach ($data as $key => $value) {
            if ($key !== 'user_id' && property_exists($profile, $key)) {
                $profile->$key = $value;
            }
        }

        // Save the profile (this will either create or update the profile)
        $profile->save();

        return $profile;
    }
    public function watchHistories()
    {
        return $this->hasMany(UserWatchHistory::class, 'user_id', 'id');
    }
}
