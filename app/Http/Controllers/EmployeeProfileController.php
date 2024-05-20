<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeProfileController extends Controller
{
    //
    public function profile(Request $request){

        $profile = $request->user();

        return $profile;

    }
}
