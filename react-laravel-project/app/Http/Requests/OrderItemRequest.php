<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderItemRequest extends FormRequest
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
                'order_id' => 'required|int|exists:orders,id',
                'product_id' => 'required|int|exists:products,id',
                'item_quantity' => 'required|int|min:1|max:999999'
            ];
        } else {
            return [
                'order_id' => 'int|exists:orders,id',
                'product_id' => 'int|exists:products,id',
                'item_quantity' => 'int|min:1|max:999999'
            ];
        }
    }
}
