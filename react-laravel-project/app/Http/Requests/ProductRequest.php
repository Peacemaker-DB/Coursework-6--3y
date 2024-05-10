<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        if (request()->isMethod('post')) {
            return [
                'name' => 'required|string|max:50',
                'description' => 'string|max:1000',
                'price' => 'required|int|min:0|max:9999999',
                'stock' => 'required|int|min:0|max:999999',
            ];
        } else {
            return [
                'name' => 'string|max:50',
                'description' => 'string|max:1000',
                'price' => 'int|min:0|max:9999999',
                'stock' => 'int|min:0|max:999999'
            ];
        }
    }
}
