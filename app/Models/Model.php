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
  public $tempFileDir = 'tmp/';
  public $noImagePath = '/images/no-img.png';

  public function __construct(array $attributes = []) { 
    parent::__construct($attributes);
    
    $this->modelName = class_basename(get_class($this));
    $this->alias = $this->disk = strtolower($this->modelName);
    $this->imageDirPath = 'app/public/'.$this->disk.'/';
  }

  public function includeRelatedData($models = array()) {

    foreach ($models as $model) {

      $class = 'App\Models\\'.$model;

      $modelData = $class::where([
        ['model','=',$this->modelName],
        ['model_id','=',$this->id]
      ])->get();
    
      $temp = array();
      foreach ($modelData as $key => $value) {
        $temp[] = $value->getAttributes();
      }

      if(count($temp) == 1){
        $this[$model] = $temp[0];
      }else{
        $this[$model] = $temp;
      }

    }

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

  protected function generateCode() {
    // hash('sha256',$image->name);

    // $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    // $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet = "0123456789";

    $code = '';
    $len = strlen($codeAlphabet);

    for ($i = 0; $i < 15; $i++) {
      $code .= $codeAlphabet[rand(0,$len-1)];
    };

    return $code;

  }

}
