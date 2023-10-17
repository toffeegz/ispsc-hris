<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Services\Validator\DatFileValidator;

class AttendanceDatRequest extends FormRequest
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
            'file' => 'required|file|mimes:dat|max:2048',
            'file' => function ($attribute, $value, $fail) {
                $validator = new DatFileValidator();
                if (!$validator->validateContents($value)) {
                    $fail('Invalid .dat file contents.');
                }
            },
        ];
    }
}
