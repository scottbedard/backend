<?php

use Bedard\Backend\Http\Controllers\BackendController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => ['web'],
    'prefix' => config('backend.path'),
], function () {
    Route::get('/{controller?}/{route?}/{params?}', [BackendController::class, 'route'])
        ->name('backend.controller.route')
        ->where('params', '.*');
});
