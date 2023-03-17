<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * 
     * @author Nderi Kamau <nderikamau1212@gmail.com>
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     * @author Nderi Kamau <nderikamau1212@gmail.com>
     */
    public function rules(): array
    {
        return [
            'title' => [ 'string', 'min:3', 'max:191' ],
            'price' => [ 'numeric', 'min:0' ],
            'description' => [ 'string', 'min:3' ],
            'metadata' => [ 'string', 'min:3' ],
        ];
    }
}
