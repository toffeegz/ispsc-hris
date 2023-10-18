<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\UniqueEducationLevelForEmployee;

class EmployeeUpdateEducationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $employeeId = $this->route('employee'); // Get the id of the employee being updated from the request route parameters

        return [
            'educations.*.id' => [ // Check if each education entry has an ID
                'nullable', // It can be null if you're creating a new entry
                Rule::exists('employee_educational_backgrounds', 'id')->where('employee_id', $employeeId),
            ],
            'educations.*.level' => [
                'required_without:educations.*.id', // Level is required if there's no ID
                new UniqueEducationLevelForEmployee($employeeId),
            ],            
            'educations' => ['nullable', 'array'], // Array of educational backgrounds
            'educations.*.school_name' => ['required', 'string'],
            'educations.*.degree' => ['nullable', 'string'],
            'educations.*.period_from' => ['nullable', 'date'],
            'educations.*.period_to' => ['nullable', 'date'],
            'educations.*.units_earned' => ['nullable', 'string'],
            'educations.*.year_graduated' => ['nullable', 'string'],
            'educations.*.academic_honors_received' => ['nullable', 'string'],
        ];
    }
}
