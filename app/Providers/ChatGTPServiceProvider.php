<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use App\Services\ChatGTPService;

class ChatGTPServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ChatGTPService::class, function ($app) {
            return new ChatGTPService();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
