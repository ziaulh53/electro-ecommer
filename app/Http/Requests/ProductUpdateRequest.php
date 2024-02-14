<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductUpdateRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'discountPrice' => 'nullable|numeric|min:0|lte:price',
            'discountAvailable' => 'required|boolean',
            'default_images' => 'array',
            'is_variation' => 'required|boolean',
            'quantity' => 'integer',
            'newArrival' => 'nullable|boolean',
            'description' => 'required|string',
            'brands_id' => [
                'required',
                'integer',
                Rule::exists('brands', 'id'), // Ensure brand ID exists
            ],
            'category_id' => [
                'required',
                'integer',
                Rule::exists('categories', 'id'),
            ],

            // Colors:
            'colors' => ['required_if:is_variation,true|array'],
            'colors.*.color_id' => [
                'required_if:colors.*.quantity,>0',
                'nullable',
                'integer',
                Rule::exists('colors', 'id'),
            ],
            'colors.*.quantity' => 'required_with:colors.*.color_id|integer|min:0',
            'colors.*.images' => 'nullable|array',
            'colors.*.images.*' => 'url|max:255',
        ];
    }
}
