<?php

use App\Http\Controllers\paylisp\PaylispWebController;
use Illuminate\Support\Facades\Route;

Route::get('/contracheque', [PaylispWebController::class, 'contracheque']);
