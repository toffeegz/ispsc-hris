<?php

namespace App\Http\Controllers;

use App\Http\Requests\IpcrEvaluationItemRequest as ModelRequest;
use App\Models\IpcrEvaluationItem;
use App\Repositories\IpcrEvaluationItem\IpcrEvaluationItemRepositoryInterface;
use App\Services\Utils\Response\ResponseServiceInterface;

class IpcrEvaluationItemController extends Controller
{
    private $modelService;
    private $responseService;
    private $name = 'IpcrEvaluationItem';
    
    public function __construct(
        IpcrEvaluationItemRepositoryInterface $modelRepository, 
        ResponseServiceInterface $responseService,
    ) {
        $this->modelRepository = $modelRepository;
        $this->responseService = $responseService;
    }

    public function index()
    {
        $results = $this->modelRepository->lists(request()->ipcr_evaluation);
        return $this->responseService->successResponse($this->name, $results);
    }
}
