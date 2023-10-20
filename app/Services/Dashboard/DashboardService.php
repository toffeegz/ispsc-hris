<?php

namespace App\Services\Dashboard;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;
use App\Models\Department;
use App\Models\Attendance;
use App\Models\Employee;

class DashboardService implements DashboardServiceInterface
{
    
    public function __construct(
        
    ) {
        //
    }

    public function departmentWiseTardiness(string $frequency, $start_date, $end_date)
    {
        $tardinessData = [];
        
        // Get all employees, including those without a department
        $employees = Employee::select('id', 'department_id', 'first_name', 'middle_name', 'last_name')
        ->get();
        $tardinessData = [];

        // Group employees by department
        $employeesByDepartment = $employees->groupBy('department_id');

        if ($frequency !== "specific_date") {
            $betweenDates = $this->betweenDates($frequency);
            $start_date = $betweenDates['start_date'];
            $end_date = $betweenDates['end_date'];
        }

        foreach ($employeesByDepartment as $departmentId => $departmentEmployees) 
        {
            $attendances = Attendance::whereIn('employee_id', $departmentEmployees->pluck('id')->toArray())
            ->whereBetween('date', [$start_date, $end_date])
            ->get();

            // Calculate total tardiness time (in minutes)
            $totalTardinessTime = $attendances->sum('undertime');

            // Calculate the total number of late occurrences
            $totalLateOccurrences = $attendances->where('undertime', '>', 0)->count();

            // Calculate the average tardiness time
            $averageTardinessTime = $totalLateOccurrences > 0 ? $totalTardinessTime / $totalLateOccurrences : 0;

            // If there are late occurrences in the department, add it to the result
            if ($totalLateOccurrences > 0) 
            {
                // Get the department name or set it to "N/A" if the department doesn't exist
                $departmentName = $departmentId ? Department::find($departmentId)->name : 'N/A';

                // List of employees who were late
                $lateEmployees = $attendances->where('undertime', '>', 0)
                ->pluck('employee_id')
                ->map(function ($employeeId) use ($employees) {
                    return $employees->firstWhere('id', $employeeId);
                })
                ->unique('id');

                $tardinessData[] = [
                    'department' => $departmentName,
                    'average_tardiness_minutes' => $averageTardinessTime,
                    'average_tardiness_time' => $this->minutesToStr($averageTardinessTime),
                    'total_occurrences' => $totalLateOccurrences,
                    'late_employees' => $lateEmployees,
                ];
            }
        }

        return $tardinessData;
    }

    public function employeeTardiness()
    {
        
    }

    public function topHabitualLateComers()
    {
        
    }

    public function minutesToStr($minutes)
    {
        if(!$minutes) {
            return null;
        }

        $hours = floor($minutes / 60);
        $remainingMinutes = $minutes % 60;

        
        if ($hours == 0) {
            $str = "{$remainingMinutes}min";
            if($remainingMinutes > 1) {
                $str = $str . "s";
            } 
            return $str;
        }
         elseif ($remainingMinutes == 0) {
            $str = "{$hours}hr";
            if($hours > 1) {
                $str = $str . "s";
            }
        } else {
            $str = "{$hours}hr";
            if($hours > 1) {
                $str = $str . "s";
            }
            $str = $str . " " . "{$remainingMinutes}min";
            if($remainingMinutes > 1) {
                $str = $str . "s";
            }
            return $str;
        }
    }

    public function betweenDates($frequency)
    {
        $start_date = Carbon::now();
        $end_date = Carbon::now();

        switch ($frequency) {
            case "yearly":
                $start_date->subYear();
                break;
            case "monthly":
                $start_date->subMonth();
                break;
            case "weekly":
                $start_date->subWeek();
                break;
            case "daily":
                $start_date->subDay();
                break;
            default:
                // Handle any other cases or provide a default action if needed.
                break;
        }

        return [
            'start_date' => $start_date,
            'end_date' => $end_date,
        ];
    }
}
