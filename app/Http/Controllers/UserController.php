<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest as ModelRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\Utils\Response\ResponseServiceInterface;
use App\Services\User\UserServiceInterface;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(ModelRequest $request)
    {
        $validatedData = $request->validated();

        $allowedColumns = array_keys($validatedData);
        $data = $request->only($allowedColumns);

        $result = $this->modelService->store($data);
        return $this->responseService->storeResponse($this->name, $result);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ModelRequest $request, $id)
    {
        $result = $this->modelRepository->update($request->all(), $id);
        return $this->responseService->updateResponse($this->name, $result);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
