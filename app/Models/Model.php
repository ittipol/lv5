<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as _Model;
use App\Models\Image;
use App\Models\Address;
use App\Models\Tag;
use App\Models\Tagging;
use App\Models\DataRelation;
use App\Models\Lookup;
use Auth;
use Session;
use Schema;

class Model extends _Model
{
  public $modelName;
  public $alias;
  public $disk;
  public $storagePath = 'app/public/';
  public $dirPath;
  public $dirs = array();
  // public $noImagePath = '/images/no-img.png';
  public $createDir = false;

  public function __construct(array $attributes = []) { 
    parent::__construct($attributes);
    
    $this->modelName = class_basename(get_class($this));
    $this->alias = $this->disk = strtolower($this->modelName);
    $this->dirPath = $this->storagePath.$this->disk.'/';
  }

  public static function boot() {

    parent::boot();

    // parent::saving(function($model){
    // });

    parent::saved(function($model){
      if($model->createDir) {
        $model->createImageFolder($model);
      }
    });
  }

  // public function save(array $options = []) {
  //   // before save code 
  //   parent::save();
  //   // after save code
  // }

  public function createImageFolder($model) {
    $path = storage_path($model->dirPath).'/'.$model->id;
    if(!is_dir($path)){
      mkdir($path,0777,true);
    }

    foreach ($this->dirs as $dir) {
      $dirName = $path.'/'.$dir;
      if(!is_dir($dirName)){
        mkdir($dirName,0777,true);
      }
    }

  }

  public function saveRelatedData($input) {

    if (!$this->exists) {
      return false;
    }

    // $image = new Image;
    // $image->saveUploadImages($this,$input['form_token'],Session::get('Person.id'));
    // $image->deleteImages($this,$input['form_token'],Session::get('Person.id'));

    // if(!empty($input['address'])) {
    //   $address = new Address;
    //   $address->fill($input['address']);
    //   $address->model = $this->modelName;
    //   $address->model_id = $this->id;
    //   $address->save();
    // }
    
    $tags = array();
    if(!empty($input['tags'])){
      $tag = new Tag;
      $tags = $tag->saveTags($input['tags']);
    }

    if(!empty($tags)){
      $tagging = new Tagging;
      $tagging->clearAndSave($this,$tags);
    }

    // $dataRelation = new DataRelation;
    // $dataRelation->checkAndSave();
dd('sdss');
    // Add to Lookup table
    $lookup = new Lookup;
    $lookup->saveSpecial($this);


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

    if(empty($class)){
      return false;
    }

    if(!empty($options['related'])) {
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
      ])->get($fields);

      foreach ($records as $key => $record) {
        // $record = $record->{$relation};
        $data[$class->modelName][$key] = $record->{$relation}->getAttributes();
      }

    }elseif(Schema::hasColumn($class->getTable(), 'model') && Schema::hasColumn($class->getTable(), 'model_id')){
      $records = $class->where([
        ['model','=',$this->modelName],
        ['model_id','=',$this->id]
      ])->get($fields);

      foreach ($records as $key => $record) {
        $data[$class->modelName][$key] = $record->getAttributes();
      }

    }elseif(!empty($options['lookup'])) {

      $formats = explode(':', $options['lookup']);

      $records = array();
      foreach ($formats as $format) {

        $temp = array();

        if(empty($records)){
          $records = $class->getAttributes();
        }

        $_parts = explode('.', $format);

        $_class = 'App\Models\\'.$_parts[0];
        $_class = new $_class;

        if(array_key_exists($_parts[2],$records)) {

          $_records = $_class->where($_parts[1],'=',$records[$_parts[2]])->get();

          foreach ($_records as $key => $_record) {
            $temp[] = $_record->getAttributes();
          }

          $records = $temp;

        }else{


          foreach ($records as $key => $record) {

            if(empty($record[$_parts[2]])) {
              continue;
            }

            $_records = $_class->where($_parts[1],'=',$record[$_parts[2]])->get();

            foreach ($_records as $key => $_record) {
              $temp[] = $_record->getAttributes();
            }
            
          }

          $records = $temp;

        }

      }

      $fields = explode('.', $fields);

      $data = array();
      foreach ($records as $key => $record) {
        $data[$fields[0]][$key][$fields[1]] = $record[$fields[1]];
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
