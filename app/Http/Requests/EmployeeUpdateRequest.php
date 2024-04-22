<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeUpdateRequest extends FormRequest
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
        $employee_id = $this->route('employee'); // Get the id of the employee being updated from the request route parameters

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
            'email' => ['nullable', 'email', 'unique:employees,email,' . $employee_id], // Assuming you want to ignore the current employee's email when updating
            'tel_no' => ['nullable', 'string', 'max:255'],
            'mobile_no' => ['nullable', 'string', 'max:255'],
            'date_hired' => ['nullable', 'date'],
            'department_id' => ['nullable', 'exists:departments,id'],
            'position_id' => ['nullable', 'exists:positions,id'],
            'employment_status_id' => ['nullable', 'exists:employment_statuses,id'],
            'is_flexible' => ['required', 'boolean'],
        ];
    }
}
