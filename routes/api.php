<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('dashboard')->group(function () {
    Route::apiResource('/admins', AdminController::class);
    Route::apiResource('/users', UserController::class);
});
