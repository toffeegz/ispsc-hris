<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

Route::prefix('employees')->group(function() {
    Route::get('/', [EmployeeController::class, 'index'])->name('employee.list');
    Route::get('archive', [EmployeeController::class, 'archive'])->name('employee.archive');
    Route::get('/{employee}', [EmployeeController::class, 'show'])->name('employee.show');
    Route::post('/', [EmployeeController::class, 'store'])->name('employee.store');
    Route::put('/{employee}', [EmployeeController::class, 'update'])->name('employee.update');
    Route::delete('/{employee}', [EmployeeController::class, 'delete'])->name('employee.delete');
    Route::get('/restore/{employee}', [EmployeeController::class, 'restore'])->name('employee.restore');
});