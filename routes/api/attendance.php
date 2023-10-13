<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;

Route::prefix('attendances')->group(function() {
    Route::get('/', [AttendanceController::class, 'index'])->name('attendance.list');
    Route::get('archive', [AttendanceController::class, 'archive'])->name('attendance.archive');
    Route::get('/{attendance}', [AttendanceController::class, 'show'])->name('attendance.show');
    Route::delete('/{attendance}', [AttendanceController::class, 'delete'])->name('attendance.delete');
    Route::get('/restore/{attendance}', [AttendanceController::class, 'restore'])->name('attendance.restore');
    
    Route::post('import', [AttendanceController::class, 'import'])->name('attendance.import');
});