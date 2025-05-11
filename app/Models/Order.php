<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\UserCredential;
use App\Models\OrderDetails;
use App\Models\Shipping;
use App\Models\Payment;

class Order extends Model
{
    //
    use HasFactory;
    protected $fillable=[
        'user_id',
        'total_amount',
        'shipping_address',
        'status',
        'tracking_number',
        'notes'
    ];
    
    protected $casts = [
        'total_amount' => 'decimal:2',
        'order_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(UseCredential::class, 'user_id', 'id');
    }
    public function details()
    {
        return $this->hasMany(OrderDetails::class, 'order_id', 'id');
    }
    public function payment()
    {
        return $this->hasOne(Payment::class, 'order_id', 'id');
    }
    protected static function boot()
    {
        parent::boot();
        static::creating(function($order){
            $order->onChange();
        });
        static::updating(function($order){
            $order->onChange();
        });
        static::deleting(function($order){
            $order->onChange();
        });
    }
    protected function onChange()
    {
        
    }
}
