<?php

namespace App\Repositories\Opcr;

use App\Repositories\Base\BaseRepositoryInterface;

interface OpcrRepositoryInterface extends BaseRepositoryInterface
{
    public function index(array $search = [], $ipcr_period_id = null, array $relations = [], string $sortByColumn = 'created_at', string $sortBy = 'DESC');
}
