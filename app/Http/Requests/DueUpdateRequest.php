<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DueUpdateRequest extends FormRequest
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
            'buyer_id' => ['required', 'exists:buyers,id'],
            'product_id' => ['required', 'exists:products,id'],
            'product_code_id' => ['required', 'exists:product_codes,id'],
            'due_amount' => ['required', 'numeric'],
            'user_id' => ['required', 'exists:users,id'],
        ];
    }
}
