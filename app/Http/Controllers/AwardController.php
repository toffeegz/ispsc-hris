<?php

namespace App\Http\Controllers;

use App\Http\Requests\AwardRequest as ModelRequest;
use App\Models\Award;
use App\Repositories\Award\AwardRepositoryInterface;
use App\Services\Utils\Response\ResponseServiceInterface;

class AwardController extends Controller
{
    private $modelService;
    private $responseService;
    private $name = 'Award';
    
    public function __construct(
        AwardRepositoryInterface $modelRepository, 
        ResponseServiceInterface $responseService,
    ) {
        $this->modelRepository = $modelRepository;
        $this->responseService = $responseService;
    }

    public function overview()
    {
        $results = $this->modelRepository->overview(request(['search']));
        return $this->responseService->successResponse($this->name, $results);
    }

    public function details()
    {
        $results = $this->modelRepository->lists(request(['search']), ['employee', 'employee.department']);
        return $this->responseService->successResponse($this->name, $results);
    }

    public function archive()
    {
        $results = $this->modelRepository->archives(request(['search']));
        return $this->responseService->successResponse($this->name, $results);
    }

    public function store(ModelRequest $request)
    {
        $result = $this->modelRepository->create($request->all());
        return $this->responseService->storeResponse($this->name, $result);
    }

    public function show($id)
    {
        $result = $this->modelRepository->show($id);
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
