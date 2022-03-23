<?php

namespace Bedard\Backend;

use Illuminate\Support\ServiceProvider;

class BackendServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // ...
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->bootConsoleCommands();

        $this->publishes([
            __DIR__ . '/../config/backend.php' => config_path('backend.php'),
        ], 'backend');
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
}