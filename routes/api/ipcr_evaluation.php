<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IpcrEvaluationController;

Route::prefix('ipcr_evaluations')->group(function() {
    Route::get('/', [IpcrEvaluationController::class, 'index'])->name('ipcr_evaluation.list');
    Route::get('archive', [IpcrEvaluationController::class, 'archive'])->name('ipcr_evaluation.archive');
    Route::get('/{ipcr_evaluation}', [IpcrEvaluationController::class, 'show'])->name('ipcr_evaluation.show');
    Route::post('/', [IpcrEvaluationController::class, 'store'])->name('ipcr_evaluation.store');
    Route::put('/{ipcr_evaluation}', [IpcrEvaluationController::class, 'update'])->name('ipcr_evaluation.update');
    Route::delete('/{ipcr_evaluation}', [IpcrEvaluationController::class, 'delete'])->name('ipcr_evaluation.delete');
    Route::get('/restore/{ipcr_evaluation}', [IpcrEvaluationController::class, 'restore'])->name('ipcr_evaluation.restore');
});