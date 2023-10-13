<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Utils\Response\ResponseServiceInterface;

use App\Models\Department;
use App\Models\Position;
use App\Models\EmploymentStatus;
use App\Models\LeaveType;

class OptionController extends Controller
{
    private $responseService;
    private $name = 'Option';
    
    public function __construct(
        ResponseServiceInterface $responseService
    ) {
        $this->responseService = $responseService;
    }

    public function departments()
    {
        $results = Department::select(['id', 'name'])->get();
        return $this->responseService->successResponse($this->name, $results);
    }

    public function positions(Request $request)
    {
        // Get the department_id from the request, or default to null if not provided
        $department_id = $request->input('department_id', null);
        $query = Position::select(['id', 'name']);
        if ($department_id !== null) {
            $query->where('department_id', $department_id);
        }
        $results = $query->get();
        return $this->responseService->successResponse($this->name, $results);
    }

    public function employment_statuses()
    {
        $results = EmploymentStatus::select(['id', 'name'])->get();
        return $this->responseService->successResponse($this->name, $results);
    }

    public function leave_types()
    {
        $results = LeaveType::select(['id', 'name'])->get();
        return $this->responseService->successResponse($this->name, $results);
    }
}
