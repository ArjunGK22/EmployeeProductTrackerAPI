<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employees';
    protected $fillable = [
        'name', 
        'email', 
        'password', 
        'phone', 
        'date_of_birth', 
        'role',
    ];
    protected $guarded = [];

    public function transactions(){

        return $this->hasMany(Transaction::class);

    }
    
}