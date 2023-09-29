<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest as ModelRequest;
use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\Utils\Response\ResponseServiceInterface;
use App\Services\User\UserServiceInterface;

class UserController extends Controller
{
    private $modelService;
    private $responseService;
    private $name = 'User';
    
    public function __construct(
        UserRepositoryInterface $modelRepository, 
        UserServiceInterface $modelService, 
        ResponseServiceInterface $responseService,
    ) {
        $this->modelRepository = $modelRepository;
        $this->modelService = $modelService;
        $this->responseService = $responseService;
    }

    public function index()
    {
        $results = $this->modelRepository->lists(request(['search']));
        return $this->responseService->successResponse($this->name, $results);
    }

    public function archive()
    {
        $results = $this->modelRepository->archives(request(['search']));
        return $this->responseService->successResponse($this->name, $results);
    }

    public function store(ModelRequest $request)
    {
        $validatedData = $request->validated();

        $allowedColumns = array_keys($validatedData);
        $data = $request->only($allowedColumns);

        $result = $this->modelService->store($data);
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
