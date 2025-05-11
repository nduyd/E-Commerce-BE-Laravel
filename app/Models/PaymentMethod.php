<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    //
    protected $fillable = [
        'user_id',
        'method',
        'is_default',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'method' => 'string',
        'is_default' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(UserCredential::class, 'user_id', 'id');
    }
}
