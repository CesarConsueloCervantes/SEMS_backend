<?php

use App\Http\Controllers\Archives\ArchivesProssesedController;
use Illuminate\Support\Facades\Route;

Route::controller(ArchivesProssesedController::class)->group(function () {
    Route::get('archive/index', 'index');
    Route::get('archive/show', 'show');
    Route::post('archive/store', 'store');
    Route::put('archive/update', 'update');
    Route::delete('archive/delete', 'delete');
    Route::post('consult_archive_info', 'consultHashAndNameExists');
});