<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
   protected $fillable = ['firstName','lastName','email','mobile','password','otp'];
   
   //migration aa nullabe oo kora zeto
   protected $attributes = [
    'otp' => '0'
   ];

}
