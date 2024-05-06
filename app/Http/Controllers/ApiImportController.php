<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Department;
use App\Models\Position;
use App\Models\EmploymentStatus;
use App\Models\Employee;
use App\Models\EmployeeTraining;
use App\Models\Training;
use App\Models\Award;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class ApiImportController extends Controller
{
    public function importEmployee(Request $request)
    {
        Employee::truncate();
        EmployeeTraining::truncate();
        // Validate the request
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        // Retrieve file from request
        $file = $request->file('file');

        // Parse Excel file
        $data = Excel::toArray([], $file);

        // Assuming the first sheet is used and it contains data
        $rows = $data[0];

        // Map column headers to database fields
        $columnMap = [
            0 => 'employee_id',
            1 => 'last_name',
            2 => 'first_name',
            3 => 'middle_name',
            4 => 'name_ext',
            5 => 'birth_date',
            6 => 'birth_place',
            7 => 'gender',
            8 => 'civil_status',
            9 => 'citizenship',
            10 => 'email',
            11 => 'tel_no',
            12 => 'mobile_no',
            13 => 'date_hired',
            14 => 'department',
            15 => 'position',
            16 => 'employment_status',
        ];

        // Loop through rows
        foreach ($rows as $row) {
            // Map Excel data to database fields
            $employeeData = [];
            foreach ($columnMap as $excelIndex => $dbField) {
                if (in_array($dbField, ['birth_date', 'date_hired']) && isset($row[$excelIndex])) {
                    $date = intval($row[$excelIndex]);
                    $employeeData[$dbField] =  \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date)->format('Y-m-d');
                } else {
                    // Assign other values as they are
                    $employeeData[$dbField] = $row[$excelIndex];
                }
            }

            // Get Department ID
            $departmentId = Department::where('acronym', $employeeData['department'])->value('id');

            // // Get Position ID
            $positionId = Position::where('name', $employeeData['position'])->value('id');

            // // Get Employment Status ID
            $employmentStatusId = EmploymentStatus::where('name', $employeeData['employment_status'])->value('id');

            $employee = $employeeData;
            $employee['department_id'] = $departmentId;
            $employee['position_id'] = $positionId;
            $employee['employment_status_id'] = $employmentStatusId;
            $employee['sex'] = strtolower($employee['gender']);
            unset($employee['gender']);
            unset($employee['department']);
            unset($employee['position']);
            unset($employee['employment_status']);
            $employee['schedule_id'] = '47d0f285-1f03-4aa9-b0f1-e8432814b67c';

            if (!empty($employee['last_name']) && !empty($employee['first_name'])) {
                // Create the employee record
                $employee = Employee::create($employee);
            }
        }

        return response()->json(['message' => 'Employees imported successfully'], 200);
    }

    public function importTraining(Request $request)
    {
        // Training::truncate();
        // Validate the request
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        // Retrieve file from request
        $file = $request->file('file');

        // Parse Excel file
        $data = Excel::toArray([], $file);

        // Assuming the first sheet is used and it contains data
        $rows = $data[0];
        unset($rows[0]);
        // Map column headers to database fields
        $columnMap = [
            0 => 'title',
            1 => 'description',
            2 => 'conducted_by',
            3 => 'period_from',
            4 => 'period_to',
            5 => 'hours',
        ];

        // Loop through rows
        foreach ($rows as $row) {
            // Map Excel data to database fields
            $trainingData = [];
            foreach ($columnMap as $excelIndex => $dbField) {
                if (in_array($dbField, ['period_from', 'period_to']) && isset($row[$excelIndex])) {
                    $date = intval($row[$excelIndex]);
                    $trainingData[$dbField] =  \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date)->format('Y-m-d');
                } else {
                    // Assign other values as they are
                    $trainingData[$dbField] = $row[$excelIndex];
                }
            }

            $training = Training::create($trainingData);
        }

        return response()->json(['message' => 'Training imported successfully'], 200);
    }

    public function importAward(Request $request)
    {
        // Award::truncate();
        // Validate the request
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        // Retrieve file from request
        $file = $request->file('file');

        // Parse Excel file
        $data = Excel::toArray([], $file);

        // Assuming the first sheet is used and it contains data
        $rows = $data[0];
        unset($rows[0]);
        // Map column headers to database fields
        $columnMap = [
            0 => 'award_name',
            1 => 'date_awarded',
            2 => 'remarks',
        ];

        // Get all employee IDs
        $employeeIds = Employee::pluck('id')->toArray();

        // Loop through rows
        foreach ($rows as $row) {
            // Map Excel data to database fields
            $awardData = [];
            foreach ($columnMap as $excelIndex => $dbField) {
                if (in_array($dbField, ['date_awarded']) && isset($row[$excelIndex])) {
                    $date = intval($row[$excelIndex]);
                    $awardData[$dbField] =  \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date)->format('Y-m-d');
                } else {
                    // Assign other values as they are
                    $awardData[$dbField] = $row[$excelIndex];
                }
            }

            // Get a random employee ID
            $randomEmployeeId = Arr::random($employeeIds);

            // Assign the random employee ID to the award data
            $awardData['employee_id'] = $randomEmployeeId;

            $award = Award::create($awardData);
        }

        return response()->json(['message' => 'Award imported successfully'], 200);
    }

    public function importLeave(Request $request)
    {
        // Award::truncate();
        // Validate the request
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        // Retrieve file from request
        $file = $request->file('file');

        // Parse Excel file
        $data = Excel::toArray([], $file);

        // Assuming the first sheet is used and it contains data
        $rows = $data[0];
        unset($rows[0]);
        // Map column headers to database fields
        $columnMap = [
            0 => 'employee_id',
            1 => 'leave_type_id',
            2 => 'date_start',
            3 => 'date_end',
            4 => 'credit',
            5 => 'remarks',
            6 => 'details_of_leave',
        ];

        // Loop through rows
        foreach ($rows as $row) {
            $data = [];
            foreach ($columnMap as $excelIndex => $dbField) {
                if (in_array($dbField, ['date_start','date_end']) && isset($row[$excelIndex])) {
                    $date = intval($row[$excelIndex]);
                    $data[$dbField] =  \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date)->format('Y-m-d');
                } else {
                    // Assign other values as they are
                    $data[$dbField] = $row[$excelIndex];
                }
            }
            $employee_name = $data['employee_id'];
            $name_parts = explode(' ', $employee_name);

            // Convert each part to uppercase
            $first_name = strtoupper($name_parts[0]);
            $last_name = strtoupper($name_parts[1]);

        }

        return response()->json(['message' => 'Leave imported successfully'], 200);
    }
}
