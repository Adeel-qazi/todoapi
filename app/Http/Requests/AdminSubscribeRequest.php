<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminSubscribeRequest extends FormRequest
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
            'plan_name' => 'required|string|min:3',
            'price' => 'required|numeric',
            'start_date' => 'required|date',
            'close_date' => 'required|date',
            'admin_id'
        ];
    }

    public function messages(): array
    {
        return [
            'plan_name.required' => 'The :attribute field is required.',
            'plan_name.string' => 'The :attribute field must be a string.',
            'plan_name.min' => 'The :attribute field must be at least :min characters.',
            
            'price.required' => 'The :attribute field is required.',
            'price.numeric' => 'The :attribute must be a numeric value.',
            
            'start_date.required' => 'The :attribute field is required.',
            'start_date.date' => 'The :attribute date must be a valid date.',
            
            'close_date.required' => 'The :attribute field is required.',
            'close_date.date' => 'The :attribute must be a valid date.',
        ];
    }

    public function attributes(): array
    {
        return [
            'plan_name' => 'Plan Name',
            'price' => 'Price',
            'start_date' => 'Start Date',
            'close_date' => 'Close Date',
        ];
    }



}
