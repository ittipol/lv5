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
    $number = "0123456789";

    $token = '';
    $len = strlen($number);

    for ($i = 0; $i <= $length; $i++) {
      $token .= $number[rand(0,$len-1)];
    };

    return $token;
  }

  public static function generateHex($length = 60){
    $codeAlphabet = "abcdef0123456789";

    $token = '';
    $len = strlen($codeAlphabet);

    for ($i = 0; $i <= $length; $i++) {
      $token .= $codeAlphabet[rand(0,$len-1)];
    };

    return $token;
  }

  public static function generatePageIdentity($personId) {
    return hash('sha256',Route::getCurrentRoute()->getPath().$personId);
  }

  public static function generateFormToken($personId) {
    // return md5($personId).hash('sha256',time()).Token::generateHex(4);
    return md5($personId).Token::generateHex(4);
  } 
}
