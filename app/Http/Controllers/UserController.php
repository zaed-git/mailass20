<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Mail\OTPMail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller{

   
 function UserRegister(Request $request){
   //ek sathe oo kora zay
    //return   User::create($request->input());

     //or

   //ekta ekta kore dhore deya zay 
    try{
     User::create([
       
        'firstName' => $request->input('firstName'),
         'lastName' => $request->input('lastName'),
         'email' => $request->input('email'),
         'mobile' => $request->input('mobile'),
         'password' => $request->input('password')
  
     ]);

     return response()->json([
       'status' => 'success',
       'message' => 'User registered successfully'
     ], 200);

   }
   catch(Exception $e){

    return response()->json([
      'status' => 'error',
      'message' => 'User registered successfully',
     // 'message' => $e->getMessage()
     ], 500);
   }

   }
   

   function UserLogin(Request $request){

     $count=User::where('email','=',$request->input('email'))
          ->where('password','=',$request->input('password'))
          ->count();

          if($count==1){
            //user login -> JWT Token issue
            $token = JWTToken::CreateToken($request->input('email'));
            return response()->json([
              'status' => 'success',
              'message' => 'User login successfully',
              'token' => $token
            ],200);

          }else{
            return response()->json([
            'status' => 'failed',
            'message' => 'unauthorized'
            ],401);

          }
         }

   function SentOTPCode(Request $request){

    $email = $request->input('email');
    //4 digite er otp generate korbo
    $otp = rand(1000,9999);

    $count=User::where('email','=',$email)->count();

    if($count==1){
      //sent otp
    Mail::to($email)->send(new OTPMail($otp));

      //insert otp to database
      User::where('email','=',$email)->update(['otp'=>$otp]);

      return response()->json([
            'status' =>'success',
            'message' => 'OTP sent successfully'
            ], 200);

    }else{
      return response()->json([
      'status' => 'failed',
      'message' => 'unauthorized'
      ],401);
    }

   }


   function VerifyOTP(Request $request){
    $email = $request->input('email');
    $otp = $request->input('otp');

    $count = User::where('email','=',$email)
    ->where('otp','=',$otp)
    ->count();

    if($count==1){
      //database otp update
      User::where('email','=',$email)->update(['otp'=>'0']);
       
      //password reset token issue
      $token = JWTToken::CreateTokenforResetPassword($request->input('email'));
      return response()->json([
        'status' => 'success',
        'message' => 'OTP Verification successfully',
        'token' => $token
      ],200);




    }else{
      return response()->json([
        'status' => 'failed',
        'message' => 'unauthorized'
      ],401);
    }

   }

   function ResetPassword(Request $request){
    //user er kach theke sodo token r new password receive korbo.

    try{
      
    $email = $request->header('email');
    $password = $request->input('password');
    User::where('email','=',$email)->update(['password'=>$password]);
   
    return response()->json([
     'status' =>'success',
     'message' => 'Password reset successfully'
    ],200);

    }catch(Exception $e){
   
      return response()->json([
            'status' => 'failed',
            'message' => 'Something Went Wrong'
            ],401);
    }

  


    
    

   }

 }


