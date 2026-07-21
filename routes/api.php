<?php

use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::post('login', [UserController::class, 'oauthLogin'])->name('login');
Route::post('register', [UserController::class, 'register'])->name('register');

Route::middleware('auth:api')->group(function () {
    Route::post('logout', [UserController::class, 'logout'])->name('logout');
    include_routes_dir(__DIR__. '/Archives');
});