<?php

use Illuminate\Support\Facades\Route;

use Bedard\Backend\Http\Controllers\BackendController;
use Bedard\Backend\Http\Controllers\ResourceController;

Route::prefix(config('backend.path'))->middleware('web')->group(function () {

    Route::prefix('/api')->group(function () {
        Route::get('/resources/{route}', [ResourceController::class, 'show']);
    });

    Route::get('/{path?}', [BackendController::class, 'index'])->where('path', '.*');

});