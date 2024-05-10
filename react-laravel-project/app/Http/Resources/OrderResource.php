<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'customer_id' => User::where('id', $this->customer_id)->first()->id,
            'total' => $this->total ?? 0,
            'status' => $this->status,
            'payment_type' => strlen($this->payment_type) == 0 ? "Описания нет" : $this->payment_type
        ];
    }
}
