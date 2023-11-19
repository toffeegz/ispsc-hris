<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIpcrEvaluationRequest;
use App\Http\Requests\UpdateIpcrEvaluationRequest;
use App\Models\IpcrEvaluation;
use App\Repositories\IpcrEvaluation\IpcrEvaluationRepositoryInterface;
use App\Services\IpcrEvaluation\IpcrEvaluationServiceInterface;
use App\Services\Utils\Response\ResponseServiceInterface;
use Illuminate\Http\Request;

class IpcrEvaluationController extends Controller
{
    private $modelService;
    private $responseService;
    private $name = 'IpcrEvaluation';
    
    public function __construct(
        IpcrEvaluationRepositoryInterface $modelRepository, 
        IpcrEvaluationServiceInterface $modelService, 
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
        $results = $this->modelRepository->archives(request(['search']));
        return $this->responseService->successResponse($this->name, $results);
    }

    public function store(StoreIpcrEvaluationRequest $request)
    {
        $result = $this->modelService->create($request->all());
        return $this->responseService->storeResponse($this->name, $result);
    }

    public function show($id)
    {
        $result = $this->modelService->show($id);
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
