<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrainingController;

Route::prefix('trainings')->group(function() {
    Route::get('/', [TrainingController::class, 'index'])->name('training.list');
    Route::get('archive', [TrainingController::class, 'archive'])->name('training.archive');
    Route::get('/{training}', [TrainingController::class, 'show'])->name('training.show');
    Route::post('/', [TrainingController::class, 'store'])->name('training.store');
    Route::put('/{training}', [TrainingController::class, 'update'])->name('training.update');
    Route::delete('/{training}', [TrainingController::class, 'delete'])->name('training.delete');
    Route::get('/restore/{training}', [TrainingController::class, 'restore'])->name('training.restore');
});