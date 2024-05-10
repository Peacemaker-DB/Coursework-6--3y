<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = "orderitems";
    protected $primaryKey = "id";
    protected $fillable = [
        'id',
        'order_id',
        'product_id',
        'item_quantity',
        'price',
    ];
}
