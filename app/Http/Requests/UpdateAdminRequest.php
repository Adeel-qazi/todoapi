<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdateAdminRequest extends FormRequest
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
            'name' => 'nullable|string|min:3',
            'email' => 'nullable|email',
            'password' => ['nullable', Password::min(5)],
         ];
    }


    public function messages()
    {
        return [
            'name.min' => 'The :attribute must be at least :min characters long',
            'email.email' => 'The :attribute must be a valid email address',
            'password.min' => 'The :attribute must be at least :min characters long',
        ];

    }


    public function attributes(): array
    {
        return [
            'name' => 'Admin Name',
            'email' => 'Email address',
            'password' => 'Password',
        ];
    }
}
