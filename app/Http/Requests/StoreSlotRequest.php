<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSlotRequest extends FormRequest
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
            'team_id' => 'nullable|integer',
            'event_id' => 'nullable|integer',
            'date' => 'required|date',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'team_id.nullable' => 'The :attribute must be nullable and an integer.',
            'team_id.integer' => 'The :attribute must be an integer.',
            'event_id.nullable' => 'The :attribute must be nullable and an integer.',
            'event_id.integer' => 'The :attribute must be an integer.',
            'date.required' => 'The :attribute field is required.',
            'date.date' => 'The :attribute must be a valid date.',
        ];
    }


    
}
