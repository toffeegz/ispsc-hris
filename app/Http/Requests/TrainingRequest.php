<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrainingRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'conducted_by' => 'nullable|string|max:255',
            'period_from' => 'nullable|date',
            'period_to' => 'nullable|date|after_or_equal:period_from',
            'hours' => 'nullable|integer|min:1|max:14600', // Assuming hours can range from 1 to 40
            'type_of_ld' => 'nullable|string|max:255',
        ];
    }
}
