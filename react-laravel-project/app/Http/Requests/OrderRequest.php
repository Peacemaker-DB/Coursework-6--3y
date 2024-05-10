<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
class OrderRequest extends FormRequest
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
                'customer_id' => 'required|int|exists:users,id',
                'total' => 'int',
                'status' => 'required|string|min:1|max:999999',
                'payment_type' => 'nullable|string'
            ];
        } else {
            return [
                'customer_id' => 'int|exists:users,id',
                'total' => 'int',
                'status' => 'string|min:1|max:999999',
                'payment_type' => 'nullable|string'
            ];
        }
    }
}
