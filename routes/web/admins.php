<?php

use App\Http\Controllers\Admin\AdminWebController;
use App\Http\Controllers\Occupation\OccupationsWebController;
use App\Http\Controllers\Resume\ResumeWebController;
use App\Http\Controllers\User\UserWebController;
use Illuminate\Support\Facades\Route;

Route::middleware(['throttle:300,1'])->group(function () {
    Route::middleware(['isWebAdmin:false'])->group(function () {
        Route::get('admin/change-password', [UserWebController::class, 'renderChangePassword']);
        Route::put('admin/change-password', [UserWebController::class, 'changePassword']);

        Route::get('admin/set-password', [AdminWebController::class, 'renderSetPassword']);
        Route::put('admin/set-password', [AdminWebController::class, 'setPassword']);
    });

    Route::middleware(['isWebAdmin'])->group(function () {
        Route::get('occupations', [OccupationsWebController::class, 'renderOccupations']);
        Route::post('occupations', [OccupationsWebController::class, 'store']);
        Route::put('occupations/{id}', [OccupationsWebController::class, 'edit']);
        Route::delete('occupations/{id}', [OccupationsWebController::class, 'delete']);

        Route::get('resumes', [ResumeWebController::class, 'renderResumes']);
        Route::delete('resumes/{id}', [ResumeWebController::class, 'delete']);

        Route::get('infos', [AdminWebController::class, 'renderInfos']);
    });

    Route::middleware(['isWebSadmin:,/'])->group(function () {
        Route::get('admins', [AdminWebController::class, 'renderList']);
        Route::get('admin/new', [AdminWebController::class, 'renderNewAdmin']);
        Route::delete('admins/{id}', [AdminWebController::class, 'delete']);
        Route::post('admin/new', [AdminWebController::class, 'newAdmin']);
    });
});
