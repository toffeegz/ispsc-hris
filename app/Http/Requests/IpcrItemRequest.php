<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IpcrItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:ipcr_categories,id', // Make sure the category_id exists in the ipcr_categories table.
            'name' => 'required|string|max:255', // Validate the name as a string with a maximum length of 255 characters.
            'weight' => 'required|numeric|between:0,100', // Ensure the weight is a numeric value between 0 and 100.
        ];
    }
}
