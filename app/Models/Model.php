<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as _Model;
use App\Models\Image;
use App\Models\Address;
use Auth;
use Session;

class Model extends _Model
{
  public $modelName;
  public $alias;
  public $disk;
  public $imageDirPath;
  public $noImagePath = '/images/no-img.png';

  public function __construct(array $attributes = []) { 
    parent::__construct($attributes);
    
    $this->modelName = class_basename(get_class($this));
    $this->alias = $this->disk = strtolower($this->modelName);
    $this->imageDirPath = 'app/public/'.$this->disk.'/';
  }

  public function includeRelatedData($models = array()) {

    $data = $this->extract($models);
    
    foreach ($data as $model => $value) {
      $this->attributes[$model] = $value;
    }

  }

  public function extract($data,$class = null) {

    $__data = array();

    foreach ($data as $model => $value) {

      if($model == 'options') {
        continue;
      }

      $_class = 'App\Models\\'.$model;

      if(class_exists($_class) && is_array($value)){

        $_class = new $_class;
        // extract
        $_data = $this->extract($value,$_class);
        // save
        $__data[$_class->modelName] = $_data[$_class->modelName];

      }

      if($model == 'fields') {

        $options = array();

        if(!empty($data['options'])){
          $options = $data['options'];
        }

        // get data
        return $this->getData($value,$class,$options);

      }

    }

    return $__data;
    
  }

  public function getData($fields,$class,$options = array()) {

    $data = array();

    if(!empty($options['related'])){
      $parts = explode('.', $options['related']);

      if(!empty($parts[1])){
        $relatedClass = $parts[0];
        $relation = $parts[1];
      }else{
        return false;
      }

      $relatedClass = 'App\Models\\'.$relatedClass;
      $relatedClass = new $relatedClass;
      $records = $relatedClass->where([
        ['model','=',$this->modelName],
        ['model_id','=',$this->id]
      ])->get();

      foreach ($records as $key => $record) {
        $record = $record->{$relation};
        foreach ($fields as $field) {
          if(isset($record['attributes'][$field])){
            $data[$class->modelName][$key][$field] = $record['attributes'][$field];
          }
        }
      }

    }else{
      $records = $class->where([
        ['model','=',$this->modelName],
        ['model_id','=',$this->id]
      ])->get();

      foreach ($records as $key => $record) {
        foreach ($fields as $field) {
          if(isset($record['attributes'][$field])){
            $data[$class->modelName][$key][$field] = $record['attributes'][$field];
          }
        }
      }

    }
    
    return $data;

  }

  public function address() {
    if(!empty($this->id)){
      return Address::where([
        ['model','=',$this->modelName],
        ['model_id','=',$this->id]
      ])->first();
    }
    return false;
  }

  public function image() {
    if(!empty($this->id)){
      $image = Image::where([
        ['model','=',$this->modelName],
        ['model_id','=',$this->id]
      ])->first();
      return !empty($image) ? $image : false;
    }
    return false;
  }

  public function imageUrl() {
    $image = $this->image();

    $url = null;
    if(!empty($image)){
      $url = $image->getImageUrl();
    }
 
    return !empty($url) ? $url : false;
  }

  public function images($getAttributes = false) {
    if(!empty($this->id)){
      $images = Image::where([
        ['model','=',$this->modelName],
        ['model_id','=',$this->id]
      ])->get();

      if(!empty($images->count())){
        if($getAttributes){
          $imagesData = array();
          foreach ($images as $image) {
            $imagesData[] = $image->getAttributes();
          }
          return $imagesData;
        }else{
          return $images;
        }
      }
    }
    return false;
  }

  public function imagesUrl() {
    $images = $this->images();

    $urls = array();
    if(!empty($images)){
      foreach ($images as $image) {
        $urls[] = $image->getImageUrl();
      }
    }

    return !empty($urls) ? $urls : false;
  }

  public function tags($getAttributes = false) {
    $taggings = Tagging::where([
      ['model','=',$this->modelName],
      ['model_id','=',$this->id]
    ])->get();

    $tags = array();

    if($getAttributes){
      foreach ($taggings as $tagging) {
        $tags[] = $tagging->tag->getAttributes();
      }
    }else{
      foreach ($taggings as $tagging) {
        $tags[] = $tagging->tag;
      }
    }

    return $tags;
  }

  // public function deleteReletedData() {
  //   $this->where([
  //     ['model','=',$this->modelName],
  //     ['model_id','=',$this->id],
  //   ])->delete();
  // }

}
