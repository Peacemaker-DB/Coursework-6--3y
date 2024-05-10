<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = "orders";
    protected $primaryKey = "id";
    protected $fillable = [
        'id',
        'customer_id',
        'total',
        'status',
        'payment_type'
    ];
}
