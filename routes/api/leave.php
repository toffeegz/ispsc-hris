<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeaveController;

Route::prefix('leaves')->group(function() {
    Route::get('/', [LeaveController::class, 'index'])->name('leave.list');
    Route::get('archive', [LeaveController::class, 'archive'])->name('leave.archive');
    Route::get('/{leave}', [LeaveController::class, 'show'])->name('leave.show');
    Route::post('/', [LeaveController::class, 'store'])->name('leave.store');
    Route::put('/{leave}', [LeaveController::class, 'update'])->name('leave.update');
    Route::delete('/{leave}', [LeaveController::class, 'delete'])->name('leave.delete');
    Route::get('/restore/{leave}', [LeaveController::class, 'restore'])->name('leave.restore');
});