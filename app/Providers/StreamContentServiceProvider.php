<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\StreamContentService;

class StreamContentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(StreamContentService::class, function ($app) {
            return new StreamContentService();
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
