<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Modules\Entertainment\Models\Entertainment;
use Modules\Episode\Models\Episode;
use Modules\Frontend\Models\PayPerView;
use Modules\Season\Models\Season;
use Modules\Video\Models\Video;

class SendPayPerViewExpiryNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-pay-per-view-expiry-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Pay-Per-View expiry reminder 2 days before video expires';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $twoDaysFromNow = Carbon::now()->addDays(2)->toDateString();

        $ppvs = PayPerView::whereDate('view_expiry_date', $twoDaysFromNow)->get();

        foreach ($ppvs as $ppv) {
            $user = User::find($ppv->user_id);
            $movie = null;
        
            switch ($ppv->type) {
                case 'movie':
                    $movie = Entertainment::find($ppv->movie_id);
                    break;
                case 'tvshow':
                    $movie = Entertainment::find($ppv->movie_id);
                    break;
                case 'video':
                    $movie = Video::find($ppv->movie_id);
                    break;
                case 'episode':
                    $movie = Episode::find($ppv->movie_id);
                    break;
                case 'season':
                    $movie = Season::find($ppv->movie_id);
                    break;
            }
        
            if (!$user || !$movie) continue;
        
            $notificationType = $ppv->type === 'rent' ? 'rent_expiry_reminder' : 'purchase_expiry_reminder';
        
            sendNotification([
                'notification_type' => $notificationType,
                'user_id' => $user->id,
                'user_name' => $user->full_name,
                'name' => $movie->name ?? 'Your Content',
                'content_type' => $ppv->type,
                'status' => 'active',
                'notification_group' => 'pay_per_view',
                'start_date' => $ppv->created_at->toDateString(),
                'end_date' => $ppv->view_expiry_date->toDateString(),
            ]);
        }

        $this->info("PPV expiry notifications sent for: {$twoDaysFromNow}");
    }
}
