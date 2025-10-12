<?php

namespace Modules\Constant\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Modules\Constant\Repositories\ConstantRepository;
use Modules\Constant\Repositories\ConstantRepositoryInterface;
use Symfony\Component\Finder\Finder;

class ConstantServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    protected $moduleName = 'Constant';

    /**
     * @var string
     */
    protected $moduleNameLower = 'constant';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(base_path('Modules/Constant/database/migrations'));

        // adding global middleware
        $kernel = $this->app->make('Illuminate\Contracts\Http\Kernel');

        // register commands
        $this->registerCommands('\Modules\Constant\Console\Commands');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // $this->app->register(RouteServiceProvider::class);
        $this->app->bind(ConstantRepositoryInterface::class, ConstantRepository::class);

    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            base_path('Modules/Constant/Config/config.php') => config_path($this->moduleNameLower.'.php'),
        ], 'config');
        $this->mergeConfigFrom(
            base_path('Modules/Constant/Config/config.php'), $this->moduleNameLower
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/'.$this->moduleNameLower);

        $sourcePath = base_path('Modules/Constant/Resources/views');

        $this->publishes([
            $sourcePath => $viewPath,
        ], ['views', $this->moduleNameLower.'-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'constant');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (Config::get('view.paths') as $path) {
            if (is_dir($path.'/modules/'.$this->moduleNameLower)) {
                $paths[] = $path.'/modules/'.$this->moduleNameLower;
            }
        }

        return $paths;
    }

    /**
     * Register commands.
     *
     * @param  string  $namespace
     */
    protected function registerCommands($namespace = '')
    {
        $finder = new Finder(); // from Symfony\Component\Finder;
        $finder->files()->name('*.php')->in(__DIR__.'/../Console');

        $classes = [];
        foreach ($finder as $file) {
            $class = $namespace.'\\'.$file->getBasename('.php');
            array_push($classes, $class);
        }

        $this->commands($classes);
    }
}
