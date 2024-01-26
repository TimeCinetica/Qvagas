<?php

use App\Http\Controllers\Payslip\PaylispWebController;
use Illuminate\Support\Facades\Route;


    Route::get('contracheque', [PaylispWebController::class, 'index']);

