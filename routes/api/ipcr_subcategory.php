<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IpcrSubcategoryController;

Route::prefix('ipcr_subcategories')->group(function() {
    Route::get('/', [IpcrSubcategoryController::class, 'index'])->name('ipcr_subcategory.list');
    Route::get('archive', [IpcrSubcategoryController::class, 'archive'])->name('ipcr_subcategory.archive');
    Route::get('/{ipcr_subcategory}', [IpcrSubcategoryController::class, 'show'])->name('ipcr_subcategory.show');
    Route::post('/', [IpcrSubcategoryController::class, 'store'])->name('ipcr_subcategory.store');
    Route::put('/{ipcr_subcategory}', [IpcrSubcategoryController::class, 'update'])->name('ipcr_subcategory.update');
    Route::delete('/{ipcr_subcategory}', [IpcrSubcategoryController::class, 'delete'])->name('ipcr_subcategory.delete');
    Route::get('/restore/{ipcr_subcategory}', [IpcrSubcategoryController::class, 'restore'])->name('ipcr_subcategory.restore');
});