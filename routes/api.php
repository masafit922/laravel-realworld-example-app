<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\FeedController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| These routes are loaded with the "api" prefix and middleware group
| (see bootstrap/app.php).
|
*/

Route::post('users/login', [AuthController::class, 'login']);
Route::post('users', [AuthController::class, 'register']);

Route::get('user', [UserController::class, 'index']);
Route::match(['put', 'patch'], 'user', [UserController::class, 'update']);

Route::get('profiles/{user}', [ProfileController::class, 'show']);
Route::post('profiles/{user}/follow', [ProfileController::class, 'follow']);
Route::delete('profiles/{user}/follow', [ProfileController::class, 'unFollow']);

Route::get('articles/feed', [FeedController::class, 'index']);
Route::post('articles/{article}/favorite', [FavoriteController::class, 'add']);
Route::delete('articles/{article}/favorite', [FavoriteController::class, 'remove']);

Route::resource('articles', ArticleController::class, [
    'except' => [
        'create', 'edit'
    ]
]);

Route::resource('articles/{article}/comments', CommentController::class, [
    'only' => [
        'index', 'store', 'destroy'
    ]
]);

Route::get('tags', [TagController::class, 'index']);
