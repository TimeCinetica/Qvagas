<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::middleware(['throttle:300,1', 'isAnyUser'])->group(function () {
    Route::get('/', [Controller::class, 'renderHome']);
    Route::get('files/{folder}/{file}', [Controller::class, 'getFile']);
});
