<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\UserController;


/**
 * API Route Define Start From Here
 */
Route::post('signup', [AuthController::class, 'signup']);
Route::post('login', [AuthController::class, 'login']);
/**
 * Use custom middleware for user Authentication 
 * \App\Http\Middleware\AuthUserMiddleware::class
 */
Route::group(['middleware' => 'auth-user'], function () {
    Route::get('logout', action: [AuthController::class, 'logout']);
    Route::get('user', action: [AuthController::class, 'userDetails']);

    /**
     *...* User Route Start From Here *...*
     * \App\Http\Controllers\User\UserController
     */
    Route::get('userAll', action: [UserController::class, 'userAll']);
});








/*
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(AuthController::class)->group(function () {
    //Route::get('user', 'userDetails');
    Route::get('logout', 'logout');
})->middleware('auth:api'); 
*/


