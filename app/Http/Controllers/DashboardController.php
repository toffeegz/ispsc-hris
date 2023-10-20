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
        
    }

    public function topHabitualLateComers()
    {
        
    }
}
