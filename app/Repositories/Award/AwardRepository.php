<?php

namespace App\Repositories\Award;

use App\Models\Award;
use Illuminate\Support\Carbon;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Facades\Log;

class AwardRepository extends BaseRepository implements AwardRepositoryInterface
{

    /**
     * AwardRepository constructor.
     *
     * @param Award $model
     */

    public function __construct(Award $model)
    {
        parent::__construct($model);
    }

    public function overview(array $search = [])
    {
        $page = request()->input('page', 1);
        $limit = request()->input('limit', 10);
    
        $query = $this->model->filter($search)->with('employee', 'employee.department');
    
        $awards = $query->get();
    
        $totalItems = $awards->count();
        $startIndex = ($page - 1) * $limit;
        $paginatedAwards = $awards->slice($startIndex, $limit);
    
        // Construct the formatted output based on all awards
        $formattedAwards = collect([]);
            
        $groupedAwards = $awards->groupBy('employee_id')->map(function ($employeeAwards) {
            return $employeeAwards->groupBy('award_name');
        });

        $groupedAwards->each(function ($employeeAwards) use ($formattedAwards) {
            $employeeAwards->each(function ($awards, $awardName) use ($formattedAwards) {
                $employee = $awards->first()->employee;
                $frequency = $awards->count();
                $datesAwarded = $awards->pluck('date_awarded')->toArray();

                $formattedAwards->push([
                    'employee' => $employee,
                    'department_name' => $employee->department->acronym,
                    'award_name' => $awardName,
                    'frequency' => $frequency,
                    'date_awarded' => $datesAwarded,
                ]);
            });
        });

        // Slice the formatted awards based on the requested limit
        $paginatedFormattedAwards = $formattedAwards->slice($startIndex, $limit);

        return [
            'data' => $paginatedFormattedAwards,
            'current_page' => $page,
            'per_page' => $limit,
            'total' => $totalItems,
            'last_page' => ceil($totalItems / $limit),
        ];
    }

}
