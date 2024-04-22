<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeaveBalanceController;

Route::prefix('leave_balances')->group(function() {
    Route::get('/', [LeaveBalanceController::class, 'index'])->name('leave_balance.list');
    Route::get('archive', [LeaveBalanceController::class, 'archive'])->name('leave_balance.archive');
    Route::get('/{leave_balance}', [LeaveBalanceController::class, 'show'])->name('leave_balance.show');
    Route::post('/', [LeaveBalanceController::class, 'store'])->name('leave_balance.store');
    Route::put('/{leave_balance}', [LeaveBalanceController::class, 'update'])->name('leave_balance.update');
    Route::delete('/{leave_balance}', [LeaveBalanceController::class, 'delete'])->name('leave_balance.delete');
    Route::get('/restore/{leave_balance}', [LeaveBalanceController::class, 'restore'])->name('leave_balance.restore');
});