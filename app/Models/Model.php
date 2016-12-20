<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as _Model;
use App\Models\Image;
use App\Models\Address;
// use App\Models\Tag;
use App\Models\Tagging;
use App\Models\Wiki;
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
  public $createWiki = false;

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

      if(!$model->exists){ // create new record

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

      if($model->state == 'create') {
        $model->createDir();  
      }
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

    if(!empty($attributes['wiki'])) {
      $this->createWiki = true;
      unset($attributes['wiki']);
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

    return parent::save();

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

    $imageModel = new Image;
    $imageModel->saveImages($this,Session::get('Person.id'));

    foreach ($this->allowedModelData as $allowed) {

      if(empty($this->relatedData[$allowed])) {
        continue;
      }

      $this->_save($allowed,$this->relatedData[$allowed]);
    }

    // Add to Lookup table
    if($this->createLookup) {
      $lookup = new Lookup;
      $lookup->saveSpecial($this);
    }

    if($this->createWiki && ($this->state == 'create')){
      $wiki = new Wiki;
      $wiki->saveSpecial($this);
    }

  }

  private function _save($model,$value) {

    $class = Service::loadModel($model);

    if(!method_exists($class,'__saveRelatedData') || !$class->checkHasFieldModelAndModelId()) {
      return false;
    }

    return $class->__saveRelatedData($this,$value);
    
  }

  public function includeRelatedData($models = array()) {

    $data = $this->extract($models);
    
    foreach ($data as $model => $value) {
      $this->attributes[$model] = $value;
    }

  }

  public function extractRelatedData($data,$class = null) {

    $__data = array();

    foreach ($data as $model => $value) {

      if($model == 'options') {
        continue;
      }

      $_class = Service::loadModel($model);

      if(!empty($_class) && is_array($value)){
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
        return $this->_extractRelatedData($value,$class,$options);

      }

    }

    return $__data;
    
  }

  public function _extractRelatedData($fields,$class,$options = array()) {

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

    }

    return $data;

  }

  public function getRalatedDataByModelName($modelName,$onlyFirst = false,$conditons = []) {

    $class = Service::loadModel($modelName);

    if(!$class->checkHasFieldModelAndModelId()) {
      return false;
    }

    $_conditons = [
      ['model','=',$this->modelName],
      ['model_id','=',$this->id],
    ];

    $conditons = array_merge($conditons,$_conditons);

    $model = $class->where($conditons);

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

  public function checkRelatedDataExist($modelName,$conditons = []) {

    $class = Service::loadModel($modelName);

    if(!$class->checkHasFieldModelAndModelId()) {
      return false;
    }

    $_conditons = [
      ['model','=',$this->modelName],
      ['model_id','=',$this->id],
    ];

    $conditons = array_merge($conditons,$_conditons);

    return $class->where($conditons)->count()  ? true : false;
  }

  public function checkHasFieldModelAndModelId() {
    if(Schema::hasColumn($this->getTable(), 'model') && Schema::hasColumn($this->getTable(), 'model_id')) {
      return true;
    }
    return false;
  }

  public function includeModelAndModelId($value) {

    if(empty($this->modelName) || empty($this->id)){
      return false;
    }

    return array_merge($value,array(
      'model' => $this->modelName,
      'model_id' => $this->id,
    ));

  }

}
