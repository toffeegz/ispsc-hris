<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeStoreRequest extends FormRequest
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
        return [
            'employee_id' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'name_ext' => ['nullable', 'string', 'max:255'],
            'birth_date' => ['nullable', 'date'],
            'birth_place' => ['nullable', 'string', 'max:255'],
            'sex' => ['nullable', 'in:male,female'],
            'civil_status' => ['nullable', 'in:single,widowed,married,separated'],
            'citizenship' => ['nullable', 'string', 'max:100'],
            'email' => ['nullable', 'email', 'unique:employees,email'],
            'tel_no' => ['nullable', 'string', 'max:255'],
            'mobile_no' => ['nullable', 'string', 'max:255'],
            'date_hired' => ['nullable', 'date'],
            'department_id' => ['nullable', 'exists:departments,id'],
            'position_id' => ['nullable', 'exists:positions,id'],

            'educational_backgrounds' => ['nullable', 'array'], // Array of educational backgrounds
            'educational_backgrounds.*.level' => ['required', 'string'], // Validation for each level in the array
            'educational_backgrounds.*.school_name' => ['required', 'string'],
            'educational_backgrounds.*.degree' => ['nullable', 'string'],
            'educational_backgrounds.*.period_from' => ['nullable', 'date'],
            'educational_backgrounds.*.period_to' => ['nullable', 'date'],
            'educational_backgrounds.*.units_earned' => ['nullable', 'string'],
            'educational_backgrounds.*.year_graduated' => ['nullable', 'string'],
            'educational_backgrounds.*.academic_honors_received' => ['nullable', 'string'],

            'trainings' => ['nullable', 'array'], // Array of training records
            'trainings.*.title' => ['required', 'string'], // Validation for each title in the array
            'trainings.*.description' => ['nullable', 'string'],
            'trainings.*.conducted_by' => ['nullable', 'string'],
            'trainings.*.period_from' => ['nullable', 'date'],
            'trainings.*.period_to' => ['nullable', 'date'],
            'trainings.*.hours' => ['nullable', 'integer', 'min:1', 'max:14600'], // Assuming hours can range from 1 to 14600 (1 year)
            'trainings.*.type_of_ld' => ['nullable', 'string'],
        ];
    }
}
