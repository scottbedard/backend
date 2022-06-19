<?php

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/envoyer', function () {
    $message = Redis::get('envoyer_status') ?: 'unknown';

    $timeout = intval(Redis::get('envoyer_timeout')) ?: 0;

    $color = 'lightgrey';
    if ($message === 'unknown') $color = 'yellow';
    if ($message === 'deploying') $color = 'blue';
    if ($message === 'deployed') $color = 'brightgreen';
    if ($message === 'failed') $color = 'red';

    $now = Carbon::now()->getTimestamp();

    if ($timeout > 0 && $now > $timeout) {
        $color = 'red';
        $message = 'failed';
    }

    return [
        'color' => $color,
        'label' => 'Envoyer',
        'message' => $message,
        'now' => $now,
        'schemaVersion' => 1,
        'timeout' => $timeout,
    ];
});
