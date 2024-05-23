<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeProfileController extends Controller
{
    //
    public function profile(Request $request){

        $profile = $request->user();

        return $profile;

    }

    public function return_transactions(){

        
        $user_transactions = Employee::with('transactions')->first(1);
    }
}
