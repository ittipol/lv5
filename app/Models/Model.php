<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as _Model;
use App\Models\Image;
use App\Models\Address;
use App\Models\Tag;
use App\Models\Tagging;
use App\Models\WordingRelation;
use App\Models\Lookup;
use App\library\token;
use App\library\service;
use Auth;
use Session;
use Schema;

class Model extends _Model
{
  public $modelName;
  public $alias;
  public $state = 'create';
  public $pageToken;
  public $disk;
  public $storagePath = 'app/public/';
  public $dirPath;
  public $dirNames;
  public $relatedData;
  public $allowedModelData = array('Address','Tagging');
  public $createDir = false;
  public $createLookup = false;

  public function __construct(array $attributes = []) { 

    parent::__construct($attributes);
    
    $this->modelName = class_basename(get_class($this));
    $this->alias = $this->disk = strtolower($this->modelName);
    $this->dirPath = $this->storagePath.$this->disk.'/';

  }

  public static function boot() {

    parent::boot();

    // before saving
    parent::saving(function($model){

      if(!$model->exists){ // new record

        $model->state = 'create';

        if(Schema::hasColumn($model->getTable(), 'ip_address')) {
          $model->ip_address = Service::ipAddress();
        }

        if(Schema::hasColumn($model->getTable(), 'created_by')) {
          $model->created_by = Session::get('Person.id');
        }

      }else{
        $model->state = 'update';
      }

    });

    // after saving
    parent::saved(function($model){
      $model->createDir();  
      $model->saveRelatedData();
    });

  }

  public function fill(array $attributes) {

    foreach ($this->allowedModelData as $allowed) {

      if(empty($attributes[$allowed])) {
        continue;
      }

      $this->relatedData[$allowed] = $attributes[$allowed];

      unset($attributes[$allowed]);
    }

    if(!empty($attributes['__token'])) {
      $this->pageToken = $attributes['__token'];
      unset($attributes['__token']);
    }

    return parent::fill($attributes);

  }

  public function save(array $options = []) {

    if(!empty($this->requireValue)) {
      foreach ($this->requireValue as $field) {
        if(empty($this->{$field})) {
          return false;
        }
      }
    }

    // before save 
    return parent::save();
    // after save
  }

  public function createDir($model = null) {

    if(empty($model)) {
      $model = $this;
    }

    if(!$model->createDir) {
      return false;
    }

    $path = storage_path($model->dirPath).'/'.$model->id;
    if(!is_dir($path)){
      mkdir($path,0777,true);
    }

    if(!empty($model->dirNames)){
      foreach ($model->dirNames as $dir) {
        $dirName = $path.'/'.$dir;
        if(!is_dir($dirName)){
          mkdir($dirName,0777,true);
        }
      }
    }

  }

  public function saveRelatedData() {

    if (!$this->exists || empty($this->pageToken)) {
      return false;
    }

    $this->saveImages();

    foreach ($this->allowedModelData as $allowed) {

      if(empty($this->relatedData[$allowed])) {
        continue;
      }

      $this->_save($allowed,$this->relatedData[$allowed]);
    }

  }

  private function _save($model,$value) {

    $class = Service::loadModel($model);

    if(!method_exists($class,'__saveWithModelAndModelId') || !$class->checkHasFieldModelAndModelId()) {
      return false;
    }

    return $class->__saveWithModelAndModelId($this,$value);
    
  }

  public function saveImages() {
    $image = new Image;
    $image->saveUploadImages($this,Session::get('Person.id'));
    $image->deleteImages($this,Session::get('Person.id'));
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

      // $_class = 'App\Models\\'.$model;
      $_class = Service::loadModel($model);

      if(!empty($_class) && is_array($value)){

        // $_class = new $_class;
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

      $relatedClass = Service::loadModel($relatedClass);
      $records = $relatedClass->where([
        ['model','=',$this->modelName],
        ['model_id','=',$this->id]
      ])->get($fields);

      foreach ($records as $key => $record) {
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

    }elseif(!empty($options['lookupStringFormat'])) {

      $lookup = new Lookup;

      $formats = explode(',', $options['lookupStringFormat']);

      $records = array();
      foreach ($formats as $format) {
        list($key1,$key2) = explode('=>', $format);
        $records = $lookup->__lookupFormatParser($class,$key1,$key2,$records);
      }

      $fields = explode('.', $fields);

      $data = array();
      foreach ($records as $key => $record) {
        $data[$fields[0]][$key][$fields[1]] = $record[$fields[1]];
      }

    }elseif(!empty($options['lookupArrayFormat'])) {

      $lookup = new Lookup;

      $formats = $options['lookupArrayFormat'];

      $records = array();
      foreach ($formats as $key1 => $key2) {
        $records = $lookup->__lookupFormatParser($class,$key1,$key2,$records);
      }

      $fields = explode('.', $fields);

      $data = array();
      foreach ($records as $key => $record) {
        $data[$fields[0]][$key][$fields[1]] = $record[$fields[1]];
      }
    }

    return $data;

  }

  // public function images($getAttributes = false) {
  //   if(!empty($this->id)){
  //     $images = Image::where([
  //       ['model','=',$this->modelName],
  //       ['model_id','=',$this->id]
  //     ])->get();

  //     if(!empty($images->count())){
  //       if($getAttributes){
  //         $imagesData = array();
  //         foreach ($images as $image) {
  //           $imagesData[] = $image->getAttributes();
  //         }
  //         return $imagesData;
  //       }else{
  //         return $images;
  //       }
  //     }
  //   }
  //   return false;
  // }

  // public function imagesUrl() {
  //   $images = $this->images();

  //   $urls = array();
  //   if(!empty($images)){
  //     foreach ($images as $image) {
  //       $urls[] = $image->getImageUrl();
  //     }
  //   }

  //   return !empty($urls) ? $urls : false;
  // }

  // public function tags($getAttributes = false) {
  //   $taggings = Tagging::where([
  //     ['model','=',$this->modelName],
  //     ['model_id','=',$this->id]
  //   ])->get();

  //   $tags = array();

  //   if($getAttributes){
  //     foreach ($taggings as $tagging) {
  //       $tags[] = $tagging->tag->getAttributes();
  //     }
  //   }else{
  //     foreach ($taggings as $tagging) {
  //       $tags[] = $tagging->tag;
  //     }
  //   }

  //   return $tags;
  // }

  public function checkHasFieldModelAndModelId() {
    if(Schema::hasColumn($this->getTable(), 'model') && Schema::hasColumn($this->getTable(), 'model_id')) {
      return true;
    }
    return false;
  }

  public function getRalatedDataByModelName($modelName,$onlyFirst = false) {

    $class = Service::loadModel($modelName);

    if(!$class->checkHasFieldModelAndModelId()) {
      return false;
    }

    $model = $class->where([
      ['model','=',$this->modelName],
      ['model_id','=',$this->id],
    ]);

    if($onlyFirst){
      return $model->first();
    }

    return $model->get();

  }

  public function deleteByModelNameAndModelId($model,$modelId) {

    if(!$this->checkHasFieldModelAndModelId()) {
      return false;
    }

    return $this->where([
      ['model','=',$model],
      ['model_id','=',$modelId],
    ])->delete();

  }

}
