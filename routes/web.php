<?php

use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerificationMidleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function(){
    return view('email.OTPMail');
    // return view('welcome');
    

});

Route::controller(UserController::class)->group(function(){
    
 Route::post('/user-register','UserRegister');
 Route::post('/user-login','UserLogin');
 Route::post('/sent-otp','SentOTPCode');
 Route::post('/verify-otp','VerifyOTP');
 //Token verify korte hobe
 Route::post('/reset-password','ResetPassword')->middleware(TokenVerificationMidleware::class);
    

});