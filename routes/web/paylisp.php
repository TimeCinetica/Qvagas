<?php

use App\Http\Controllers\Payslip\PaylispWebController;
use Illuminate\Support\Facades\Route;

Route::middleware(['throttle:300,1'])->group(function () {
    Route::middleware(['isAnyUser'])->group(function(){
        Route::get('/contracheques',[PaylispWebController::class,'CrenderPaychecks'])->name('paycheck.collaborator');
    });
    Route::middleware(['hasPaycheckAccess'])->group(function () {
        Route::get('/contracheque', [PaylispWebController::class, 'renderPaycheck']);
        Route::get('/contracheque/new', [PaylispWebController::class, 'renderNewPaycheck']);
        Route::post('/contracheque/new', [PaylispWebController::class, 'newCollaborator']);
        Route::post('/contracheque/store', [PaylispWebController::class, 'store']);
        Route::get('/storage/{filename}', [PaylispWebController::class, 'serve']);
        Route::get('/contracheque/colaborador/{id}', [PaylispWebController::class, 'renderPaycheckCollaborator'])->name('paycheck.collaborator');
        Route::post('/contracheque/colaborador/{id}/delete', [PaylispWebController::class, 'deletePaycheck']);
        Route::post('/contracheque/update', [PaylispWebController::class, 'update'])->name('paycheck.update');
        Route::post('/contracheque/delete', [PaylispWebController::class, 'delete'])->name('paycheck.delete');
    });
});
