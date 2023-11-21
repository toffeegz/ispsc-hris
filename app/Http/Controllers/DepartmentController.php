<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentRequest as ModelRequest;
use App\Models\Department;
use App\Repositories\Department\DepartmentRepositoryInterface;
use App\Services\Utils\Response\ResponseServiceInterface;

class DepartmentController extends Controller
{
    private $modelService;
    private $responseService;
    private $name = 'Department';
    
    public function __construct(
        DepartmentRepositoryInterface $modelRepository, 
        ResponseServiceInterface $responseService,
    ) {
        $this->modelRepository = $modelRepository;
        $this->responseService = $responseService;
    }

    public function index()
    {
        $results = $this->modelRepository->lists(request(['search']), ['headEmployee']);
        return $this->responseService->successResponse($this->name, $results);
    }

    public function archive()
    {
        $results = $this->modelRepository->archives(request(['search']), ['headEmployee']);
        return $this->responseService->successResponse($this->name, $results);
    }

    public function store(ModelRequest $request)
    {
        $result = $this->modelRepository->create($request->all());
        return $this->responseService->storeResponse($this->name, $result);
    }

    public function show($id)
    {
        $result = $this->modelRepository->show($id, ['headEmployee']);
        return $this->responseService->successResponse($this->name, $result);
    }

    public function update(ModelRequest $request, $id)
    {
        $result = $this->modelRepository->update($request->all(), $id);
        return $this->responseService->updateResponse($this->name, $result);
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

