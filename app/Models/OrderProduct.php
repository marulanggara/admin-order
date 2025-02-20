<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderProduct extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'transaction.order_product';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
    ];

    // relasi dengan tabel orders
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    // relasi dengan tabel products
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
