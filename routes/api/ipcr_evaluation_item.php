<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IpcrEvaluationItemController;

Route::prefix('ipcr_evaluation_items')->group(function() {
    Route::get('/', [IpcrEvaluationItemController::class, 'index'])->name('ipcr_evaluation_item.list');
    Route::get('archive', [IpcrEvaluationItemController::class, 'archive'])->name('ipcr_evaluation_item.archive');
    Route::get('/{ipcr_evaluation_item}', [IpcrEvaluationItemController::class, 'show'])->name('ipcr_evaluation_item.show');
    Route::post('/', [IpcrEvaluationItemController::class, 'store'])->name('ipcr_evaluation_item.store');
    Route::put('/{ipcr_evaluation_item}', [IpcrEvaluationItemController::class, 'update'])->name('ipcr_evaluation_item.update');
    Route::delete('/{ipcr_evaluation_item}', [IpcrEvaluationItemController::class, 'delete'])->name('ipcr_evaluation_item.delete');
    Route::get('/restore/{ipcr_evaluation_item}', [IpcrEvaluationItemController::class, 'restore'])->name('ipcr_evaluation_item.restore');
});