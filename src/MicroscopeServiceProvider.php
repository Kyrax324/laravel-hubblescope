<?php

namespace Microscope;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class MicroscopeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
		$config = $this->app['config']->get("telescope");
		$this->app['config']->set("telescope.ignore_paths", array_merge(["microscope*"], $config['ignore_paths']));
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerCommands();
        $this->registerPublishing();

        if (! config('telescope.enabled')) {
            return;
        }

        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__.'/Http/routes.php');
        });

		$this->loadViewsFrom(
            __DIR__.'/../resources/views', 'microscope'
        );
    }

    /**
     * Get the Telescope route group configuration array.
     *
     * @return array
     */
    private function routeConfiguration()
    {
        return [
            'domain' => config('telescope.domain', null),
            // 'prefix' => config('telescope.path'),
            'middleware' => 'telescope',
        ];
    }
    /**
     * Register the package's commands.
     *
     * @return void
     */
    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Console\PublishCommand::class,
            ]);
        }
    }

    /**
     * Register the package's publishable resources.
     *
     * @return void
     */
    private function registerPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../public' => public_path('vendor/microscope'),
            ], ['microscope-assets', 'laravel-assets']);

            // $this->publishes([
            //     __DIR__.'/../config/microscope.php' => config_path('microscope.php'),
            // ], 'microscope-config');
        }
    }
}
