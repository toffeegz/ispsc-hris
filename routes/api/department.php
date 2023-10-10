<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartmentController;

Route::prefix('departments')->group(function() {
    Route::get('/', [DepartmentController::class, 'index'])->name('department.list');
    Route::get('archive', [DepartmentController::class, 'archive'])->name('department.archive');
    Route::get('/{department}', [DepartmentController::class, 'show'])->name('department.show');
    Route::post('/', [DepartmentController::class, 'store'])->name('department.store');
    Route::put('/{department}', [DepartmentController::class, 'update'])->name('department.update');
    Route::delete('/{department}', [DepartmentController::class, 'delete'])->name('department.delete');
    Route::get('/restore/{department}', [DepartmentController::class, 'restore'])->name('department.restore');
});