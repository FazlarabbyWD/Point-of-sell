<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Mail\OTPMail;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Mail;
use Mockery\Expectation;

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
    function SendOTPToEmail(Request $request)
    {
        $email = $request->input('email');
        $otp = rand(1000, 9999);

        $count = User::where('email', '=', $email)->count();
        if ($count == 1) {
            Mail::to($email)->send(new OTPMail($otp));

            User::where('email', '=', $email)->update(['otp' => $otp]);
            return response()->json([
                'status' => 'Success',
                'message' => 'OTP Code Send'

            ]);
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Unauthorized'

            ]);
        }
    }
    function OTPVerify(Request $request)
    {
        $email = $request->input('email');
        $otp = $request->input('otp');
        $count = User::where('email', '=', $email)
            ->where('otp', '=', $otp)->count();

        if ($count == 1) {

            User::where('email', '=', $email)->update(['otp' => '0']);

            $token = JWTToken::CreateTokenForSetPassword($request->input('email'));
            return response()->json([
                'status' => 'Authorized',
                'message' => 'OTP Verify Successfull',
                'token' => $token
            ]);
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Unauthorized'

            ]);
        }
    }
    function ResetPassword(Request $request)
    {
        try {
            $email = $request->header('email');
            $password = $request->input('password');

            User::where('email', '=', $email)->update(['password' => $password]);
            return response()->json([
                'status' => 'Success',
                'message' => 'Request Successfull'

            ]);
        } catch (Expectation $e) {

            return response()->json([
                'status' => 'Failed',
                'message' => 'Something went Wrong',
            ]);
        }
    }
    function ProfileUpdate()
    {
    }
}
