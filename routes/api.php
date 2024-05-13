<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductIssueReturnController;
use App\Http\Controllers\UserController;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;


Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::get('/auth/login', [UserController::class, 'index']);
});

Route::post('/auth/login', [AuthController::class, 'login']);

//Product Management Endpoints (Admin)

Route::resource('products', ProductController::class);

Route::post('/transactions/issue', [ProductIssueReturnController::class, 'issue']); //store new product
Route::get('/transactions/issues', [ProductIssueReturnController::class, 'index']); //store new product



/* Employee */
Route::get('/employee', [EmployeeController::class, 'index']);
Route::post('/employee', [EmployeeController::class, 'store']);
Route::get('/employee/{employee}', [EmployeeController::class, 'show']);
Route::put('/employee/{employee}', [EmployeeController::class, 'update']);
Route::delete('/employee/{employee}', [EmployeeController::class, 'destroy']);