<?php

namespace MerakiShop\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
     * @return array<string, array<string>>
     */
    public function rules(): array
    {
        return [
            'status' => ['required', 'string', 'in:pending,processing,completed,cancelled'],
            'payment_method' => ['required', 'string'],
            'product_id' => ['required'],
            'unit_price' => ['required', 'numeric', 'min:0'],
        ];
    }
}
