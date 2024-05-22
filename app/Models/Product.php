<?php

namespace App\Models;

use App\Models\Transaction;
use App\Models\Transaction_Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use SoftDeletes, HasFactory;

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
