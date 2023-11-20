<?php

namespace App\Services\Dashboard;
use App\Repositories\Dashboard\DashboardRepositoryInterface;

interface DashboardServiceInterface
{
    public function departmentWiseTardiness(string $frequency, $start_date, $end_date);
    public function employeeTardiness($department_ids = [], $month = null, $year = null);
    public function topHabitualLateComers(string $frequency, $start_date, $end_date);
    public function opcr($ipcr_period_id);
    public function ipcr($ipcr_period_id, $department_id);
    public function ipcrGraph($ipcr_period_id);
}
