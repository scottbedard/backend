<?php

use Bedard\Backend\BackendController;
use Bedard\Backend\Facades\Backend;
use Bedard\Backend\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Middlewares\PermissionMiddleware;
use Spatie\Permission\Middlewares\RoleMiddleware;

Route::group([
    'middleware' => ['web'],
    'prefix' => config('backend.path'),
], function () {
    $config = Backend::config();
    
    foreach ($config['controllers'] as $controller) {
        Route::group([
            'middleware' => array_map(fn ($p) => "Spatie\Permission\Middlewares\PermissionMiddleware:{$p}", $controller['permissions']),
            'prefix' => $controller['id'],
        ], function () use ($controller) {
            $ctrl = $controller['id'];

            foreach ($controller['routes'] as $id => $route) {
                Route::middleware(array_map(fn ($p) => "Spatie\Permission\Middlewares\PermissionMiddleware:{$p}", $route['permissions']))
                    ->get($route['path'], [BackendController::class, $id])
                    ->name("backend.{$ctrl}.{$id}");
            }
        });
    }

    Route::get('/', [BackendController::class, 'index'])->name('backend.index');
});
