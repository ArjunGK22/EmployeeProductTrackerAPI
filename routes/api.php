<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;


Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::get('/auth/login', [UserController::class, 'index']);
});


/* Employee */
Route::get('/employee', [EmployeeController::class, 'index']);
Route::post('/employee', [EmployeeController::class, 'store']);
Route::get('/employee/{employee}', [EmployeeController::class, 'show']);
Route::put('/employee/{employee}', [EmployeeController::class, 'update']);
Route::delete('/employee/{employee}', [EmployeeController::class, 'destroy']);
Route::post('/auth/login', [AuthController::class, 'login']);
