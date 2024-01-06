<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DisapproveClientRequest extends FormRequest
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
            'email_verified' => 'required|boolean',
        ];
    }
    
    public function messages(): array
    {
        return [
            'email_verified.required' => 'The email verification field is required.',
            'email_verified.boolean' => 'The email verification field must be a boolean.',
        ];
    }
    
    public function attributes(): array
    {
        return [
            'email_verified' => 'Email Verification',
        ];
    }
}
