<?php

use App\Http\Controllers\Asset\AssetController;
use Illuminate\Support\Facades\Route;

Route::middleware(['throttle:300,1'])->group(function () {
    Route::get('ping', function () {
        return "pong";
    });

    Route::get('asset/{resource}/{filename}', [AssetController::class, 'show']);
});
