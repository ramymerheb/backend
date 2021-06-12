<?php

use Illuminate\Http\Request;
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

Route::group(['prefix' => 'v1'], function () {
    Route::group(['prefix' => 'admin'], function () {
        Route::group([
            'middleware' => 'api',
            'prefix' => 'auth'
        ], function () {
            Route::post('/login', [\App\Http\Controllers\Admin\AuthController::class, 'login']);
            Route::post('/logout', [\App\Http\Controllers\Admin\AuthController::class, 'logout']);
            Route::post('/refresh', [\App\Http\Controllers\Admin\AuthController::class, 'refresh']);
        });
        Route::group([
            'middleware' => 'api',
            'prefix' => 'client'
        ], function () {
            Route::get('/', [\App\Http\Controllers\Admin\ClientController::class, 'index']);
            Route::get('/count/{days}', [\App\Http\Controllers\Admin\ClientController::class, 'count']);
        });
    });

    Route::group(['prefix' => 'client'], function () {
        Route::post('/register', [\App\Http\Controllers\Client\ClientController::class, 'register']);
    });
});
