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
    Route::post('/posts/{post}/toggle_like', [\App\Http\Controllers\PostController::class, 'toggleLike']);
    Route::post('/posts/{post}/repost', [\App\Http\Controllers\PostController::class, 'repost']);
    Route::post('/posts/{post}/comment', [\App\Http\Controllers\PostController::class, 'comment']);
    Route::get('/posts/{post}/comments', [\App\Http\Controllers\PostController::class, 'comments']);
    Route::post('/post_image', [\App\Http\Controllers\PostImageController::class, 'store']);
    Route::get('/users', [\App\Http\Controllers\UserController::class, 'index']);
    Route::post('/users/stats', [\App\Http\Controllers\UserController::class, 'stats']);
    Route::get('/users/{user}/posts', [\App\Http\Controllers\UserController::class, 'posts']);
    Route::post('/users/{user}/toggle_following', [\App\Http\Controllers\UserController::class, 'toggleFollowing']);
    Route::get('/users/following_posts', [\App\Http\Controllers\UserController::class, 'followingPosts']);
});
