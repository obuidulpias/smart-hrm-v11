<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::post('signup', [AuthController::class, 'signup']);
Route::post('login', [AuthController::class, 'login']);

Route::controller(AuthController::class)->group(function () {
    //Route::get('user', 'userDetails');
    Route::get('logout', 'logout');
})->middleware('auth:api');

Route::group(['middleware' => 'api'], function () {
    Route::get('user', action: [AuthController::class, 'userDetails']);
    Route::get('/test-user', [UserController::class, 'info']);
});
