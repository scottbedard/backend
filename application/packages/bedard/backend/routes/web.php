<?php

use Bedard\Backend\Http\Controllers\AdminsController;
use Bedard\Backend\Http\Controllers\DebugController;
use Bedard\Backend\Http\Controllers\IndexController;
use Bedard\Backend\Http\Controllers\ResourcesController;
use Illuminate\Support\Facades\Route;

Route::prefix(config('backend.path'))
    ->middleware(['web', config('backend.middleware_alias')])
    ->group(function () {

        //
        // admin
        //
        Route::get('/', [IndexController::class, 'index'])->name('backend.index');

        Route::get('/debug', [DebugController::class, 'index']);

        Route::get('/resources/{id}', [ResourcesController::class, 'show'])->name('backend.resources.show');

        Route::get('/resource/{id}/edit/{modelId}', [ResourcesController::class, 'edit'])->name('backend.resources.edit');

        Route::get('/resources/{id}/create', [ResourcesController::class, 'create'])->name('backend.resources.create');

        Route::post('/resources/{id}/action', [ResourcesController::class, 'action'])->name('backend.resources.action');
    
        //
        // super admin only
        //
        Route::prefix('admin')->middleware(['can:super admin'])->group(function () {

            Route::get('/', [AdminsController::class, 'index'])->name('backend.admins.index');

        });
    });
