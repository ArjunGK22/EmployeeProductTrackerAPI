<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Authenticatable
{
    use SoftDeletes, HasFactory, HasApiTokens, HasFactory;


    protected $fillable = [
        'name', 
        'email', 
        'password', 
        'phone', 
        'date_of_birth', 
        'role',
    ];

    protected $table = 'employees';


    public function transactions(){

        return $this->hasMany(Transaction::class);

    }
}