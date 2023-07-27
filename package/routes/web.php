<?php

use Bedard\Backend\Http\Controllers\BackendController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => ['web', \Spatie\Permission\Middlewares\PermissionMiddleware::class . ':admin'],
    'prefix' => config('backend.path'),
], function () {

    Route::any('/{controllerOrRoute?}/{route?}/{extra?}', [BackendController::class, 'route'])
        ->name('backend.controller.route')
        ->where('extra', '.*');

});
