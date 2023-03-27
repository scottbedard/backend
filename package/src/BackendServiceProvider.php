<?php

namespace Bedard\Backend;

use Illuminate\Support\Facades\Gate;
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
        // load backend files
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'backend');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'backend');

        // public assets
        $this->publishes([
            __DIR__ . '/../config/backend.php' => config_path('backend.php'),
            __DIR__ . '/../public' => public_path('vendor/backend'),
        ], 'backend');

        // register backend commands in console
        if ($this->app->runningInConsole()) {
            $this->commands([
                \Bedard\Backend\Console\AssignRoleCommand::class,
                \Bedard\Backend\Console\ControllerCommand::class,
            ]);
        }

        // configure super-admin role
        Gate::before(fn ($user) => $user->hasRole(config('backend.super_admin_role')) ? true : null);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        // register backend facade
        $this->app->bind('backend', fn () => new \Bedard\Backend\Classes\Backend);
    }
}