<?php

namespace App\Repositories\LeaveBalance;

use App\Models\LeaveBalance;
use Illuminate\Support\Carbon;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

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

    public function employeeBalance()
    {
        $data = [
            'remaining_vl' => 'N/A',
            'remaining_sl' => 'N/A',
        ];
        $user = Auth::user();
        if($user->is_admin === false) {
            $this->model = $this->model->where('employee_id', $user->employee->id);
        }
        
        $result = $this->model->where('year', Carbon::now()->year)->first();
        if($result) {
            $data['remaining_vl'] = $result->remaining_vl;
            $data['remaining_sl'] = $result->remaining_sl;
        }

        return $data; 
    }
}
