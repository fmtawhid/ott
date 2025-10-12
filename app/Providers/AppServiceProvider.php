<?php

namespace App\Providers;

use App\Services\ChatGTPService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Translation\Translator;
use Illuminate\Console\Events\CommandStarting;
use Illuminate\Support\Facades\Event;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        ini_set('memory_limit', '512M');
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);

        $this->app->singleton(ChatGTPService::class, function ($app) {
            return new ChatGTPService();
        });

        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Event::listen(CommandStarting::class, function (CommandStarting $event) {
            if (app()->environment('production')) {
                if (in_array($event->command, ['migrate:fresh', 'db:wipe', 'db:seed'])) {
                    throw new \Exception("❌ Command '{$event->command}' is blocked in production.");
                }
            }
        });

        Paginator::useBootstrap();

        Blade::directive('hasPermission', function ($permissions) {
            return "<?php if(Auth::user()->can({$permissions})): ?>";
        });

        Blade::directive('endhasPermission', function () {
            return '<?php endif; ?>';
        });

        $this->app->singleton('translation.loader', function ($app) {
            return new CustomTranslationLoader($app['files'], $app['path.lang']);
        });

        $this->app->singleton('translator', function ($app) {
            $loader = $app['translation.loader'];

            $locale = $app['config']['app.locale'];

            $trans = new Translator($loader, $locale);

            $trans->setFallback($app['config']['app.fallback_locale']);

            return $trans;
        });
    }
}
