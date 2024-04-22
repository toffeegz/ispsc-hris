<?php

namespace App\Repositories\Leave;

use App\Repositories\Base\BaseRepositoryInterface;

interface LeaveRepositoryInterface extends BaseRepositoryInterface
{
    public function store(array $params);
}
