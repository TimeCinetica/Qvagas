<?php

use App\Http\Controllers\Occupation\OccupationsApiController;
use Illuminate\Support\Facades\Route;

Route::middleware(['throttle:300,1'])->group(function () {
    Route::get('occupations', [OccupationsApiController::class, 'indexOccupations']);

    Route::middleware(['isWebAdmin'])->group(function () {
        Route::get('occupations/paged', [OccupationsApiController::class, 'indexFilteredOccupations']);
    });
});
