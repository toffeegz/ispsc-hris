<?php

namespace App\Services\Dashboard;
use App\Repositories\Dashboard\DashboardRepositoryInterface;

interface DashboardServiceInterface
{
    public function departmentWiseTardiness(string $frequency, $start_date, $end_date);
}
