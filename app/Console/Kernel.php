<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [

        'Modules\Subscriptions\Console\Commands\CheckSubscription',
        \App\Console\Commands\OptimizeImages::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('queue:work --tries=3 --stop-when-empty')->withoutOverlapping();

        // $schedule->command('migrate:fresh --seed')->hourlyAt(2);

        $schedule->command('notifications:send-ppv-expiry-reminders')->dailyAt('08:00');

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
