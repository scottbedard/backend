<?php

namespace Bedard\Backend;

use Backend;
use Illuminate\Support\ServiceProvider;

class BackendServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->bootConsoleCommands();
        $this->bootPublished();
        $this->bootRoutes();
        $this->bootViews();
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConfig();
        $this->registerFacades();
    }

    /**
     * Bootstrap console commands.
     *
     * @return void
     */
    private function bootConsoleCommands()
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            \Bedard\Backend\Console\ResourceCommand::class,
        ]);
    }

    /**
     * Bootstrap published files.
     *
     * @return void
     */
    private function bootPublished()
    {
        $this->publishes([
            __DIR__ . '/../config/backend.php' => config_path('backend.php'),
        ], 'backend');
    }

    /**
     * Bootstrap views.
     *
     * @return void
     */
    private function bootViews()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'backend');
    }

    /**
     * Bootstrap backend routes.
     *
     * @return void
     */
    private function bootRoutes()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
    }

    /**
     * Register package configuration.
     *
     * @return void
     */
    private function registerConfig()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/backend.php', 'backend');
    }

    /**
     * Register facades.
     *
     * @return void
     */
    private function registerFacades()
    {
        $this->app->bind('backend', function () {
            return new \Bedard\Backend\Backend();
        });
    }
}