<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
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
            'client_id' => 'nullable|integer',
            'title' => 'required|string|min:3',
            'start_time' => 'required|date_format:H:i:s',
            'end_time' => 'required|date_format:H:i:s|after:start_time',
            'zoom_link' => 'nullable|url',
            
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
            'client_id.required' => 'The :attribute field is required.',
            'client_id.integer' => 'The :attribute must be an integer.',
            'title.required' => 'The :attribute field is required.',
            'title.string' => 'The :attribute must be a string.',
            'title.min' => 'The :attribute must be at least :min characters.',
            'start_time.required' => 'The :attribute field is required.',
            'start_time.date_format' => 'The :attribute must be in the format.',
            'end_time.required' => 'The :attribute field is required.',
            'end_time.date_format' => 'The :attribute must be in the format.',
            'end_time.after' => 'The :attribute must be after the start time.',
            'zoom_link.url' => 'The :attribute must be a valid URL.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'title' => 'event title',
            'start_time' => 'event start time',
            'end_time' => 'event end time',
            'zoom_link' => 'Zoom Link',
        ];
    }
}
