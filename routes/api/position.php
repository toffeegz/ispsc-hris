<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PositionController;

Route::prefix('positions')->group(function() {
    Route::get('/', [PositionController::class, 'index'])->name('position.list');
    Route::get('archive', [PositionController::class, 'archive'])->name('position.archive');
    Route::get('/{position}', [PositionController::class, 'show'])->name('position.show');
    Route::post('/', [PositionController::class, 'store'])->name('position.store');
    Route::put('/{position}', [PositionController::class, 'update'])->name('position.update');
    Route::delete('/{position}', [PositionController::class, 'delete'])->name('position.delete');
    Route::get('/restore/{position}', [PositionController::class, 'restore'])->name('position.restore');
});