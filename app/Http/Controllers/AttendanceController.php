<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttendanceDatRequest;
use App\Http\Requests\AttendanceXlsxRequest;
use App\Models\Attendance;
use App\Repositories\Attendance\AttendanceRepositoryInterface;
use App\Services\Attendance\AttendanceServiceInterface;
use App\Services\Utils\Response\ResponseServiceInterface;

class AttendanceController extends Controller
{
    private $modelRepository;
    private $modelService;
    private $responseService;
    private $name = 'Attendance';
    
    public function __construct(
        AttendanceRepositoryInterface $modelRepository, 
        AttendanceServiceInterface $modelService, 
        ResponseServiceInterface $responseService,
    ) {
        $this->modelRepository = $modelRepository;
        $this->modelService = $modelService;
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

    public function importDat(AttendanceDatRequest $request)
    {
        $result = $this->modelService->storeDat($request->file('file'));
        return $this->responseService->successResponse($this->name, $result);
    }

    public function importXlsx(AttendanceXlsxRequest $request)
    {
        $result = $this->modelService->storeXlsx($request->file('file'));
        return $this->responseService->successResponse($this->name, $result);
    }

}


