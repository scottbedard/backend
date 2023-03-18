<?php

use Bedard\Backend\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;

Route::prefix(config('backend.path'))->group(function () {

    Route::get('/{path?}', [ClientController::class, 'index'])->where('path', '.*');

});
