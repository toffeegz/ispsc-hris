<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\User;

class ForgotPasswordRequest extends FormRequest
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
            'email' => ['required', 'max:255', Rule::exists(User::class, 'email')->where(function ($query) {
                $query->whereNull('deleted_at');;
            })],
        ];
    }

    public function messages()
    {
        return [
            'email.exists' => 'We could not find an account associated with that email address. Please check your email and try again.',
        ];
    }
}
