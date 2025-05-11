<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //
    protected $fillable = [
        'order_id',
        'payment_method_id',
        'amount',
        'paid_date',
        'status',
        'transaction_ref',
        // 'metadata',
    ];
    protected $casts = [
        'amount'=>'float',
        'paid_date'=>'datetime',
        'status'=>'string',
        'transaction_ref'=>'string',
        // 'metadata'=>'json',
    ];
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id', 'id');
    }
}
