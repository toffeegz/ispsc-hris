<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/department-wise-tardiness', [DashboardController::class, 'departmentWiseTardiness'])->name('dashboard.departmentWiseTardiness');
Route::get('/employee-tardiness', [DashboardController::class, 'employeeTardiness'])->name('dashboard.employeeTardiness');
Route::get('/top-habitual-latecomers', [DashboardController::class, 'topHabitualLateComers'])->name('dashboard.topHabitualLateComers');

?>