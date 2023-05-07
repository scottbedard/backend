<?php

use Bedard\Backend\Http\Controllers\BackendController;
use Bedard\Backend\Facades\Backend;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => ['web'],
    'prefix' => config('backend.path'),
], function () {
    foreach (Backend::controllers() as $controller) {
        Route::group([
            // 'middleware' => ...
            'prefix' => $controller->path(),
        ], function () use ($controller) {
            foreach ($controller->get('routes') as $route) {
                Route::middleware([ /* ... */ ])
                    ->any($route->path(), [BackendController::class, 'handle'])
                    ->name("backend.{$controller->get('id')}.{$route->get('id')}");
            }
        });
    }

    // foreach ($config['controllers'] as $controller) {
    //     Route::group([
    //         'middleware' => array_map(fn ($p) => "Spatie\Permission\Middlewares\PermissionMiddleware:{$p}", $controller['permissions']),
    //         'prefix' => $controller['path'],
    //     ], function () use ($controller) {
    //         $ctrl = $controller['id'];

    //         foreach ($controller['routes'] as $id => $route) {
    //             Route::middleware(array_map(fn ($p) => "Spatie\Permission\Middlewares\PermissionMiddleware:{$p}", $route['permissions']))
    //                 ->get($route['path'], [BackendController::class, $id])
    //                 ->name("backend.{$ctrl}.{$id}");
    //         }
    //     });
    // }

});
