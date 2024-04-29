<?php

namespace App\Repositories\Attendance;

use App\Repositories\Base\BaseRepositoryInterface;

interface AttendanceRepositoryInterface extends BaseRepositoryInterface
{
    public function lists(array $search = [], array $relations = [], string $sortByColumn = 'created_at', string $sortBy = 'DESC');
    public function archives(array $search = [], array $relations = [], string $sortByColumn = 'created_at', string $sortBy = 'DESC');
}
