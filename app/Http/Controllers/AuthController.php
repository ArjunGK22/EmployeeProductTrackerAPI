<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use GuzzleHttp\Psr7\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{

    public function logout(Request $request){

        $user = $request->user();

        // dd($user);

        // return $user;
        
        if (!$user || !$user->currentAccessToken()) {
            return response()->json(['message' => 'Token not found or invalid'], 401);
        }
    
        $user->currentAccessToken()->delete();
    
        return response()->json(['message' => 'Logged out successfully'], 200);

    }
    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        //
        if ($validator->fails()) {

            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 433);
        }
        else{
            $user = User::where('email',$request->email)->first();

            if (!$user || !Hash::check($request->password,  $user->password)) {
                return response([
                    'message' => ['Invalid Credentials']
                ], 404);
            }

            $token = $user->createToken('api-token')->plainTextToken;
        
            $response = [
                'user' => $user,
                'token' => $token
            ];
        
             return response($response, 201);
        }

    }
}
