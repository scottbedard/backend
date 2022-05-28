<?php

namespace Bedard\Backend;

use Bedard\Backend\Http\Middleware\BackendMiddleware;
use Bedard\Backend\Models\BackendPermission;
use Bedard\Backend\Models\BackendSetting;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
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
            \Bedard\Backend\Console\AuthorizeCommand::class,
            \Bedard\Backend\Console\DeauthorizeCommand::class,
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
        // extend user model
        $model = config('backend.user');

        $model::resolveRelationUsing('backendPermissions', function ($user) {
            return $user->hasMany(BackendPermission::class, 'user_id');
        });

        $model::resolveRelationUsing('backendSettings', function ($user) {
            return $user->hasMany(BackendSetting::class, 'user_id');
        });

        // add user relationship to backend models
        BackendPermission::resolveRelationUsing('user', function ($permission) use ($model) {
            return $permission->belongsTo($model, 'id');
        });

        BackendPermission::resolveRelationUsing('user', function ($setting) use ($model) {
            return $setting->belongsTo($model, 'id');
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
            __DIR__ . '/../public' => public_path('vendor/backend'),
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
        // load manifest file
        $manifest = public_path('vendor/backend/dist/manifest.json');

        if (File::exists($manifest)) {
            View::share('manifest', json_decode(File::get($manifest), true));
        } else {
            View::share('manifest', null);
        }

        // register components
        Blade::component('icon', \Bedard\Backend\Views\Components::class);

        Blade::componentNamespace('Bedard\\Backend\\Views\\Components', 'backend');

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