<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => [ 'required' ],
            'amount' => [ 'required', 'numeric', 'min:0' ],
            'delivery_fee' => [ 'nullable', 'numeric', 'min:0' ],
            'order_status_id' => [ 'required' ],
            'products' => [ 'required', 'json' ],
            'address' => [ 'json' ],
            'metadata' => [ 'string', 'min:3' ],
        ];
    }
}
