<?php

namespace App\library;

class String
{
  public static function subString($string,$len,$stripTag = true){

    // $string = iconv(mb_detect_encoding($string, mb_detect_order(), true), "UTF-8", $string);

    if(empty($string)) {
      return '-';
    }

    if($stripTag){
      $string = strip_tags($string);
    }

    $_string = $string;

    if(strlen($string) <= $len) {
      return $string;
    }

    $string = substr($string, 0, $len);
    $lastChar = substr($string, $len-1, 1);

    if(ord($lastChar) != 32) {
      $pos = strpos($_string,' ',$len);
      $string = substr($_string, 0, $pos).'...';
    }

    return $string;

  } 
}
