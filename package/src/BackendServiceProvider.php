<?php

namespace Bedard\Backend;

use Illuminate\Support\ServiceProvider;

class BackendServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'backend');
        
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'backend');

        $this->publishes([
            __DIR__ . '/../config/backend.php' => config_path('backend.php'),
            __DIR__ . '/../public' => public_path('vendor/backend'),
        ], 'backend');

        if ($this->app->runningInConsole()) {
            $this->commands([
                \Bedard\Backend\Console\AssignRoleCommand::class,
            ]);
        }
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        // ...
    }
}