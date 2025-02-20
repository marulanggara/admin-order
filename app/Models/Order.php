<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'transaction.orders';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'order_id',
        'customer_id',
        'order_date',
    ];

    // relasi dengan tabel customers
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    // relasi dengan tabel order_products
    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class, 'order_id', 'id');
    }
}
