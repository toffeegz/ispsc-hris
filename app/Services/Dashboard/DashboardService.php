<?php

namespace App\Services\Dashboard;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

use App\Models\Department;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Opcr;
use App\Models\IpcrPeriod;
use App\Models\IpcrEvaluation;
use App\Models\Training;
use App\Models\Award;

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
        $employees = Employee::select('id', 'department_id', 'first_name', 'middle_name', 'last_name')->get();

        // Group employees by department
        $employeesByDepartment = $employees->groupBy('department_id');

        if ($frequency !== "specific_date") {
            $betweenDates = $this->betweenDates($frequency);
            $start_date = $betweenDates['start_date'];
            $end_date = $betweenDates['end_date'];
        }

        // Loop through all departments
        foreach (Department::all() as $department) {
            $departmentId = $department->id;

            // Get employees in the current department
            $departmentEmployees = $employeesByDepartment->get($departmentId);

            // If there are employees in the department, proceed to calculate tardiness
            if ($departmentEmployees) {
                $attendances = Attendance::whereIn('employee_id', $departmentEmployees->pluck('id')->toArray())
                    ->whereBetween('date', [$start_date, $end_date])
                    ->get();

                // Calculate total tardiness time (in minutes)
                $totalTardinessTime = $attendances->sum('undertime');

                // Calculate the total number of late occurrences
                $totalLateOccurrences = $attendances->where('undertime', '>', 0)->count();

                // Calculate the average tardiness time
                $averageTardinessTime = $totalLateOccurrences > 0 ? $totalTardinessTime / $totalLateOccurrences : 0;

                // Get the department name
                $departmentName = $department->name;

                // List of employees who were late
                $lateEmployees = $attendances->where('undertime', '>', 0)
                    ->pluck('employee_id')
                    ->map(function ($employeeId) use ($employees) {
                        return $employees->firstWhere('id', $employeeId);
                    })
                    ->unique('id');

                $tardinessData[] = [
                    'department' => $department->acronym,
                    'average_tardiness_minutes' => $averageTardinessTime,
                    'average_tardiness_time' => $this->minutesToStr($averageTardinessTime),
                    'total_occurrences' => $totalLateOccurrences,
                    'late_employees' => $lateEmployees,
                ];
            } else {
                // If there are no employees in the department, add it to the result with no late occurrences
                $tardinessData[] = [
                    'department' => $department->acronym,
                    'average_tardiness_minutes' => 0,
                    'average_tardiness_time' => '0 mins',
                    'total_occurrences' => 0,
                    'late_employees' => [],
                ];
            }
        }

        // max average
        $maxAverageTardiness = 0; // Initialize the maximum value to 0

        foreach ($tardinessData as $departmentData) {
            $averageTardinessMinutes = $departmentData['average_tardiness_minutes'];
            if ($averageTardinessMinutes > $maxAverageTardiness) {
                $maxAverageTardiness = $averageTardinessMinutes; // Update the maximum value
            }
        }

        //
        // Calculate additional statistics
        $maxAverageTardiness = max(array_column($tardinessData, 'average_tardiness_minutes'));
        $maxOccurrences = max(array_column($tardinessData, 'total_occurrences'));
        $averageMinutes = array_sum(array_column($tardinessData, 'average_tardiness_minutes')) / count($tardinessData);
        $averageOccurrences = array_sum(array_column($tardinessData, 'total_occurrences')) / count($tardinessData);

        $results = [
            'max_average_minutes' => $this->minutesToStr($maxAverageTardiness),
            'max_occurrences' => $maxOccurrences,
            'average_minutes' => $this->minutesToStr($averageMinutes),
            'average_occurrences' => number_format($averageOccurrences, 2),
            'data' => $tardinessData,
        ];

        return $results;
    }

    public function employeeTardiness($department_ids = [], $month = null, $year = null)
    {
        $tardinessData = [];

        // Get all employees
        $employeesQuery = Employee::query();

        if (!empty($department_ids)) {
            // Filter employees by department IDs if provided
            $employeesQuery->whereIn('department_id', $department_ids);
            
        }

        $employees = $employeesQuery->orderBy('last_name')->get();

        $now = now();

        if (!$month) {
            $month = $now->month;
        }
        if(!$year) {
            $year = $now->year;
        }

        // Calculate the start and end dates based on the provided month and year
        $start_date = now()->year($year)->month($month)->startOfMonth();
        $end_date = now()->year($year)->month($month)->endOfMonth();

        // Retrieve attendance records for the selected month and year
        $attendances = Attendance::whereIn('employee_id', $employees->pluck('id')->toArray())
            ->whereBetween('date', [$start_date, $end_date])
            ->get();

        // Loop through employees and calculate tardiness for each
        foreach ($employees as $employee) {
            $employeeAttendances = $attendances->where('employee_id', $employee->id);

            // Calculate tardiness for each day in the month
            $tardinessByDay = [];
            $totalTardinessTime = 0;
            for ($day = 1; $day <= $end_date->day; $day++) {
                $attendance = $employeeAttendances
                    ->where('date', $start_date->day($day)->toDateString())
                    ->first();

                if ($attendance) {
                    $undertime = $attendance->undertime;
                    if ($undertime > 0) {
                        // Employee was late; record the tardiness in minutes
                        $tardinessByDay[] = $this->minutesToStr($undertime);
                        $totalTardinessTime += $undertime;
                    } else {
                        // Employee was on time
                        $tardinessByDay[] = "On-Time";
                    }
                } else {
                    // No attendance record for this day
                    $tardinessByDay[] = "";
                }
            }


            $tardinessData[] = [
                'employee' => $employee->full_name_formal,
                'tardiness_minutes_by_day' => $tardinessByDay,
                'total_tardines_time' => $this->minutesToStr($totalTardinessTime),
                'total_tardines_minutes' => $totalTardinessTime,

            ];
        }

        return $tardinessData;
    }

    public function topHabitualLateComers(string $frequency, $start_date, $end_date)
    {
        // Initialize an array to store the results
        $tardinessData = [];
    
        // Retrieve all employees
        $employees = Employee::all();
    
        // If the frequency is not "specific_date," calculate start and end dates
        if ($frequency !== "specific_date") {
            $betweenDates = $this->betweenDates($frequency);
            $start_date = $betweenDates['start_date'];
            $end_date = $betweenDates['end_date'];
        }
    
        // Loop through all employees
        foreach ($employees as $employee) {
            // Calculate the total tardiness minutes for the employee within the specified time range
            $totalTardinessMinutes = Attendance::where('employee_id', $employee->id)
                ->whereBetween('date', [$start_date, $end_date])
                ->sum('undertime');
    
            // If the employee has tardiness minutes greater than 0, add their information to the result array
            if ($totalTardinessMinutes > 0) {
                // Get the department name for the employee
                $departmentName = $employee->department->acronym;

                // Add the employee's information to the result array
                $tardinessData[] = [
                    'employee_name' => $employee->full_name_formal,
                    'department_name' => $departmentName,
                    'total_tardiness' => $this->minutesToStr($totalTardinessMinutes),
                    'total_tardiness_minutes' => $totalTardinessMinutes,
                ];
            }
        }
    
        // Sort the result array by total tardiness minutes in descending order
        usort($tardinessData, function ($a, $b) {
            return $b['total_tardiness_minutes'] - $a['total_tardiness_minutes'];
        });

        // You now have an array ($tardinessData) with employee names, department names, and total tardiness minutes
        return array_slice($tardinessData, 0, 10); 
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

    public function opcr($ipcr_period_id)
    {
        if (!$ipcr_period_id) {
            $latest_ipcr_period = IpcrPeriod::orderBy('year', 'desc')
                ->orderBy('start_month', 'desc')
                ->first();
    
            if ($latest_ipcr_period) {
                $ipcr_period_id = $latest_ipcr_period->id;
            }
        }

        $opcr = Opcr::with('departmentHeadEmployee')
            ->where('ipcr_period_id', $ipcr_period_id)
            ->get();
        return $opcr;
    }

    public function ipcr($ipcr_period_id, $department_id)
    {
        if (!$ipcr_period_id) {
            $latest_ipcr_period = IpcrPeriod::orderBy('year', 'desc')
                ->orderBy('start_month', 'desc')
                ->first();

            if ($latest_ipcr_period) {
                $ipcr_period_id = $latest_ipcr_period->id;
            }
        }

        $query = IpcrEvaluation::with('employee', 'employee.department')->where('ipcr_period_id', $ipcr_period_id);

        if ($department_id) {
            $query->whereHas('employee', function ($query) use ($department_id) {
                $query->where('department_id', $department_id);
            });
        }

        $ipcrEvaluations = $query->get();

        return $ipcrEvaluations;
    }

    public function ipcrGraph($ipcr_period_id)
    {
        if (!$ipcr_period_id) {
            $latest_ipcr_period = IpcrPeriod::orderBy('year', 'desc')
                ->orderBy('start_month', 'desc')
                ->first();

            if ($latest_ipcr_period) {
                $ipcr_period_id = $latest_ipcr_period->id;
            }
        }
    
        $evaluationCounts = IpcrEvaluation::where('ipcr_period_id', $ipcr_period_id)
            ->selectRaw('ROUND(final_average_rating) as rounded_rating, COUNT(*) as count')
            ->groupBy('rounded_rating')
            ->get();
    
        $maxCount = $evaluationCounts->max('count');
    
        // Prepare the data in the desired structure
        $data = [];
        for ($i = 1; $i <= 5; $i++) {
            $count = $evaluationCounts->firstWhere('rounded_rating', $i);
            $data[] = [
                'count' => $count ? $count->count : 0,
                'rate' => $i,
            ];
        }
    
        return [
            'max_count' => $maxCount,
            'data' => $data,
        ];
    }

    public function employeesGender()
    {
        $maleCount = Employee::where('sex', 'male')->count();
        $femaleCount = Employee::where('sex', 'female')->count();

        // Fetching colors from config
        $colorsConfig = config('hris.dashboard_colors.employees');
        
        return [
            [
                'label' => 'Male',
                'count' => $maleCount,
                'backgroundColor' => $colorsConfig['male'],
            ],
            [
                'label' => 'Female',
                'count' => $femaleCount,
                'backgroundColor' => $colorsConfig['female'],
            ],
        ];
    }

    public function trainings() 
    {
        $currentYear = date('Y');
        $fiveYearsAgo = $currentYear - 5;
        $trainings = Training::whereYear('created_at', '>=', $fiveYearsAgo)
            ->whereYear('created_at', '<=', $currentYear)
            ->get();
    
        $departments = Department::all();
    
        $departmentYearCounts = [];
    
        foreach ($departments as $department) {
            $departmentAcronym = $department->acronym;
    
            // If department is non_teaching, include in 'ACAD'
            if ($department->non_teaching) {
                $departmentAcronym = 'ACAD';
            }
    
            foreach (range($fiveYearsAgo, $currentYear) as $year) {
                $departmentYearCounts[$departmentAcronym][$year] = 0;
            }
        }
    
        foreach ($trainings as $training) {
            $employees = $training->employees;
    
            foreach ($employees as $employee) {
                $departmentId = $employee->department_id;
                $department = Department::find($departmentId);
    
                if ($department) {
                    $departmentAcronym = $department->acronym;
    
                    if ($department->non_teaching) {
                        $departmentAcronym = 'ACAD';
                    }
    
                    $year = $training->created_at->format('Y');
                    $departmentYearCounts[$departmentAcronym][$year]++;
                }
            }
        }
    
        $formattedData = [];
    
        foreach ($departmentYearCounts as $label => $count) {
            $formattedData[] = [
                'label' => $label,
                'count' => collect($count)->map(function ($value, $year) {
                    return ['year' => $year, 'value' => $value];
                })->values()->all(),
                'backgroundColor' => Department::where('acronym', $label)->value('color'), // Assuming 'color' is the field in the Department model
            ];
        }
    
        $currentYear = date('Y');
        $fiveYearsAgo = $currentYear - 5;
        $years = range($fiveYearsAgo, $currentYear);

        $finalData = [
            'years' => $years,
            'data' => $formattedData,
        ];

        return $finalData;
    }

    public function awards() 
    {
        $currentYear = date('Y');
        $fiveYearsAgo = $currentYear - 5;
        $awards = Award::whereYear('date_awarded', '>=', $fiveYearsAgo)
            ->whereYear('date_awarded', '<=', $currentYear)
            ->get();

        $departmentYearCounts = [];

        // Create years array from the last 5 years
        $years = range($fiveYearsAgo, $currentYear);

        // Initialize department counts for each year
        foreach ($years as $year) {
            foreach (Department::all() as $department) {
                $departmentAcronym = $department->acronym;

                // If department is non_teaching, include in 'ACAD'
                if ($department->non_teaching) {
                    $departmentAcronym = 'ACAD';
                }

                $departmentYearCounts[$departmentAcronym][$year] = 0;
            }
        }

        foreach ($awards as $award) {
            $employee = $award->employee;
            $department = $employee->department;

            if ($department) {
                $departmentAcronym = $department->acronym;
                $year = $award->date_awarded->format('Y');

                // If department is non_teaching, include in 'ACAD'
                if ($department->non_teaching) {
                    $departmentAcronym = 'ACAD';
                }

                $departmentYearCounts[$departmentAcronym][$year]++;
            }
        }

        $formattedData = [];

        foreach ($departmentYearCounts as $label => $count) {
            $formattedData[] = [
                'label' => $label,
                'count' => collect($count)->map(function ($value, $year) {
                    return ['year' => $year, 'value' => $value];
                })->values()->all(),
                'backgroundColor' => Department::where('acronym', $label)->value('color'), // Assuming 'color' is the field in the Department model
            ];
        }

        // Prepare the final structured data
        $finalData = [
            'years' => $years,
            'data' => $formattedData,
        ];

        return $finalData;
    }

    
    

}
