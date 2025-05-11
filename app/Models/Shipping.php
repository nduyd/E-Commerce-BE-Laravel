<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    protected $fillable = [
        'order_id',
        'carrier',
        'method',
        'ship_date',
        'delivery_date',
        'shipping_fee',
        'shipping_address',
        'phone',
        'status',
    ];

    protected $casts = [
        'carrier' => 'string',
        'method' => 'string',
        'ship_date' => 'datetime',
        'delivery_date' => 'datetime',
        'shipping_fee' => 'float',
        'shipping_address' => 'string',
        'phone' => 'string',
        'status' => 'string',
    ];
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
}
