<?php

use App\Http\Controllers\Payslip\PaylispWebController;
use Illuminate\Support\Facades\Route;

Route::middleware(['throttle:300,1'])->group(function () {
    Route::middleware(['hasPaycheckAccess'])->group(function () {
        Route::get('/contracheque', [PaylispWebController::class, 'renderPaycheck']);
        Route::get('/contracheque/new', [PaylispWebController::class, 'renderNewPaycheck']);
    });
});
