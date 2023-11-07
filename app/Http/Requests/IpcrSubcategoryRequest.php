<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IpcrSubcategoryRequest extends FormRequest
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
        $ipcr_subcategory = $this->route('ipcr_subcategory'); // Get the id of the employee being updated from the request route parameters

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('ipcr_subcategories', 'name')->ignore($ipcr_subcategory),
            ],
            'weight' => ['nullable'],
            'parent_id' => ['nullable', 'uuid'],
        ];
    }
}
