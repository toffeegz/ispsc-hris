<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmploymentStatusController;

Route::prefix('employment_statuses')->group(function() {
    Route::get('/', [EmploymentStatusController::class, 'index'])->name('employment_status.list');
    Route::get('archive', [EmploymentStatusController::class, 'archive'])->name('employment_status.archive');
    Route::get('/{employment_status}', [EmploymentStatusController::class, 'show'])->name('employment_status.show');
    Route::post('/', [EmploymentStatusController::class, 'store'])->name('employment_status.store');
    Route::put('/{employment_status}', [EmploymentStatusController::class, 'update'])->name('employment_status.update');
    Route::delete('/{employment_status}', [EmploymentStatusController::class, 'delete'])->name('employment_status.delete');
    Route::get('/restore/{employment_status}', [EmploymentStatusController::class, 'restore'])->name('employment_status.restore');
});