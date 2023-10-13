<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttendanceRequest as ModelRequest;
use App\Models\Attendance;
use App\Repositories\Attendance\AttendanceRepositoryInterface;
use App\Services\Utils\Response\ResponseServiceInterface;

class AttendanceController extends Controller
{
    private $modelService;
    private $responseService;
    private $name = 'Attendance';
    
    public function __construct(
        AttendanceRepositoryInterface $modelRepository, 
        ResponseServiceInterface $responseService,
    ) {
        $this->modelRepository = $modelRepository;
        $this->responseService = $responseService;
    }

    public function index()
    {
        $results = $this->modelRepository->lists(request(['search']), ['employee']);
        return $this->responseService->successResponse($this->name, $results);
    }

    public function archive()
    {
        $results = $this->modelRepository->archives(request(['search']), ['employee']);
        return $this->responseService->successResponse($this->name, $results);
    }

    public function show($id)
    {
        $result = $this->modelRepository->show($id, ['employee']);
        return $this->responseService->successResponse($this->name, $result);
    }

    public function delete(string $id)
    {
        $result = $this->modelRepository->delete($id);
        return $this->responseService->successResponse($this->name, $result);
    }

    public function restore(string $id)
    {
        $result = $this->modelRepository->restore($id);
        return $this->responseService->successResponse($this->name, $result);
    }
}


