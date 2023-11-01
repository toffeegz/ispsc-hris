<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OptionController;

Route::prefix('options')->group(function() {
    Route::get('departments', [OptionController::class, 'departments'])->name('option.department');
    Route::get('positions', [OptionController::class, 'positions'])->name('option.position');
    Route::get('employment_statuses', [OptionController::class, 'employment_statuses'])->name('option.employment_status');
    Route::get('leave_types', [OptionController::class, 'leave_types'])->name('option.leave_type');
    Route::get('ipcr_periods', [OptionController::class, 'ipcr_periods'])->name('option.ipcr_period');
});