<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeStoreRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use App\Http\Requests\EmployeeEducationUpdateRequest;
use App\Models\Employee;
use App\Repositories\Employee\EmployeeRepositoryInterface;
use App\Services\Utils\Response\ResponseServiceInterface;

class EmployeeController extends Controller
{
    private $modelService;
    private $responseService;
    private $name = 'Employee';
    
    public function __construct(
        EmployeeRepositoryInterface $modelRepository, 
        ResponseServiceInterface $responseService,
    ) {
        $this->modelRepository = $modelRepository;
        $this->responseService = $responseService;
    }

    public function index()
    {
        $results = $this->modelRepository->lists(request(['search']), ['department', 'position', 'trainings', 'educational_backgrounds']);
        return $this->responseService->successResponse($this->name, $results);
    }

    public function archive()
    {
        $results = $this->modelRepository->archives(request(['search']), ['department', 'position', 'trainings', 'educational_backgrounds']);
        return $this->responseService->successResponse($this->name, $results);
    }

    public function store(EmployeeStoreRequest $request)
    {
        $result = $this->modelRepository->store($request->all());
        return $this->responseService->storeResponse($this->name, $result);
    }

    public function update(EmployeeUpdateRequest $request, $id)
    {
        $result = $this->modelRepository->edit($request->all(), $id);
        return $this->responseService->updateResponse($this->name, $result);
    }

    public function show($id)
    {
        $result = $this->modelRepository->show($id, ['department', 'position', 'trainings', 'educational_backgrounds']);
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

    public function education(EmployeeEducationUpdateRequest $request, $id)
    {
        $result = $this->modelRepository->education($request->educations, $id);
        return $this->responseService->updateResponse($this->name, $result);
    }

    public function training(EmployeeEducationUpdateRequest $request, $id)
    {
        $result = $this->modelRepository->training($request->trainings, $id);
        return $this->responseService->updateResponse($this->name, $result);
    }
}
