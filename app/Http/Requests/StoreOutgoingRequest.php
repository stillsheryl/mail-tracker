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
            // 'user_id' => ,
            'username' => 'required|string|max:150',
            'name' => 'string|max:150',
            'date' => 'required|string|max:150',
            'country' => 'required|string|max:150',
            'region' => 'string|max:150',
            'city' => 'string|max:150',
            'thanked' => 'boolean', // will need to default to false
            'has_been_sent' => 'boolean', // will need to default to false
            'occasion' => 'string|max:350',
            'description' => 'string|max:1500',
            'link' => 'url|max:400',
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
