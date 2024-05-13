<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::get('/auth/login', [UserController::class, 'index']);
});

Route::post('/auth/login', [AuthController::class, 'login']);

//Product Management Endpoints (Admin)

Route::resource('products', ProductController::class);

// Route::post('/products', [ProductController::class, 'store']); //store new product
// Route::post('/products/{id}', [ProductController::class, 'store']); //update product
// Route::post('/products/{id}', [ProductController::class, 'store']); //update product

