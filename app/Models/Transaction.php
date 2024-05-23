<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'issue_return_transactions';

    //doubt
    public function user()
    {
        return $this->belongsTo(Employee::class);
    }

    // Define the many-to-many relationship with Product through TransactionProduct
    public function products()
    {
        return $this->belongsToMany(Product::class, 'transaction__products')->withPivot('quantity', 'total_price');
    }
}
