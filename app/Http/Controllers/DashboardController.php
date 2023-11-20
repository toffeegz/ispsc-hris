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

        $results = $this->modelService->departmentWiseTardiness($frequency, $start_date, $end_date);
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
}
