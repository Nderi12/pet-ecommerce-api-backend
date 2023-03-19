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

    public function messages()
    {
        return [
            'title.required' => 'Please enter a title for your product.',
            'price.required' => 'Please enter a price for your product.',
            'price.numeric' => 'The price must be a numeric value.',
            'description.required' => 'Please enter a description for your product.',
            'category_uuid.required' => 'Please select a category for your product.',
            'metadata.json' => 'The metadata field must be a valid JSON string.',
        ];
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
            'title' => ['required', 'string', 'min:3', 'max:191' ],
            'price' => [ 'required', 'numeric', 'min:0' ],
            'description' => [ 'required', 'string', 'min:3' ],
            'category_uuid' => [ 'required', 'string', 'min:3' ],
            'metadata' => [ 'required' ],
        ];
    }
}
