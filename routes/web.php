<?php

use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerificationMiddleware;
use Illuminate\Support\Facades\Route;


//Router for User\\
Route::post('/UserLogin', [UserController::class, 'UserLogin']);
Route::post('/UserRegistration', [UserController::class, 'UserRegistration']);
Route::post('/SendOTPToEmail', [UserController::class, 'SendOTPToEmail']);
Route::post('/OTPVerify', [UserController::class, 'OTPVerify']);

Route::post('/ResetPassword', [UserController::class, ' ResetPassword'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/ProfileUpdate', [UserController::class, 'ProfileUpdate']);
