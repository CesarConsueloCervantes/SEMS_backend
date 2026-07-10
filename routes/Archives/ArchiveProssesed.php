<?php

use App\Http\Controllers\Archives\ArchivesProssesedController;
use Illuminate\Support\Facades\Route;

Route::controller(ArchivesProssesedController::class)->group(function () {
    Route::post('consult_archive_info', 'consultHashAndNameExists');
});