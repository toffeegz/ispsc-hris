<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiImportController;

Route::prefix('import')->group(function() {
    Route::post('/employees', [ApiImportController::class, 'importEmployee'])->name('import.employees');
    Route::post('/trainings', [ApiImportController::class, 'importTraining'])->name('import.trainings');
    Route::post('/awards', [ApiImportController::class, 'importAward'])->name('import.awards');
    Route::post('/leaves', [ApiImportController::class, 'importLeave'])->name('import.leaves');
});