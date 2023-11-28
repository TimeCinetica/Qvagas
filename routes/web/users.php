<?php

use App\Http\Controllers\User\UserWebController;
use Illuminate\Support\Facades\Route;

Route::middleware(['throttle:300,1'])->group(function () {
    Route::get('signup', [UserWebController::class, 'renderSignup']);
    Route::get('new-password', [UserWebController::class, 'renderNewPasswordFromForgot']);
    Route::get('states', [UserWebController::class, 'indexStates']);
    Route::get('states/{stateId}/cities', [UserWebController::class, 'indexCitiesByState']);

    Route::middleware(['isWebUser'])->group(function () {
        Route::get('delete', [UserWebController::class, 'renderDelete']);
        Route::get('user/change-password', [UserWebController::class, 'renderChangePassword']);

        Route::put('user/change-password', [UserWebController::class, 'changePassword']);
        Route::delete('user/delete', [UserWebController::class, 'delete']);
    });
});
