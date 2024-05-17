<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductIssueReturnController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PDFGenerationController;
use App\Http\Controllers\TransactionController;

use App\Http\Controllers\EmployeeExportController;
use App\Http\Controllers\ProdTransExportController;

Route::get('/auth/login', [UserController::class, 'index']);
Route::post('/auth/login', [AuthController::class, 'login']); //User Login
Route::post('/auth/logout', [AuthController::class, 'logout']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    
    //Only Admin Access
    Route::group(['middleware' => ['role:admin']], function () {
        
        //Generate PDF based on Transactions
        Route::get('/', [PDFGenerationController::class, 'generatePDF']);
        
        //Product Management Endpoints (Admin)
        Route::resource('products', ProductController::class);

        //Transaction (Product Issue/Return) Endpoints (Admin)
        Route::post('/transactions/issue', [ProductIssueReturnController::class, 'issueProducts']); //store new product
        Route::post('/transactions/return', [ProductIssueReturnController::class, 'returnProducts']); //return product

        Route::get('/transactions', [TransactionController::class, 'index']); //show all transactions 


        
        
    });


});
Route::resource('products', ProductController::class);
Route::resource('employee', EmployeeController::class);

//excel
Route::get('/employees/export', [EmployeeExportController::class, 'export']);
Route::get('/export/transactions', [ProdTransExportController::class,'exportTransactions']);
Route::get('/export/products', [ProdTransExportController::class,'exportProducts']);



/* Employee
Route::get('/employee', [EmployeeController::class, 'index']);
        Route::post('/employee', [EmployeeController::class, 'store']);
        Route::get('/employee/{employee}', [EmployeeController::class, 'show']);
        Route::put('/employee/{employee}', [EmployeeController::class, 'update']);
        Route::delete('/employee/{employee}', [EmployeeController::class, 'destroy']);
 */