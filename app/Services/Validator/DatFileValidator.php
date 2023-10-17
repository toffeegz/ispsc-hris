<?php

namespace App\Services\Validator;

use App\Models\Employee;
use Illuminate\Support\Facades\Validator;

class DatFileValidator
{
    public function validateContents($file)
    {
        $contents = file_get_contents($file->getRealPath());
        $lines = explode("\n", $contents);

        foreach ($lines as $line) {
            $data = explode("\t", $line); 

            // If the file doesn't have the expected number of columns, you can skip validation for that line
            if (count($data) < 2) {
                continue;
            }

            // Validate the 1st column (employee_id) as existing in the "employees" table
            // $employeeId = $data[0];
            // if (!Employee::where('employee_id', $employeeId)->exists()) {
            //     return false; // Fail validation if employee_id doesn't exist
            // }

            // Validate the 2nd column as a datetime
            $datetime = $data[1];
            if (!\DateTime::createFromFormat('Y-m-d H:i:s', $datetime)) {
                return false; // Fail validation if datetime is not in the correct format
            }
        }

        return true; // Passes validation if all data is valid
    }
}
