<?php

namespace App\Repositories\Attendance;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

use App\Repositories\Base\BaseRepository;
use App\Models\Attendance;

class AttendanceRepository extends BaseRepository implements AttendanceRepositoryInterface
{

    /**
     * AttendanceRepository constructor.
     *
     * @param Attendance $model
     */

    public function __construct(Attendance $model)
    {
        parent::__construct($model);
    }

    // LISTING
    public function lists(array $search = [], array $relations = [], string $sortByColumn = 'created_at', string $sortBy = 'DESC')
    {
        $user = Auth::user();
        if($user->is_admin === false) {
            $this->model = $this->model->where('employee_id', $user->employee->id);
        }
        if($relations) {
            $this->model = $this->model->with($relations);
        }

        return $this->model->filter($search)->orderBy($sortByColumn, $sortBy)->paginate(request('limit') ?? 10);
    }

    // ARCHIVES
    public function archives(array $search = [], array $relations = [], string $sortByColumn = 'created_at', string $sortBy = 'DESC')
    {
        $user = Auth::user();
        if($user->is_admin === false) {
            $this->model = $this->model->where('employee_id', $user->employee->id);
        }
        
        $this->model = $this->model->onlyTrashed();
        if($relations) {
            $this->model = $this->model->with($relations);
        }

        return $this->model->filter($search)->orderBy($sortByColumn, $sortBy)->paginate(request('limit') ?? 10);
    }

}
