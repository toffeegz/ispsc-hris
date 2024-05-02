<?php

namespace App\Repositories\LeaveBalance;

use App\Repositories\Base\BaseRepositoryInterface;

interface LeaveBalanceRepositoryInterface extends BaseRepositoryInterface
{
    public function employeeBalance();
}
