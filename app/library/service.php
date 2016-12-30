<?php

namespace App\library;

use App\library\token;

class Service
{

  public static function loadModel($modelName) {
    $class = 'App\Models\\'.$modelName;

    if(!class_exists($class)) {
      return false;
    }

    return new $class;
  }

  public static function ipAddress() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
  }

  public static function generateFileName($file) {
    $name = time().'_'.Token::generateNumber(15).'_'.$file->getSize();
    return $name.'.'.$file->getClientOriginalExtension(); 
  }

  public static function generateModelDirName($modelName) {

    $alpha = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $len = strlen($modelName);

    $posStart = 0;

    $parts = array();
    for ($i=0; $i < $len; $i++) { 

      if(strpos($alpha, $modelName[$i]) && ($i > 0)) {
        $parts[] = strtolower(substr($modelName, $posStart, $i));
        $posStart = $i;
      }

      // if($i == $len-1) {
      //   $parts[] = strtolower(substr($modelName, $posStart, $i));
      // }

    }

    $parts[] = strtolower(substr($modelName, $posStart, $i));

    return implode('_', $parts);

  }

  public static function generateModelByModelAlias($modelAlias) {

    $modelAlias = str_replace('-', ' ', $modelAlias);
    $parts = explode(' ', $modelAlias);

    $modelName = '';
    foreach ($parts as $part) {
      $modelName .= ucfirst($part); 
    }

    return $modelName;

  }

}
