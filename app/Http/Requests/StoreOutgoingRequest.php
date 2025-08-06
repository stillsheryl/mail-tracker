<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOutgoingRequest extends FormRequest
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
            'username' => 'required|string|max:150',
            'name' => 'nullable|string|max:150',
            'date' => 'required|date',
            'country' => 'required|string|max:150',
            'region' => 'nullable|string|max:150',
            'city' => 'nullable|string|max:150',
            'thanked' => 'nullable|boolean',
            'has_been_sent' => 'nullable|boolean',
            'occasion' => 'nullable|string|max:350',
            'description' => 'nullable|string|max:1500',
            'link' => 'nullable|url|max:400',
        ];
    }

    /**
     * Get custom error messages for validation rules
     *
     * @return array<string, string>
     */
    public function messages(): array{
        return [
            'username.required' => 'The username field is required.',
            'date.required' => 'The date field is required.',
            'country.required' => 'The country field is required.',
        ];
    }
}
