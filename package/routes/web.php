<?php

use Bedard\Backend\BackendController;
use Bedard\Backend\Http\Controllers\ClientController;
use Bedard\Backend\Facades\Backend;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Middlewares\PermissionMiddleware;

Route::group([
    'middleware' => ['web', \Bedard\Backend\Http\Middleware\Backend::class],
    'prefix' => config('backend.path'),
], function () {

    foreach (Backend::controllers() as $controller => $config) {
        Route::group([
            'prefix' => $config['id'],
        ], function () use ($controller, $config) {
            foreach ($config['routes'] as $method => $route) {

                Route::get($route['path'], [$config['class'], $method])
                    ->name("backend.{$controller}.{$method}");

            }
        });
    }

    Route::get('/', [ClientController::class, 'index'])->name('backend.index');

});
