<?php

use Illuminate\Support\Facades\Route;

use Bedard\Backend\Http\Controllers\BackendController;

Route::prefix(config('backend.path'))->middleware('web')->group(function () {

    Route::get('/{path?}', [BackendController::class, 'index'])->where('path', '.*');

});