<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeaveTypeController;

Route::prefix('leave_types')->group(function() {
    Route::get('/', [LeaveTypeController::class, 'index'])->name('leave_type.list');
    Route::get('archive', [LeaveTypeController::class, 'archive'])->name('leave_type.archive');
    Route::get('/{leave_type}', [LeaveTypeController::class, 'show'])->name('leave_type.show');
    Route::post('/', [LeaveTypeController::class, 'store'])->name('leave_type.store');
    Route::put('/{leave_type}', [LeaveTypeController::class, 'update'])->name('leave_type.update');
    Route::delete('/{leave_type}', [LeaveTypeController::class, 'delete'])->name('leave_type.delete');
    Route::get('/restore/{leave_type}', [LeaveTypeController::class, 'restore'])->name('leave_type.restore');
});