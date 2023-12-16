<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AwardController;

Route::prefix('awards')->group(function() {
    Route::get('/overview', [AwardController::class, 'overview'])->name('award.overview');
    Route::get('/details', [AwardController::class, 'details'])->name('award.details');
    Route::get('archive', [AwardController::class, 'archive'])->name('award.archive');
    Route::get('/{award}', [AwardController::class, 'show'])->name('award.show');
    Route::post('/', [AwardController::class, 'store'])->name('award.store');
    Route::put('/{award}', [AwardController::class, 'update'])->name('award.update');
    Route::delete('/{award}', [AwardController::class, 'delete'])->name('award.delete');
    Route::get('/restore/{award}', [AwardController::class, 'restore'])->name('award.restore');
});