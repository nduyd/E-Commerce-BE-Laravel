<?php

namespace App\Models;
use App\Models\UserCredential;
use App\Models\ProductDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use Hasfactory;
    protected $fillable =[
        'name',
        'price',
        'stock',
        'status',
        'brand_id',
    ];
    protected $casts = [
        'price' => 'decimal:2',
        'discount' => 'decimal:2',
        'stock' => 'integer',
        'status' => 'boolean',
    ];

    protected $appends = ['details'];

    public function getDetailsAttribute()
    {
        return ProductDetail::where('product_id', $this->id)->first();
    }

    public function details()
    {
        return $this->hasOne(ProductDetail::class, 'product_id', 'id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'product_id', 'id');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id', 'id');
    }
    public function promotions()
    {
        return $this->belongsToMany(Promotion::class, 'product_id', 'id');
    }
    public function getFinnalPriceAttribute()
    {
        return $this->price - ($this->price * $this->discount / 100);
    }
}
