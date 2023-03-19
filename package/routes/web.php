<?php

use Bedard\Backend\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => ['web', \Bedard\Backend\Http\Middleware\Backend::class],
    'prefix' => config('backend.path'),
], function () {

    Route::get('/{path?}', [ClientController::class, 'index'])
        ->where('path', '.*')
        ->name('backend.index');

});
