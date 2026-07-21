<?php

use App\Http\Controllers\Archives\ArchivesProssesedController;
use Illuminate\Support\Facades\Route;

Route::controller(ArchivesProssesedController::class)->group(function () {
    Route::get('user/archives-prossesed/{user}', 'indexByUser');
    Route::get('archives-prossesed/{archives_prossesed}', 'show');
    Route::post('archives-prossesed', 'store');
    Route::put('archives-prossesed/{archives_prossesed}', 'update');
    Route::delete('archives-prossesed/{archives_prossesed}', 'delete');
    Route::post('consult_archive_info', 'consultHashAndNameExists');
});