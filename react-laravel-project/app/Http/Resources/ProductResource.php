<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'name' => $this->name,
            'description' => strlen($this->description) == 0 ? "Описания нет" : $this->description,
            'stock' => $this->stock,
            'price' => $this->price,
            'image' => $this->image
        ];
    }
}
