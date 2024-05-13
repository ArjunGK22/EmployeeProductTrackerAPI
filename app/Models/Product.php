<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'productname',
        'quantity',
        'price'
    ];

    // public function transactions()
    // {
    //     return $this->hasMany(Transaction::class);
    // }

    public function transaction__products()
    {
        return $this->hasMany(Transaction_Product::class);
    }

     public function transactions()
    {
        return $this->belongsToMany(Transaction::class, 'transaction__products');
    }
}
