<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Order;
use App\Models\Product;
class OrderItemResource extends JsonResource
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
            'order_id' => Order::where('id', $this->order_id)->first()->id,
            'product_id' => Product::where('id', $this->product_id)->first()->id,
            'item_quantity' => $this->item_quantity,
            'price' => $this->price
        ];
    }
}
