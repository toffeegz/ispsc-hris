<?php

namespace App\Repositories\Leave;

use App\Models\Leave;
use Illuminate\Support\Carbon;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Facades\Log;

class LeaveRepository extends BaseRepository implements LeaveRepositoryInterface
{

    /**
     * LeaveRepository constructor.
     *
     * @param Leave $model
     */

    public function __construct(Leave $model)
    {
        parent::__construct($model);
    }

    public function store(array $params)
    {
        $startDate = Carbon::parse($params['date_start'] . ' ' . $params['time_start']);
        $endDate = Carbon::parse($params['date_end'] . ' ' . $params['time_end']);
    
        // Initialize credits counter
        $credits = 0;
    
        // Loop through each day in the range
        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            // Exclude weekends (Saturday or Sunday)
            if (!$date->isWeekend()) {
                // Calculate the work hours for the current day
                $workHours = min(8, $endDate->diffInHours($date)); // Maximum 8 hours per day

                // Calculate credits based on work hours for the day
                $dayCredits = $workHours / 8; // 1 credit = 8 hours
                $credits += $dayCredits;
            }
        }
    
        // Proceed with storing the data using $params
        $params['credit'] = $credits;
        $data = $this->create($params);
        return $data;
    }
    
}
