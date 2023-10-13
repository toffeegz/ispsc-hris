<?php

namespace App\Repositories\Department;

use App\Models\Department;
use Illuminate\Support\Carbon;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Facades\Log;

class DepartmentRepository extends BaseRepository implements DepartmentRepositoryInterface
{

    /**
     * DepartmentRepository constructor.
     *
     * @param Department $model
     */

    public function __construct(Department $model)
    {
        parent::__construct($model);
    }
}
