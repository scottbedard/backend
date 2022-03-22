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
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/backend.php' => config_path('backend.php'),
        ], 'backend');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // ...
    }
}