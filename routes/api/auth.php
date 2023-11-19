<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot_password');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('reset_password');

Route::get('login/google', [AuthController::class, 'redirectToProvider'])->name('google.login')->middleware('web');
Route::get('login/google/callback', [AuthController::class, 'handleProviderCallback'])->name('google.callback')->middleware('web');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile'])->name('user.profile');
    Route::post('/update-profile', [AuthController::class, 'updateProfile'])->name('user.update_profile');
});
