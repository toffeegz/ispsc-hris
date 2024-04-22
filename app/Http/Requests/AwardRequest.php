<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AwardRequest extends FormRequest
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
        $id = $this->route('award'); 
        return [
            'employee_id' => ['required','exists:employees,id'],
            'award_name' => ['required', 'string', 'max:255'],
            'remarks' => ['nullable', 'string', 'max:255'],
            'date_awarded' => ['required', 'date'],
        ];
    }
}
