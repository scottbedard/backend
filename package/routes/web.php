<?php

use Bedard\Backend\BackendController;
use Bedard\Backend\Facades\Backend;
use Bedard\Backend\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Middlewares\PermissionMiddleware;

Route::group([
    'middleware' => ['web', \Bedard\Backend\Http\Middleware\Backend::class],
    'prefix' => config('backend.path'),
], function () {

    foreach (Backend::controllers() as $controller => $config) {
        Route::group([
            'prefix' => $controller,
            'middleware' => array_map(fn ($permission) => PermissionMiddleware::class . ":{$permission}", $config['permissions']),
        ], function () use ($controller, $config) {
            foreach ($config['routes'] as $method => $route) {
                Route::get($route['path'], [$config['class'], $method])
                    ->name("backend.{$controller}.{$method}")
                    ->middleware(array_map(fn ($p) => PermissionMiddleware::class . ":{$p}", $route['permissions']));
            }
        });
    }

    Route::get('/{path?}', [ClientController::class, 'index'])
        ->where('path', '.*')
        ->name('backend.index');
});
