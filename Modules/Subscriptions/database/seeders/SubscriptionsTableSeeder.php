<?php

namespace Modules\Subscriptions\database\seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SubscriptionsTableSeeder extends Seeder
{

    /**
     *
     * @return void
     */
    public function run()
    {
        \DB::table('subscriptions')->delete();

        $subscriptions = [
            [
                'plan_id' => 2,
                'user_id' => 14,
                'start_date' => Carbon::today()->subDays(rand(25, 30)),
                'status' => 'active',
                'amount' => 20,
                'total_amount' => 20,
                'tax_amount' => 0.0,
                'name' => 'Premium Plan',
                'identifier' => 'premium_plan',
                'type' => 'month',
                'duration' => 1,
                'level' => 2,
                'plan_type' => '[{"id":1,"planlimitation_id":1,"limitation_title":"Video Cast","limitation_value":1,"limit":null,"slug":"video-cast","status":1,"message":"Cast videos to your TV with ease."},{"id":2,"planlimitation_id":2,"limitation_title":"Ads","limitation_value":1,"limit":null,"slug":"ads","status":1,"message":"This plan includes ads."},{"id":3,"planlimitation_id":3,"limitation_title":"Device Limit","limitation_value":1,"limit":{"value":"1"},"slug":"device-limit","status":1,"message":"Stream on up to 1 devices simultaneously."},{"id":4,"planlimitation_id":4,"limitation_title":"Download Status","limitation_value":1,"limit":{"480p":1,"720p":1,"1080p":1,"1440p":0,"2K":0,"4K":0,"8K":0},"slug":"download-status","status":1,"message":"Enjoy unlimited downloads with this plan."},{"id":17,"planlimitation_id":5,"limitation_title":"Supported Device Type","limitation_value":1,"limit":{"tablet":"0","laptop":"0","mobile":"1"},"slug":"supported-device-type","status":1,"message":null},{"id":18,"planlimitation_id":6,"limitation_title":"Profile Limit","limitation_value":1,"limit":{"value":"2"},"slug":"profile-limit","status":1,"message":null}]',
                'payment_id' => 8,
                'device_id' => '5',

            ],
            [
                'plan_id' => 2,
                'user_id' => 5,
                'start_date' => Carbon::today()->subMonths(3)->addDays(rand(1, 7)),
                'status' => 'active',
                'amount' => 20,
                'total_amount' => 20,
                'tax_amount' => 0.0,
                'name' => 'Premium Plan',
                'identifier' => 'premium_plan',
                'type' => 'month',
                'duration' => 1,
                'level' => 2,
                'plan_type' => '[{"id":1,"planlimitation_id":1,"limitation_title":"Video Cast","limitation_value":1,"limit":null,"slug":"video-cast","status":1,"message":"Cast videos to your TV with ease."},{"id":2,"planlimitation_id":2,"limitation_title":"Ads","limitation_value":1,"limit":null,"slug":"ads","status":1,"message":"This plan includes ads."},{"id":3,"planlimitation_id":3,"limitation_title":"Device Limit","limitation_value":1,"limit":{"value":"1"},"slug":"device-limit","status":1,"message":"Stream on up to 1 devices simultaneously."},{"id":4,"planlimitation_id":4,"limitation_title":"Download Status","limitation_value":1,"limit":{"480p":1,"720p":1,"1080p":1,"1440p":0,"2K":0,"4K":0,"8K":0},"slug":"download-status","status":1,"message":"Enjoy unlimited downloads with this plan."},{"id":17,"planlimitation_id":5,"limitation_title":"Supported Device Type","limitation_value":1,"limit":{"tablet":"0","laptop":"0","mobile":"1"},"slug":"supported-device-type","status":1,"message":null},{"id":18,"planlimitation_id":6,"limitation_title":"Profile Limit","limitation_value":1,"limit":{"value":"2"},"slug":"profile-limit","status":1,"message":null}]',
                'payment_id' => 3,
                'device_id' => '3',
            ],
            [
                'plan_id' => 3,
                'user_id' => 3,
                'start_date' => Carbon::today()->subDays(rand(25, 30)),
                'status' => 'active',
                'amount' => 50,
                'total_amount' => 50,
                'tax_amount' => 0.0,
                'name' => 'Ultimate Plan',
                'identifier' => 'ultimate_plan',
                'type' => 'month',
                'duration' => 3,
                'level' => 3,
                'plan_type' => '[{"id":9,"planlimitation_id":1,"limitation_title":"Video Cast","limitation_value":1,"limit":null,"slug":"video-cast","status":1,"message":"Cast videos to your TV with ease."},{"id":10,"planlimitation_id":2,"limitation_title":"Ads","limitation_value":0,"limit":null,"slug":"ads","status":1,"message":"Ad-free streaming with this plan."},{"id":11,"planlimitation_id":3,"limitation_title":"Device Limit","limitation_value":1,"limit":{"value":"5"},"slug":"device-limit","status":1,"message":"Stream on up to 5 devices simultaneously."},{"id":12,"planlimitation_id":4,"limitation_title":"Download Status","limitation_value":1,"limit":{"480p":1,"720p":1,"1080p":1,"1440p":1,"2K":1,"4K":0,"8K":0},"slug":"download-status","status":1,"message":"Enjoy unlimited downloads with this plan."},{"id":21,"planlimitation_id":5,"limitation_title":"Supported Device Type","limitation_value":1,"limit":{"tablet":"0","laptop":"1","mobile":"1"},"slug":"supported-device-type","status":1,"message":null},{"id":22,"planlimitation_id":6,"limitation_title":"Profile Limit","limitation_value":1,"limit":{"value":"3"},"slug":"profile-limit","status":1,"message":null}]',
                'payment_id' => 1,
                'device_id' => 'test11',
            ],
            [
                'plan_id' => 3,
                'user_id' => 6,
                'start_date' => Carbon::today()->subMonths(4)->addDays(rand(1, 7)),
                'status' => 'active',
                'amount' => 50,
                'total_amount' => 50,
                'tax_amount' => 0.0,
                'name' => 'Ultimate Plan',
                'identifier' => 'ultimate_plan',
                'type' => 'month',
                'duration' => 3,
                'level' => 3,
                'plan_type' => '[{"id":9,"planlimitation_id":1,"limitation_title":"Video Cast","limitation_value":1,"limit":null,"slug":"video-cast","status":1,"message":"Cast videos to your TV with ease."},{"id":10,"planlimitation_id":2,"limitation_title":"Ads","limitation_value":0,"limit":null,"slug":"ads","status":1,"message":"Ad-free streaming with this plan."},{"id":11,"planlimitation_id":3,"limitation_title":"Device Limit","limitation_value":1,"limit":{"value":"5"},"slug":"device-limit","status":1,"message":"Stream on up to 5 devices simultaneously."},{"id":12,"planlimitation_id":4,"limitation_title":"Download Status","limitation_value":1,"limit":{"480p":1,"720p":1,"1080p":1,"1440p":1,"2K":1,"4K":0,"8K":0},"slug":"download-status","status":1,"message":"Enjoy unlimited downloads with this plan."},{"id":21,"planlimitation_id":5,"limitation_title":"Supported Device Type","limitation_value":1,"limit":{"tablet":"0","laptop":"1","mobile":"1"},"slug":"supported-device-type","status":1,"message":null},{"id":22,"planlimitation_id":6,"limitation_title":"Profile Limit","limitation_value":1,"limit":{"value":"3"},"slug":"profile-limit","status":1,"message":null}]',
                'payment_id' => 4,
                'device_id' => '3',
            ],
            [
                'plan_id' => 1,
                'user_id' => 4,
                'start_date' => Carbon::today()->addDays(rand(1, 30)),
                'status' => 'active',
                'amount' => 5,
                'total_amount' => 5,
                'tax_amount' => 0.0,
                'name' => 'Basic',
                'identifier' => 'basic',
                'type' => 'week',
                'duration' => 1,
                'level' => 1,
                'plan_type' => '[{"id":1,"planlimitation_id":1,"limitation_title":"Video Cast","limitation_value":1,"limit":null,"slug":"video-cast","status":1,"message":"Cast videos to your TV with ease."},{"id":2,"planlimitation_id":2,"limitation_title":"Ads","limitation_value":1,"limit":null,"slug":"ads","status":1,"message":"This plan includes ads."},{"id":3,"planlimitation_id":3,"limitation_title":"Device Limit","limitation_value":1,"limit":{"value":"1"},"slug":"device-limit","status":1,"message":"Stream on up to 1 devices simultaneously."},{"id":4,"planlimitation_id":4,"limitation_title":"Download Status","limitation_value":1,"limit":{"480p":1,"720p":1,"1080p":1,"1440p":0,"2K":0,"4K":0,"8K":0},"slug":"download-status","status":1,"message":"Enjoy unlimited downloads with this plan."},{"id":17,"planlimitation_id":5,"limitation_title":"Supported Device Type","limitation_value":1,"limit":{"tablet":"0","laptop":"0","mobile":"1"},"slug":"supported-device-type","status":1,"message":null},{"id":18,"planlimitation_id":6,"limitation_title":"Profile Limit","limitation_value":1,"limit":{"value":"2"},"slug":"profile-limit","status":1,"message":null}]',
                'payment_id' => 2,
                'device_id' => 'test11',
            ],
            [
                'plan_id' => 1,
                'user_id' => 10,
                'start_date' => Carbon::today()->subDays(rand(25, 30)),
                'status' => 'active',
                'amount' => 5,
                'total_amount' => 5,
                'tax_amount' => 0.0,
                'name' => 'Basic',
                'identifier' => 'basic',
                'type' => 'week',
                'duration' => 1,
                'level' => 1,
                'plan_type' => '[{"id":1,"planlimitation_id":1,"limitation_title":"Video Cast","limitation_value":1,"limit":null,"slug":"video-cast","status":1,"message":"Cast videos to your TV with ease."},{"id":2,"planlimitation_id":2,"limitation_title":"Ads","limitation_value":1,"limit":null,"slug":"ads","status":1,"message":"This plan includes ads."},{"id":3,"planlimitation_id":3,"limitation_title":"Device Limit","limitation_value":1,"limit":{"value":"1"},"slug":"device-limit","status":1,"message":"Stream on up to 1 devices simultaneously."},{"id":4,"planlimitation_id":4,"limitation_title":"Download Status","limitation_value":1,"limit":{"480p":1,"720p":1,"1080p":1,"1440p":0,"2K":0,"4K":0,"8K":0},"slug":"download-status","status":1,"message":"Enjoy unlimited downloads with this plan."},{"id":17,"planlimitation_id":5,"limitation_title":"Supported Device Type","limitation_value":1,"limit":{"tablet":"0","laptop":"0","mobile":"1"},"slug":"supported-device-type","status":1,"message":null},{"id":18,"planlimitation_id":6,"limitation_title":"Profile Limit","limitation_value":1,"limit":{"value":"2"},"slug":"profile-limit","status":1,"message":null}]',
                'payment_id' => 7,
                'device_id' => '4',
            ],
            [
                'plan_id' => 4,
                'user_id' => 8,
                'start_date' => Carbon::today()->subYears(1)->addDays(rand(1, 7)),
                'status' => 'active',
                'amount' => 80,
                'total_amount' => 80,
                'tax_amount' => 0.0,
                'name' => 'Elite Plan',
                'identifier' => 'elite_plan',
                'type' => 'year',
                'duration' => 1,
                'level' => 4,
                'plan_type' => '[{"id":13,"planlimitation_id":1,"limitation_title":"Video Cast","limitation_value":1,"limit":null,"slug":"video-cast","status":1,"message":"Cast videos to your TV with ease."},{"id":14,"planlimitation_id":2,"limitation_title":"Ads","limitation_value":0,"limit":null,"slug":"ads","status":1,"message":"Ad-free streaming with this plan."},{"id":15,"planlimitation_id":3,"limitation_title":"Device Limit","limitation_value":1,"limit":{"value":"8"},"slug":"device-limit","status":1,"message":"Stream on up to 8 devices simultaneously."},{"id":16,"planlimitation_id":4,"limitation_title":"Download Status","limitation_value":1,"limit":{"480p":1,"720p":1,"1080p":1,"1440p":1,"2K":1,"4K":1,"8K":1},"slug":"download-status","status":1,"message":"Enjoy unlimited downloads with this plan."},{"id":23,"planlimitation_id":5,"limitation_title":"Supported Device Type","limitation_value":1,"limit":{"tablet":"1","laptop":"1","mobile":"1"},"slug":"supported-device-type","status":1,"message":null},{"id":24,"planlimitation_id":6,"limitation_title":"Profile Limit","limitation_value":1,"limit":{"value":"4"},"slug":"profile-limit","status":1,"message":null}]',
                'payment_id' => 5,
                'device_id' => '4',
            ],
            [
                'plan_id' => 4,
                'user_id' => 9,
                'start_date' => Carbon::today()->subMonths(1)->addDays(rand(1, 30)),
                'status' => 'active',
                'amount' => 80,
                'total_amount' => 80,
                'tax_amount' => 0.0,
                'name' => 'Elite Plan',
                'identifier' => 'elite_plan',
                'type' => 'year',
                'duration' => 1,
                'level' => 4,
                'plan_type' => '[{"id":13,"planlimitation_id":1,"limitation_title":"Video Cast","limitation_value":1,"limit":null,"slug":"video-cast","status":1,"message":"Cast videos to your TV with ease."},{"id":14,"planlimitation_id":2,"limitation_title":"Ads","limitation_value":0,"limit":null,"slug":"ads","status":1,"message":"Ad-free streaming with this plan."},{"id":15,"planlimitation_id":3,"limitation_title":"Device Limit","limitation_value":1,"limit":{"value":"8"},"slug":"device-limit","status":1,"message":"Stream on up to 8 devices simultaneously."},{"id":16,"planlimitation_id":4,"limitation_title":"Download Status","limitation_value":1,"limit":{"480p":1,"720p":1,"1080p":1,"1440p":1,"2K":1,"4K":1,"8K":1},"slug":"download-status","status":1,"message":"Enjoy unlimited downloads with this plan."},{"id":23,"planlimitation_id":5,"limitation_title":"Supported Device Type","limitation_value":1,"limit":{"tablet":"1","laptop":"1","mobile":"1"},"slug":"supported-device-type","status":1,"message":null},{"id":24,"planlimitation_id":6,"limitation_title":"Profile Limit","limitation_value":1,"limit":{"value":"4"},"slug":"profile-limit","status":1,"message":null}]',
                'payment_id' => 6,
                'device_id' => '4',
            ],

        ];

        foreach ($subscriptions as &$subscription) {
            $start_date = Carbon::parse($subscription['start_date']);
            $duration = $subscription['duration'];
            $type = $subscription['type'];

            switch ($type) {
                case 'day':
                    $subscription['end_date'] = $start_date->addDays($duration);
                    break;
                case 'week':
                    $subscription['end_date'] = $start_date->addWeeks($duration);
                    break;
                case 'month':
                    $subscription['end_date'] = $start_date->addMonths($duration);
                    break;
                case 'year':
                    $subscription['end_date'] = $start_date->addYears($duration);
                    break;
                default:
                    break;
            }

            if ($subscription['end_date']->lt(Carbon::today())) {
                $subscription['status'] = 'inactive';
            }
        }

        \DB::table('subscriptions')->insert($subscriptions);
    }
}

