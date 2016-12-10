<?php

namespace App\library;

class Token
{
  public static function generate(){
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet .= "0123456789";

    $token = '';
    $len = strlen($codeAlphabet);

    for ($i = 0; $i <= 60; $i++) {
      $token .= $codeAlphabet[rand(0,$len-1)];
    };

    return $token;
  } 
}
