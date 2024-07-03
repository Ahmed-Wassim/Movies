<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\SettingController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('dashboard')->group(function () {
    Route::apiResources([
        'admins' => AdminController::class,
        'users' => UserController::class,
    ]);
    Route::post('admins/bulk-delete', [AdminController::class, 'bulkDelete']);
    Route::post('users/bulk-delete', [UserController::class, 'bulkDelete']);
    Route::get('settings', [SettingController::class, 'index']);
    Route::post('settings', [SettingController::class, 'update']);
});
