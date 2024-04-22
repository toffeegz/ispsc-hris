<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeaveBalanceRequest extends FormRequest
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
        $id = $this->route('leave_balance'); 
        return [
            'employee_id' => ['required', 'exists:employees,id'],
            'remaining_vl' => ['required', 'numeric', 'min:0'], // Assuming this represents a numeric value and cannot be negative
            'remaining_sl' => ['required', 'numeric', 'min:0'], // Assuming this represents a numeric value and cannot be negative
            'year' => ['required', 'date_format:Y'], // Assuming the year format is YYYY
        ];
    }
}
