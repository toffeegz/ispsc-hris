<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Utils\Response\ResponseServiceInterface;
use App\Services\Dashboard\DashboardServiceInterface;

class DashboardController extends Controller
{
    private $modelService;
    private $responseService;
    private $name = 'Dashboard';
    
    public function __construct(
        DashboardServiceInterface $modelService, 
        ResponseServiceInterface $responseService,
    ) {
        $this->modelService = $modelService;
        $this->responseService = $responseService;
    }

    public function departmentWiseTardiness()
    {
        $frequency = request()->input('frequency', "monthly");
        $start_date = request()->input('start_date', null);
        $end_date = request()->input('end_date', null);

        // $results = $this->modelService->departmentWiseTardiness($frequency, $start_date, $end_date);
        $results = array(
            "max_average_minutes" => 25, // Replace with the actual value if available
            "max_occurrences" => 20, // Maximum occurrences among departments
            "average_minutes" => 15, // Replace with the actual value if available
            "average_occurrences" => 14.6,
            "data" => array(
                array(
                    "department" => "CTE",
                    "average_tardiness_minutes" => 10,
                    "average_tardiness_time" => "10 mins",
                    "total_occurrences" => 12,
                    "late_employees" => array()
                ),
                array(
                    "department" => "CAS",
                    "average_tardiness_minutes" => 5,
                    "average_tardiness_time" => "5 mins",
                    "total_occurrences" => 8,
                    "late_employees" => array()
                ),
                array(
                    "department" => "CBE",
                    "average_tardiness_minutes" => 20,
                    "average_tardiness_time" => "20 mins",
                    "total_occurrences" => 15,
                    "late_employees" => array()
                ),
                array(
                    "department" => "CJE",
                    "average_tardiness_minutes" => 15,
                    "average_tardiness_time" => "15 mins",
                    "total_occurrences" => 18,
                    "late_employees" => array()
                ),
                array(
                    "department" => "ACAD",
                    "average_tardiness_minutes" => 25,
                    "average_tardiness_time" => "25 mins",
                    "total_occurrences" => 20,
                    "late_employees" => array()
                )
            )
        );
        
        return $this->responseService->successResponse($this->name, $results);
    }

    public function employeeTardiness()
    {
        $department_ids = request()->input('department_ids', []);
        $month = request()->input('month', null);
        $year = request()->input('year', null);

        $results = $this->modelService->employeeTardiness($department_ids, $month, $year);
        return $this->responseService->successResponse($this->name, $results);
    }

    public function topHabitualLateComers()
    {
        $frequency = request()->input('frequency', "monthly");
        $start_date = request()->input('start_date', null);
        $end_date = request()->input('end_date', null);

        $results = $this->modelService->topHabitualLateComers($frequency, $start_date, $end_date);
        return $this->responseService->successResponse($this->name, $results);
    }

    public function opcr()
    {
        $ipcr_period_id = request()->input('ipcr_period_id', null);
        $results = $this->modelService->opcr($ipcr_period_id);
        return $this->responseService->successResponse($this->name, $results);
    }

    public function ipcr()
    {
        $ipcr_period_id = request()->input('ipcr_period_id', null);
        $department_id = request()->input('department_id', null);
        $results = $this->modelService->ipcr($ipcr_period_id, $department_id);
        return $this->responseService->successResponse($this->name, $results);
    }

    public function ipcrGraph()
    {
        $ipcr_period_id = request()->input('ipcr_period_id', null);
        $results = $this->modelService->ipcrGraph($ipcr_period_id);
        return $this->responseService->successResponse($this->name, $results);
    }

    public function employees()
    {
        $results = $this->modelService->employeesGender();
        return $this->responseService->successResponse($this->name, $results);
    }
}
