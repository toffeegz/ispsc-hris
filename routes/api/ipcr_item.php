<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IpcrItemController;

Route::prefix('ipcr_items')->group(function() {
    Route::get('/', [IpcrItemController::class, 'index'])->name('ipcr_item.list');
    Route::get('archive', [IpcrItemController::class, 'archive'])->name('ipcr_item.archive');
    Route::get('/{ipcr_item}', [IpcrItemController::class, 'show'])->name('ipcr_item.show');
    Route::post('/', [IpcrItemController::class, 'store'])->name('ipcr_item.store');
    Route::put('/{ipcr_item}', [IpcrItemController::class, 'update'])->name('ipcr_item.update');
    Route::delete('/{ipcr_item}', [IpcrItemController::class, 'delete'])->name('ipcr_item.delete');
    Route::get('/restore/{ipcr_item}', [IpcrItemController::class, 'restore'])->name('ipcr_item.restore');
});