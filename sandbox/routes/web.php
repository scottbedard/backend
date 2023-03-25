<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $user = auth()->user();

    if (!$user) {
        return redirect()->route('login');
    }

    return view('index', [
        'user' => $user,
    ]);
})->name('index');

Route::get('/login', function () {
    $user = auth()->user();

    if ($user) {
        return redirect()->route('index');
    }

    return view('login', [
        'user' => $user,
    ]);
})->name('login');

require __DIR__ . '/auth.php';
