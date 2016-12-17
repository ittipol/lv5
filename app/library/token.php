<?php

namespace App\library;

use Session;
use Route;
use Request;

class Token
{
  public static function generate($length = 60){
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet .= "0123456789";

    $token = '';
    $len = strlen($codeAlphabet);

    for ($i = 0; $i <= $length; $i++) {
      $token .= $codeAlphabet[rand(0,$len-1)];
    };

    return $token;
  }

  public static function generateNumber($length = 60){
    $codeAlphabet = "0123456789";

    $token = '';
    $len = strlen($codeAlphabet);

    for ($i = 0; $i <= $length; $i++) {
      $token .= $codeAlphabet[rand(0,$len-1)];
    };

    return $token;
  }

  public static function generateFormToken($personId) {
    return hash('sha256',Route::getCurrentRoute()->getPath().$personId);
  } 
}
