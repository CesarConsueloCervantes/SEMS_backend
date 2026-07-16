<?php

use Illuminate\Support\Facades\Route;

Route::group([] ,function () {
    include_routes_dir(__DIR__. '/Archives');
});