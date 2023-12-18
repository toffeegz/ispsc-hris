<?php

namespace App\Repositories\LeaveBalance;

use App\Models\LeaveBalance;
use Illuminate\Support\Carbon;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Facades\Log;

class LeaveBalanceRepository extends BaseRepository implements LeaveBalanceRepositoryInterface
{

    /**
     * LeaveBalanceRepository constructor.
     *
     * @param LeaveBalance $model
     */

    public function __construct(LeaveBalance $model)
    {
        parent::__construct($model);
    }
}
