<?php

use Bedard\Backend\BackendController;
use Bedard\Backend\Facades\Backend;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => ['web'],
    'prefix' => config('backend.path'),
], function () {
    $config = Backend::config();
    
    foreach ($config['controllers'] as $controller) {
        Route::group([
            'middleware' => array_map(fn ($p) => "Spatie\Permission\Middlewares\PermissionMiddleware:{$p}", $controller['permissions']),
            'prefix' => $controller['id'] !== '_root' ? $controller['id'] : null,
        ], function () use ($controller) {
            $ctrl = $controller['id'];

            foreach ($controller['routes'] as $id => $route) {
                Route::middleware(array_map(fn ($p) => "Spatie\Permission\Middlewares\PermissionMiddleware:{$p}", $route['permissions']))
                    ->get($route['path'], [BackendController::class, $id])
                    ->name("backend.{$ctrl}.{$id}");
            }
        });
    }

});
