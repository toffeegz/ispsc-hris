<?php

namespace App\Repositories\Employee;

use App\Repositories\Base\BaseRepositoryInterface;

interface EmployeeRepositoryInterface extends BaseRepositoryInterface
{
    public function store(array $attributes);
    public function edit(array $attributes, $id);
}
