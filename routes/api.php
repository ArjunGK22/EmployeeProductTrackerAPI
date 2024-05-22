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
use App\Http\Controllers\EmployeeProfileController;
use App\Http\Controllers\ProdTransExportController;

Route::get('/auth/login', [UserController::class, 'index']);
Route::post('/auth/login', [AuthController::class, 'login']); 
Route::get('/unauthorized', [UserController::class, 'index']);


Route::group(['middleware' => 'auth:sanctum'], function () {
    
    //Logout Route
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    /*
    ------------------
    Only Admin Access
    -----------------
    */
    Route::group(['middleware' => ['role:admin']], function () {
        
        //Generate PDF based on Transactions
        
        //Product Management Endpoints (Admin)
        Route::apiResource('products', ProductController::class);

        //Transaction (Product Issue/Return) Endpoints
        Route::post('/transactions/issue', [ProductIssueReturnController::class, 'issueProducts']); //store new product
        Route::post('/transactions/return', [ProductIssueReturnController::class, 'returnProducts']); //return product
        Route::get('/transactions', [TransactionController::class, 'index']); //show all transactions 

        /* Employee */
        Route::apiResource('employee', EmployeeController::class);

        //Employee Import Controller
        Route::post('/employees/import', [EmployeeController::class, 'import']);
        Route::post('/products/import', [ProductController::class, 'import']);



        Route::post('/products/bulk', [ProductController::class, 'storeBulk']);
        Route::post('/employees/bulk', [EmployeeController::class, 'storeBulk']);

    });
    
    Route::group(['middleware' => ['role:employee']], function () {
        
        Route::get('/profile', [EmployeeProfileController::class, 'profile']);
        Route::get('/profile/transactions', [EmployeeProfileController::class, 'profile']);
        
        
    });
    
});


//pdf generation
Route::get('/generatePdf/{id}', [PDFGenerationController::class, 'generatePDF']);


//excel generation
Route::get('/employees/export', [EmployeeExportController::class, 'export']);
Route::get('/export/transactions', [ProdTransExportController::class,'exportTransactions']);
Route::get('/export/products', [ProdTransExportController::class,'exportProducts']);
