<?php

use App\Http\Controllers\Resume\ResumeWebController;
use App\Http\Controllers\User\UserWebController;
use Illuminate\Support\Facades\Route;

Route::middleware(['throttle:300,1'])->group(function () {
    Route::middleware(['hasResumeAccess'])->group(function () {
        Route::get('{userId}/resume', [ResumeWebController::class, 'renderResume']);
        Route::get('{userId}/resume/pdf', [ResumeWebController::class, 'downloadPdf']);
    });

    Route::middleware(['checkAdmin'])->group(function () {
        Route::get('occupations', [ResumeWebController::class, 'renderOccupations']);
        Route::get('resumes/status', [ResumeWebController::class, 'resumeByStatus']);
        Route::get('resumes/export-csv', [ResumeWebController::class, 'exportCsv']);

        Route::get('resumes/infos', [ResumeWebController::class, 'resumeInfos']);
        Route::get('users/infos', [UserWebController::class, 'userInfos']);
    });
});
