<?php

namespace MerakiShop\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // The name of the product
            'name' => ['required', 'min:4', 'max:150'],
            'price' => ['required', 'integer', 'min:0'],
            'cost_price' => ['nullable', 'integer', 'min:0'],
            'stock' => ['nullable', 'integer', 'min:0'],
            'thumbnail' => ['required', 'string', 'min:5'],
            'images' => ['nullable', 'string'],
            'short_description' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'rating' => ['required', 'integer', 'min:1', 'max:5', 'max_digits:1'],
            'sku' => ['nullable', 'string', 'max:50'],
        ];
    }
}
