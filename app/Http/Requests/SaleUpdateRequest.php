<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleUpdateRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'product_id' => ['required', 'exists:products,id'],
            'product_code_id' => ['required', 'exists:product_codes,id'],
            'buyer_id' => ['required', 'exists:buyers,id'],
            'purchase_price' => ['required', 'numeric'],
            'sale_price' => ['required', 'numeric'],
            'user_id' => ['required', 'exists:users,id'],
            'shop_id' => ['required', 'exists:shops,id'],
        ];
    }
}
