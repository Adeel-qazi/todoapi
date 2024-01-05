<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdateClientRequest extends FormRequest
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
            'password' => ['nullable','confirmed', Password::min(5)],
            'role' => 'nullable|in:client',
            'email_verified' => 'nullable|boolean',
        ];
        
        
    }


    public function messages()
{
    return [
        'name.min' => 'The :attribute field must be at least :min characters',
        'email.email' => 'The :attribute field must be a valid email address',
        'password.confirmed' => 'The :attribute confirmation does not match',
        'password.min' => 'The :attribute field must be at least :min characters',
        'role.in' => 'The selected :attribute is invalid',
        'email_verified.boolean' => 'The :attribute field must be a boolean either true or false',
    ];
}


    public function attributes(): array
    {
        return [
            'name' => 'full name',
            'email' => 'email address',
            'password' => 'password',
            'role' => 'user role',
            'email_verified' => 'email verification status',
        ];
    }
}
