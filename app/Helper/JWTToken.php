<?php
namespace App\Helper;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTToken {

   public static function CreateToken($userEmail):string {
    $key = env('JWT_KEY');
    
    $payload =[
        //token issuer name
        'iss' => 'laravel-token',

        //token creation time
        'iat' => time(),

        //token expair time
        'exp'=> time()+60*60,
     //zar jonno token issu korbo tar mail
        'userEmail' => $userEmail
   
    ];

     return JWT::encode($payload, $key,'HS256');


    }

    public static function CreateTokenforResetPassword($userEmail):string {
      $key = env('JWT_KEY');
      
      $payload =[
          //token issuer name
          'iss' => 'laravel-token',
  
          //token creation time
          'iat' => time(),
  
          //token expair time
          //20 min time set
          'exp'=> time()+60*20,
       //zar jonno token issu korbo tar mail
          'userEmail' => $userEmail
     
      ];
  
       return JWT::encode($payload, $key,'HS256');
    }




   public static function VerifyToken($token):string {


    try{
      $key = env('JWT_KEY');
      $decode = JWT::decode($token,new Key($key,'HS256'));
      
      //verify hole $decode theke uporer $payload er property gola pabo

     return $decode->userEmail;

    }
    catch(Exception $e) {

      return 'unauthorized';  
       
    }

        
   



        
    }


}