<?php

use Bedard\Backend\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => config('backend.path'),
], function () {

    Route::get('/{path?}', [ClientController::class, 'index'])
        ->where('path', '.*')
        ->name('backend.index');

});
