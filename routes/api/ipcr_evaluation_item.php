<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IpcrEvaluationItemController;

Route::prefix('ipcr_evaluation_items')->group(function() {
    Route::get('/{ipcr_evaluation}', [IpcrEvaluationItemController::class, 'index'])->name('ipcr_evaluation_item.list');
});