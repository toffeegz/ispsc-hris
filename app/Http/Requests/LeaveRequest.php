<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeaveRequest extends FormRequest
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
            'employee_id' => 'required|uuid|exists:employees,id',
            'date_filed' => 'required|date',
            'date_start' => 'required|date',
            'date_end' => 'required|date|after_or_equal:date_start',
            'time_start' => 'nullable|string',
            'time_end' => 'nullable|string',
            'leave_type_id' => 'required|uuid|exists:leave_types,id',
            'status' => 'required|in:0,1',
            'remarks' => 'required',
            'details_of_leave' => 'required|string',
            'disapproved_for' => 'nullable|string',
            'approved_for' => 'nullable|string',
            'approved_for_type' => 'nullable|in:1,2,3',
            'commutation' => 'boolean',
        ];
    }
}
