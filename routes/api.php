<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ActorController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\Admin\MovieController;
use App\Http\Controllers\Admin\ProfileController;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api')->name('refresh');
    Route::get('/me', [AuthController::class, 'me'])->middleware('auth:api')->name('me');
});


Route::middleware(['auth:api', 'role:admin|super_admin'])->prefix('dashboard')->group(function () {
    //users
    Route::apiResource('users', UserController::class);
    Route::post('users/bulk-delete', [UserController::class, 'bulkDelete']);

    //admins
    Route::apiResource('admins', AdminController::class);
    Route::post('admins/bulk-delete', [AdminController::class, 'bulkDelete']);

    //settings
    Route::get('/settings', [SettingController::class, 'index']);
    Route::post('/settings', [SettingController::class, 'update']);

    //profile
    Route::post('/profile', [ProfileController::class, 'update']);
    Route::post('/profile/change-password', [ProfileController::class, 'changePassword']);

    // genres
    Route::get('/genres', [GenreController::class, 'index']);
    Route::delete('/genres/{genre}', [GenreController::class, 'destroy']);
    Route::post('/genres/bulk-delete', [GenreController::class, 'bulkDelete']);

    // actors
    Route::get('/actors', [ActorController::class, 'index']);
    Route::delete('/actors/{actor}', [ActorController::class, 'destroy']);
    Route::post('/actors/bulk-delete', [ActorController::class, 'bulkDelete']);

    // movies
    Route::get('/movies', [MovieController::class, 'index']);
    Route::get('/movies/{movie}', [MovieController::class, 'show']);
    Route::delete('/movies/{movie}', [MovieController::class, 'destroy']);
    Route::post('/movies/bulk-delete', [MovieController::class, 'bulkDelete']);

    // home page
    Route::get('/genre_count', [HomeController::class, 'genreCount']);
    Route::get('/movie_count', [HomeController::class, 'movieCount']);
    Route::get('/actor_count', [HomeController::class, 'actorCount']);
    Route::get('/chart', [HomeController::class, 'chart']);
});