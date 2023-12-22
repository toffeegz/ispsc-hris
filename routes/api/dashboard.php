<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/department-wise-tardiness', [DashboardController::class, 'departmentWiseTardiness'])->name('dashboard.departmentWiseTardiness');
Route::get('/employee-tardiness', [DashboardController::class, 'employeeTardiness'])->name('dashboard.employeeTardiness');
Route::get('/top-habitual-latecomers', [DashboardController::class, 'topHabitualLateComers'])->name('dashboard.topHabitualLateComers');
Route::get('/opcr-summary', [DashboardController::class, 'opcr'])->name('dashboard.opcr');
Route::get('/ipcr-summary', [DashboardController::class, 'ipcr'])->name('dashboard.ipcr');
Route::get('/ipcr-graph', [DashboardController::class, 'ipcrGraph'])->name('dashboard.ipcrGraph');
Route::get('/dashboard/employees', [DashboardController::class, 'employees'])->name('dashboard.employees');
Route::get('/dashboard/trainings', [DashboardController::class, 'trainings'])->name('dashboard.trainings');
Route::get('/dashboard/awards', [DashboardController::class, 'awards'])->name('dashboard.awards');

?>