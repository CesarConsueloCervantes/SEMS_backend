<?php

use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::post('login', [UserController::class, 'oauthLogin'])->name('login');

Route::group([] ,function () {
    include_routes_dir(__DIR__. '/Archives');
});