<?php

use App\Http\Controllers\BookingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthApiController;
use \App\Http\Controllers\FilterBookingApiController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('register',[AuthApiController::class,'register']);
    Route::post('login', [AuthApiController::class,'login']);
    Route::post('logout', [AuthApiController::class,'logout']);
    Route::post('refresh', [AuthApiController::class,'refresh']);
    Route::post('me', [AuthApiController::class,'me']);

});

Route::resource('booking', BookingController::class)->middleware('auth:api');
Route::post('filter', [FilterBookingApiController::class, 'filter'])->middleware('auth:api');
