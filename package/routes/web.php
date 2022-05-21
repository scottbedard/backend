<?php

use Illuminate\Support\Facades\Route;

use Bedard\Backend\Http\Controllers\BackendController;

Route::prefix(config('backend.path'))
    ->middleware(['web', config('backend.middleware_alias')])
    ->group(function () {

        Route::get('/{path?}', [BackendController::class, 'index'])->where('path', '.*');
        
    });
