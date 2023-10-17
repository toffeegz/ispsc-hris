<?php 

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\EducationalBackground;

class UniqueEducationLevelForEmployee implements Rule
{
    protected $employeeId;

    public function __construct($employeeId)
    {
        $this->employeeId = $employeeId;
    }

    public function passes($attribute, $value)
    {
        return !EducationalBackground::where('employee_id', $this->employeeId)
            ->where('level', $value)
            ->exists();
    }

    public function message()
    {
        return 'An education record with the same level already exists for this employee.';
    }
}
