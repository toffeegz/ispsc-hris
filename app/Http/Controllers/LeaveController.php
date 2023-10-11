<?php

namespace App\Http\Controllers;

use App\Http\Requests\LeaveRequest as ModelRequest;
use App\Models\Leave;
use App\Repositories\Leave\LeaveRepositoryInterface;
use App\Services\Utils\Response\ResponseServiceInterface;

class LeaveController extends Controller
{
    private $modelService;
    private $responseService;
    private $name = 'Leave';
    
    public function __construct(
        LeaveRepositoryInterface $modelRepository, 
        ResponseServiceInterface $responseService,
    ) {
        $this->modelRepository = $modelRepository;
        $this->responseService = $responseService;
    }

    public function index()
    {
        $search = request()->input('search', null);
        $status = request()->input('status', null);
        $formattedSearchArray = [];
        if ($search !== null) {
            $formattedSearchArray['search'] = $search;
        }
        if ($status !== null) {
            $formattedSearchArray['status'] = $status;
        }
        $results = $this->modelRepository->lists($formattedSearchArray, ['employee', 'leave_type']);
        return $this->responseService->successResponse($this->name, $results);
    }

    public function archive()
    {
        $searchArray = request()->input('search', []);
        $formattedSearchArray = [];
        foreach ($searchArray as $criteria) {
            $formattedSearchArray[$criteria['field']] = $criteria['value'];
        }
        $results = $this->modelRepository->archives($formattedSearchArray, ['employee', 'leave_type']);
        return $this->responseService->successResponse($this->name, $results);
    }

    public function store(ModelRequest $request)
    {
        $result = $this->modelRepository->create($request->all());
        return $this->responseService->storeResponse($this->name, $result);
    }

    public function show($id)
    {
        $result = $this->modelRepository->show($id, ['employee', 'leave_type']);
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
