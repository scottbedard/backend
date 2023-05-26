<?php

namespace Bedard\Backend;

use Bedard\Backend\Configuration\Backend;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
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

        // register components
        Blade::componentNamespace('Bedard\\Backend\\View\\Components', 'backend');
 
        // public assets
        $this->publishes([
            __DIR__ . '/../config/backend.php' => config_path('backend.php'),
            __DIR__ . '/../public' => public_path('vendor/backend'),
        ], 'backend');

        // // register validation rules
        // Validator::extend('breakpoints', function ($attributes, $span) {
        //     $check = fn ($val) => is_integer($val) && $val >= 0 && $val <= 12;

        //     if (is_integer($span) && $check($span)) {
        //         return true;
        //     }
            
        //     if (Arr::isAssoc($span)) {
        //         foreach ($span as $key => $val) {
        //             if (!is_string($key) || !$check($val)) {
        //                 return false;
        //             }
        //         }
        //     }

        //     return true;
        // }, 'Span values must be an integer between 0 and 12');

        // register backend commands in console
        if ($this->app->runningInConsole()) {
            $this->commands([
                \Bedard\Backend\Console\AssignRoleCommand::class,
                \Bedard\Backend\Console\MakeControllerCommand::class,
            ]);
        }

        // register super admin gate
        $super = config('backend.super_admin_role');

        if ($super) {
            Gate::before(fn ($user, $ability) => $user->hasRole($super) ? true : null);
        }
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        // register backend singleton
        $this->app->singleton('backend', function () {
            return Backend::create(__DIR__ . '/Backend', config('backend.backend_directory'));
        });
    }
}