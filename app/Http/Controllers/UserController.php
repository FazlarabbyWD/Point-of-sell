<?php

namespace App\Http\Controllers;

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
    function UserLogin()
    {
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
