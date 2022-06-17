<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
    return view('login');
})->name('index');

Route::get('/debug', function () {
    return 'debug';
})->name('debug');

Route::any('/logout', function (Request $request) {
    Auth::logout();

    return redirect('/');
})->name('logout');

Route::post('/auth', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (!Auth::attempt($credentials)) {
        return redirect()->back()->with('error', 'Invalid credentials, please try again.');
    }

    $request->session()->regenerate();

    return redirect()->route('backend.index');
})->name('auth');
