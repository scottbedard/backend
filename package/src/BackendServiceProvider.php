<?php

namespace Bedard\Backend;

use Bedard\Backend\Facades\Backend;
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

        Gate::before(fn ($user) => $user->hasRole(config('backend.super_admin')) ? true : null);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind('backend', fn () => new Backend);
    }
}