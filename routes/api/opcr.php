<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OpcrController;

Route::prefix('opcr')->group(function() {
    Route::get('/', [OpcrController::class, 'index'])->name('opcr.list');
});