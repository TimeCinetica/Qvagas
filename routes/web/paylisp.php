<?php

//ARQUIVO DO PAYCHECK

use App\Http\Controllers\Payslip\PaylispWebController;
use Illuminate\Support\Facades\Route;

Route::middleware(['throttle:300,1'])->group(function () {
    Route::middleware(['hasPaycheckAccess'])->group(function () {
        Route::get('{userId}/contracheque', [PaylispWebController::class, 'index']);
    });
});
