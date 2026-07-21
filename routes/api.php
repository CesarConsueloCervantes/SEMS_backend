<?php

use App\Http\Controllers\System\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'oauthLogin'])->name('login');
Route::post('register', [AuthController::class, 'register'])->name('register');

Route::middleware('auth:api')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    include_routes_dir(__DIR__. '/Archives');
});