<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Route;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        $user_id = $this->route('user'); // Get the id of the employee being updated from the request route parameters

        $email_rules = [
            'required',
            'max:255',
            'email',
            Rule::unique('users')->ignore($user_id),
        ];
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => $email_rules
        ];
    }
}
