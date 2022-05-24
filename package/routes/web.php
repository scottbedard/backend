<?php

use Bedard\Backend\Http\Controllers\IndexController;
use Bedard\Backend\Http\Controllers\ResourcesController;
use Bedard\Backend\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

Route::prefix(config('backend.path'))
    ->middleware(['web', config('backend.middleware_alias')])
    ->group(function () {

        Route::get('/', [IndexController::class, 'index'])->name('backend.index');

        Route::get('/resources/{resource}', [ResourcesController::class, 'show'])->name('backend.resources.show');
        
        Route::post('/settings/toggle', [SettingsController::class, 'toggle'])->name('backend.settings.toggle');

    });
