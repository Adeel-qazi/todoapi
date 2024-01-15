<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
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
            'title' => 'nullable|string|min:3',
            'start_time' => 'nullable|date_format:Y-m-d',
            'end_time' => 'nullable|date_format:Y-m-d|after:start_time',
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
            'client_id.integer' => 'The :attribute must be an integer.',
            'title.string' => 'The :attribute must be a string.',
            'title.min' => 'The :attribute must be at least :min characters.',
            'start_time.date_format' => 'The :attribute must be in the format Y-m-d.',
            'end_time.date_format' => 'The :attribute must be in the format Y-m-d.',
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
