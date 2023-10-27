<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/getauth', \App\Http\Controllers\GetController::class);
    Route::post('/post', [\App\Http\Controllers\PostController::class, 'store']);
    Route::get('/posts', [\App\Http\Controllers\PostController::class, 'index']);
    Route::post('/post_image', [\App\Http\Controllers\PostImageController::class, 'store']);
    Route::get('/users', [\App\Http\Controllers\UserController::class, 'index']);
});
