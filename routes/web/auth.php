<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use Illuminate\Support\Facades\Route;

Route::middleware(['throttle:300,1'])->group(function () {
    Route::get('login', [LoginController::class, 'renderLogin']);
    Route::post('login', [LoginController::class, 'authenticate']);
    Route::post('logout', [LoginController::class, 'logout']);

    Route::get('forgot-password', [ForgotPasswordController::class, 'renderForgotPassword']);
    Route::post('forgot-password', [ForgotPasswordController::class, 'forgotPassword']);
});
