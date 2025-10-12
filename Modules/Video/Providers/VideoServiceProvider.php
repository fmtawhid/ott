<?php

namespace Modules\Video\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Finder\Finder;
use Modules\Video\Repositories\VideoRepositoryInterface;
use Modules\Video\Repositories\VideoRepository;

class VideoServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    protected $moduleName = 'Video';

    /**
     * @var string
     */
    protected $moduleNameLower = 'video';

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
        $this->loadMigrationsFrom(base_path('Modules/Video/database/migrations'));

        // adding global middleware
        $kernel = $this->app->make('Illuminate\Contracts\Http\Kernel');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(VideoRepositoryInterface::class, VideoRepository::class );
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            base_path('Modules/Video/Config/config.php') => config_path($this->moduleNameLower.'.php'),
        ], 'config');
        $this->mergeConfigFrom(
            base_path('Modules/Video/Config/config.php'), $this->moduleNameLower
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

        $sourcePath = base_path('Modules/Video/Resources/views');

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
        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'video');
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
