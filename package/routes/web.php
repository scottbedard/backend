<?php

use Bedard\Backend\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;

Route::prefix(config('backend.path'))->group(function () {

    Route::get('/', function () {
        return 'hello';
    });

});
