<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeeTrainingUpdateRequest extends FormRequest
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
            'trainings.*.id' => [ // Check if each education entry has an ID
                'nullable', // It can be null if you're creating a new entry
                Rule::exists('employee_trainings', 'id')->where('employee_id', $employeeId),
            ],
            'trainings' => ['nullable', 'array'], // Array of training records
            'trainings.*.title' => [
                'required',
                'string',
                Rule::unique('employee_trainings', 'title')->where('employee_id', $employeeId),
            ], // Validation for each title in the array
            'trainings.*.description' => ['nullable', 'string'],
            'trainings.*.conducted_by' => ['nullable', 'string'],
            'trainings.*.period_from' => ['nullable', 'date'],
            'trainings.*.period_to' => ['nullable', 'date'],
            'trainings.*.hours' => ['nullable', 'integer', 'min:1', 'max:14600'], // Assuming hours can range from 1 to 14600 (1 year)
            'trainings.*.type_of_ld' => ['nullable', 'string'],
        ];
    }
}
