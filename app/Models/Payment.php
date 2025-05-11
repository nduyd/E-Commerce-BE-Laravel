<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //
    protected $fillable = [
        'order_id',
        'payment_method',
        'transaction_status',
        'bank_name',
        'account_number',
        'account_holder',
        'transfer_amount',
        'transfer_date',
        'transaction_reference',
        'proof_image_url',
        'cod_collected_amount',
        'cod_collected_date',
        'cod_collected_by',
        'notes'
    ];

    protected $casts = [
        'transfer_amount' => 'decimal:2',
        'transfer_date' => 'datetime',
        'cod_collected_amount' => 'decimal:2',
        'cod_collected_date' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function getPaymentMethodNameAttribute()
    {
        return $this->payment_method === 'bank_transfer' ? 'Chuyển khoản' : 'COD';
    }
}
