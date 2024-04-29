<?php

namespace App\Repositories\Leave;

use App\Repositories\Base\BaseRepositoryInterface;

interface LeaveRepositoryInterface extends BaseRepositoryInterface
{
    public function lists(array $search = [], array $relations = [], string $sortByColumn = 'created_at', string $sortBy = 'DESC');
    public function archives(array $search = [], array $relations = [], string $sortByColumn = 'created_at', string $sortBy = 'DESC');
    public function store(array $params);
}
