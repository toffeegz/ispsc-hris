<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::prefix('users')->group(function() {
    Route::get('/', [UserController::class, 'index'])->name('user.list');
    Route::get('archive', [UserController::class, 'archive'])->name('user.archive');
    Route::get('/{user}', [UserController::class, 'show'])->name('user.show');
    Route::post('/', [UserController::class, 'store'])->name('user.store');
    Route::put('/{user}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/{user}', [UserController::class, 'delete'])->name('user.delete');
    Route::get('/restore/{user}', [UserController::class, 'restore'])->name('user.restore');
});