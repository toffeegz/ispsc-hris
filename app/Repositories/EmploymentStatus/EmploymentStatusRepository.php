<?php

namespace App\Repositories\EmploymentStatus;

use App\Models\EmploymentStatus;
use Illuminate\Support\Carbon;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Facades\Log;

class EmploymentStatusRepository extends BaseRepository implements EmploymentStatusRepositoryInterface
{

    /**
     * EmploymentStatusRepository constructor.
     *
     * @param EmploymentStatus $model
     */

    public function __construct(EmploymentStatus $model)
    {
        parent::__construct($model);
    }
}
