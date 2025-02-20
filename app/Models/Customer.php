<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'master_tables.customers';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'no_customer',
        'name',
        'email',
        'phone',
        'address',
    ];
}
