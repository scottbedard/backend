<?php

use Bedard\Backend\Http\Controllers\BackendSettingsController;
use Illuminate\Support\Facades\Route;

use Bedard\Backend\Http\Controllers\BackendController;

Route::prefix(config('backend.path'))
    ->middleware(['web', config('backend.middleware_alias')])
    ->group(function () {

        Route::get('/', [BackendController::class, 'index']);
        
        Route::post('/settings/toggle', [BackendSettingsController::class, 'toggle'])->name('backend.settings.toggle');

    });
