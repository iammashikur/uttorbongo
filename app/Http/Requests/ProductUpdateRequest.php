<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255', 'string'],
            'product_category_id' => [
                'required',
                'exists:product_categories,id',
            ],
            'brand_id' => ['required', 'exists:brands,id'],
            'image' => ['nullable', 'image', 'max:1024'],
            'product_type' => ['required', 'max:255', 'string'],
            'supplier_id' => ['nullable', 'exists:suppliers,id'],
            'seller_id' => ['nullable', 'exists:sellers,id'],
            'purchase_price' => ['required', 'numeric'],
            'price' => ['required', 'numeric'],
            'details' => ['nullable', 'max:255', 'string'],
            'show_on_website' => ['required', 'boolean'],
        ];
    }
}
