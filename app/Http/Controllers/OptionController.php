<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Utils\Response\ResponseServiceInterface;

use App\Models\Department;
use App\Models\Position;
use App\Models\EmploymentStatus;
use App\Models\LeaveType;
use App\Models\IpcrPeriod;
use App\Models\IpcrCategory;
use App\Models\IpcrSubcategory;
use App\Models\Employee;

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

    public function ipcr_periods()
    {
        $results = IpcrPeriod::select(['id', 'start_month', 'end_month', 'year'])->get();

        $formattedResults = $results->map(function ($result) {
            $startMonth = date("M", mktime(0, 0, 0, $result->start_month, 1));
            $endMonth = date("M", mktime(0, 0, 0, $result->end_month, 1));

            $dateRange = $startMonth . ' to ' . $endMonth . ' ' . $result->year;

            return [
                'id' => $result->id,
                'date_range' => $dateRange,
            ];
        });

        return $this->responseService->successResponse($this->name, $formattedResults);
    }

    public function ipcr_categories()
    {
        $results = IpcrCategory::select(['id', 'name', 'weight', 'order'])
            ->orderBy('order') 
            ->get();
        return $this->responseService->successResponse($this->name, $results);
    }

    public function ipcr_permanent_item_names()
    {
        // Get the condition based on request()->ipcr_subcategory
        $condition = request()->ipcr_subcategory;

        // Get the ipcr_support_functions array from the config file
        $ipcrSupportFunctions = config('hris.ipcr_support_functions');

        // Define a variable to store the result
        $results = [];

        if ($condition === "Prompt Submission of Documents") {
            // If the condition is "Prompt Submission of Documents," get the 'a' list
            $results = $ipcrSupportFunctions['a'];
        } elseif ($condition === "Attendance to:") {
            // If the condition starts with "Attendance to:", get the 'b' list
            $results = $ipcrSupportFunctions['b'];
        } else {
            // Merge 'a' and 'b' if the condition is empty or null
            $results = array_merge($ipcrSupportFunctions['a'], $ipcrSupportFunctions['b']);
        }

        // Return the results
        return $results;
    }

    public function ipcr_subcategories()
    {
        $parent_id = request()->parent_id ?? null;
        $query = IpcrSubcategory::select(['id', 'name', 'weight', 'parent_id']);

        if ($parent_id !== null) {
            $query->where('parent_id', $parent_id);
        }

        $results = $query->get();
        return $this->responseService->successResponse($this->name, $results);
    }

    public function employees()
    {
        $results = Employee::select(['id', 'first_name', 'middle_name', 'last_name', 'employee_id'])->get();
        return $this->responseService->successResponse($this->name, $results);
    }

}
