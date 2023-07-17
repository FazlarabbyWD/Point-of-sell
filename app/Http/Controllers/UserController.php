<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;

class UserController extends Controller
{

    function UserRegistration(Request $request)
    {
        try {
            User::create([
                'firstName' => $request->input('firstName'),
                'lastName' => $request->input('lastName'),
                'email' => $request->input('email'),
                'mobile' => $request->input('mobile'),
                'password' => $request->input('password')
            ]);
            return response()->json([
                'status' => 1,
                'message' => 'Registration Successfull'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'User Registration Failed'
                //'message'=>$e->getMessage()
            ], 400);
        }
    }
    function UserLogin(Request $request)
    {
        $count = User::where('email', '=', $request->input('email'))
            ->where('password', '=', $request->input('password'))
            ->count();

        if ($count === 1) {
            //User Login->JWT Token Issue
            $token = JWTToken::CreateToken($request->input('email'));
            return response()->json([
                'status' => 'Authorized',
                'message' => 'User Login Successfull',
                'token' => $token
            ]);
        } else {
            return response()->json([
                'status' => 'unauthorized',
                'message' => 'User Login Failed'
            ]);
        }
    }
    function SendOTPToEmail()
    {
    }
    function OTPVerify()
    {
    }
    function SetPassword()
    {
    }
    function ProfileUpdate()
    {
    }
}
