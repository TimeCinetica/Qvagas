<?php

use App\Http\Controllers\User\UserApiController;
use Illuminate\Support\Facades\Route;


Route::middleware(['throttle:300,1'])->group(function () {
    Route::post('signup', [UserApiController::class, 'store']);
    Route::put('edit', [UserApiController::class, 'update']);
    Route::post('user/photos', [UserApiController::class, 'updatePhotos']);

    Route::post('new-password', [UserApiController::class, 'newPasswordFromForgot']);
});
