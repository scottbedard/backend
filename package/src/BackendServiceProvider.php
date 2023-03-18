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

        $this->publishes([
            __DIR__ . '/../config/backend.php' => config_path('backend.php'),
            // __DIR__ . '/../public' => public_path('vendor/backend'),
        ], 'backend');
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