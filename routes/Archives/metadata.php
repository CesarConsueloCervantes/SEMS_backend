<?php

use App\Http\Controllers\Archives\MetadataController;
use Illuminate\Support\Facades\Route;

Route::controller(MetadataController::class)->group(function () {
    Route::get('metadata/', 'indexByUser');
    Route::get('metadata/options', 'filtersOptions');
});