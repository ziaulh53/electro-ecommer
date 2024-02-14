<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductCreateRequest extends FormRequest
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
            'discountPrice' => 'nullable|numeric|min:0',
            'discountAvailable' => 'boolean',
            'is_variation' => 'required|boolean',
            'quantity' => ['required_if:is_variation,false|integer'],
            'newArrival' => 'boolean',
            'description' => 'nullable|string',
            'brands_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            'colors' => ['required_if:is_variation,true|array'],
            'colors.*.color_id' => 'required|exists:colors,id',
            'colors.*.quantity' => 'required|integer|min:0',
            'colors.*.images' => 'nullable|array',
        ];
    }
}
