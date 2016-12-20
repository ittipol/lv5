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

  // public static function extract($data,$class = null) {

  //   $__data = array();

  //   foreach ($data as $model => $value) {

  //     if($model == 'options') {
  //       continue;
  //     }

  //     $_class = Service::loadModel($model);

  //     if(!empty($_class) && is_array($value)){
  //       // extract
  //       $_data = $this->extract($value,$_class);
  //       // save
  //       $__data[$_class->modelName] = $_data[$_class->modelName];
  //     }

  //     if($model == 'fields') {

  //       $options = array();

  //       if(!empty($data['options'])){
  //         $options = $data['options'];
  //       }

  //       // get data
  //       return $this->getData($value,$class,$options);

  //     }

  //   }

  //   return $__data;
    
  // }

  // public static function extract($model,$fields,$class,$options = array()) {

  //   $data = array();

  //   if(empty($class)){
  //     return false;
  //   }

  //   if(!empty($options['related'])) {
  //     $parts = explode('.', $options['related']);

  //     if(!empty($parts[1])){
  //       $relatedClass = $parts[0];
  //       $relation = $parts[1];
  //     }else{
  //       return false;
  //     }

  //     $relatedClass = Service::loadModel($relatedClass);
  //     $records = $relatedClass->where([
  //       ['model','=',$model->modelName],
  //       ['model_id','=',$model->id]
  //     ])->get($fields);

  //     foreach ($records as $key => $record) {
  //       $data[$class->modelName][$key] = $record->{$relation}->getAttributes();
  //     }

  //   }elseif(Schema::hasColumn($class->getTable(), 'model') && Schema::hasColumn($class->getTable(), 'model_id')){
  //     $records = $class->where([
  //       ['model','=',$model->modelName],
  //       ['model_id','=',$model->id]
  //     ])->get($fields);

  //     foreach ($records as $key => $record) {
  //       $data[$class->modelName][$key] = $record->getAttributes();
  //     }

  //   }

  //   return $data;

  // }

  // public static function includeModelAndModelId($model,$value) {

  //   if(empty($model->modelName) || empty($model->id)){
  //     return false;
  //   }

  //   $value = array_merge($value,array(
  //     'model' => $model->modelName,
  //     'model_id' => $model->id,
  //   ));

  //   dd($value);
    
  // }

}
