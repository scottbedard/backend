<?php

use Bedard\Backend\Http\Controllers\BackendController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => ['web'],
    'prefix' => config('backend.path'),
], function () {

    Route::get('/{controller?}/{route?}/{any?}', function () {
        // ...
    })->name('backend.controller.route')->where('any', '.*');

    // foreach (Backend::controllers() as $controller) {
    //     Route::group([
    //         // 'middleware' => ...
    //         'prefix' => $controller->path(),
    //     ], function () use ($controller) {
    //         foreach ($controller->get('routes') as $route) {
    //             Route::middleware([ /* ... */ ])
    //                 ->any($route->path(), [BackendController::class, 'handle'])
    //                 ->name("backend.{$controller->get('id')}.{$route->get('id')}");
    //         }
    //     });
    // }

});
