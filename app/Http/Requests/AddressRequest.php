<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'apartment' => 'nullable|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'zipCode' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255'
        ];
    }
}
