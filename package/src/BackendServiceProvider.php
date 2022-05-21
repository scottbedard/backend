<?php

namespace Bedard\Backend;

use Bedard\Backend\Http\Middleware\BackendMiddleware;
use Bedard\Backend\Models\BackendPermission;
use Illuminate\Routing\Router;
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
        $this->bootMiddleware();
        $this->bootMigrations();
        $this->bootModels();
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
            \Bedard\Backend\Console\PermissionCommand::class,
            \Bedard\Backend\Console\ResourceCommand::class,
        ]);
    }

    /**
     * Bootstrap middleware.
     *
     * @return void
     */
    private function bootMiddleware()
    {
        $router = $this->app->make(Router::class);

        $router->aliasMiddleware(config('backend.middleware_alias'), BackendMiddleware::class);
    }

    /**
     * Bootstrap migrations.
     *
     * @return void
     */
    private function bootMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    /**
     * Boot models.
     *
     * @return void
     */
    private function bootModels()
    {
        $model = config('backend.user');

        $model::resolveRelationUsing('backendPermissions', function ($user) {
            return $user->hasMany(BackendPermission::class, 'user_id');
        });

        $model::addGlobalScope('hasBackendPermission', function () {
            // dd('hello');
        });

        BackendPermission::resolveRelationUsing('user', function ($permission) use ($model) {
            return $permission->belongsTo($model, 'id');
        });
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
            __DIR__ . '/../../client/public' => public_path('vendor/backend'),
        ], 'backend');
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
     * Bootstrap views.
     *
     * @return void
     */
    private function bootViews()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'backend');
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