<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'slug' => [ 'string', 'min:3', 'max:191' ],
            'title' => [ 'string', 'min:3', 'max:191' ],
            'content' => [ 'string', 'min:3' ],
            'metadata' => [ 'required' ],
        ];
    }
}
