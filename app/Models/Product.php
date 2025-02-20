<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'master_tables.products';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'code',
        'description',
        'selling_price',
    ];

    // relasi dengan tabel order_product
    public function orderProduct()
    {
        return $this->hasMany(OrderProduct::class, 'product_id');
    }
}
