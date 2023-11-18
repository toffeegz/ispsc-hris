<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['nullable'],
            'current_password' => ['required_with:password', 'nullable', ' min:8', ' max:255'],
            'password' => ['nullable', 'required_with:current_password', ' min:8', ' max:255', 'confirmed'],
        ];
    }
}
