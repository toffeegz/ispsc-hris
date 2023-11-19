<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Opcr\OpcrRepositoryInterface;
use App\Services\Utils\Response\ResponseServiceInterface;

class OpcrController extends Controller
{
    private $modelRepository;
    private $responseService;
    private $name = 'OPCR';
    
    public function __construct(
        OpcrRepositoryInterface $modelRepository, 
        ResponseServiceInterface $responseService,
    ) {
        $this->modelRepository = $modelRepository;
        $this->responseService = $responseService;
    }

    public function index()
    {
        $results = $this->modelRepository->index(request(['search']), request()->ipcr_period_id, ['departmentHeadEmployee', 'department', 'ipcrPeriod']);
        return $this->responseService->successResponse($this->name, $results);
    }
}
