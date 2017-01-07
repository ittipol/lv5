<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;
use App\library\token;
use App\library\service;
use Auth;
use Session;
use Schema;

class Model extends BaseModel
{
  public $modelName;
  public $modelAlias;
  public $state = 'create';
  public $formToken;
  public $disk;
  public $storagePath = 'app/public/';
  public $dirPath;
  public $formRelatedData;
  public $temporaryData;

  // Form
  public $formTemplate;

  // Validation rules
  public $validation = array(
    'rules' => array(),
    'messages' => array(),
  );

  // sorting field
  public $sortingFields;

  public $allowed;
  
  public function __construct(array $attributes = []) { 

    parent::__construct($attributes);
    
    $this->modelName = class_basename(get_class($this));
    $this->modelAlias = $this->disk = Service::generateModelDirName($this->modelName);
    $this->dirPath = $this->storagePath.$this->disk.'/';

  }

  public static function boot() {

    parent::boot();

    // before saving
    parent::saving(function($model){

      if(empty($model->formToken) || empty(Session::get($model->formToken))) {
        return false;
      }

      if(!empty($model->requireValue)) {
        foreach ($model->requireValue as $field) {
          if(empty($model->{$field})) {
            return false;
          }
        }
      }

      if(!$model->exists){ // Create new record

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

    if(!empty($this->temporaryData)) {
      $_temporaryData = array();
      foreach ($this->temporaryData as $key => $value) {
        if(!empty($attributes[$value])) {
          $_temporaryData[$value] = $attributes[$value];
        }
      } 
      if(!empty($_temporaryData)) {
        $this->temporaryData = $_temporaryData;
      }
    }

    if(!empty($this->allowed['relatedModel'])){
      foreach ($this->allowed['relatedModel'] as $key => $modelName) {

        if(is_array($modelName)){
          $modelName = $key;
        }

        if(empty($attributes[$modelName])) {
          continue;
        }

        $this->formRelatedData[$modelName] = $attributes[$modelName];
        unset($attributes[$modelName]);
      }
    }

    if(!empty($attributes['__token'])) {
      $this->formToken = $attributes['__token'];
      unset($attributes['__token']);
    }

    if(!empty($attributes['wiki'])) {
      $this->createWiki = true;
      unset($attributes['wiki']);
    }

    return parent::fill($attributes);

  }

  public function _save($value) {
    $model = Service::loadModel($this->modelName);
    $model->fill($value);
    $model->setFormToken($this->formToken);
    $model->save();
  }

  public function saveRelatedData() {

    if (!$this->exists || empty($this->formToken)) {
      return false;
    }

    if(($this->state == 'create') && $this->allowed['Slug']) {
      $slug = new Slug;
      $slug->setFormToken($this->formToken)->__saveRelatedData($this);

      $personHasEntity = new PersonHasEntity;
      $personHasEntity->setFormToken($this->formToken)->__saveRelatedData($this,array(
        'person_id' => Session::get('Person.id'),
        'role_alias' => 'admin'
      ));
    }

    // if($this->allowedImage) {
    //   $imageModel = new Image;
    //   $imageModel->setFormToken($this->formToken)->__saveRelatedData($this,array(
    //     'person_id' => Session::get('Person.id')
    //   ));
    // }

    if($this->allowed['Wiki']){
      $wiki = new Wiki;
      $wiki->setFormToken($this->formToken)->__saveRelatedData($this);
    }

    if(!empty($this->allowed['relatedModel'])){
      foreach ($this->allowed['relatedModel'] as $key => $modelName) {

        if(is_array($modelName)){
          $data = $modelName;
          $modelName = $key;
        }

        if(empty($this->formRelatedData[$modelName])) {
          continue;
        }

        $options = array();
        if(!empty($data['options'])) {
          $options = Service::parseRelatedModelOptions($data['options']);
        }

        $options = array_merge($options,array(
          'value' => $this->formRelatedData[$modelName]
        ));

        $this->_saveRelatedData($modelName,$options);

      }
    }
    
  }

  private function _saveRelatedData($modelName,$options = array()) {

    $model = Service::loadModel($modelName);

    if(!method_exists($model,'__saveRelatedData') || !$model->checkHasFieldModelAndModelId()) {
      return false;
    }

    return $model->setFormToken($this->formToken)->__saveRelatedData($this,$options);
    
  }

  public function setFormToken($formToken) {
    $this->formToken = $formToken;
    return $this;
  }

  public function createDir() {

    // if(empty($this->allowedDir)) {
    //   return false;
    // }

    $path = storage_path($this->dirPath).'/'.$this->id;
    if(!is_dir($path)){
      mkdir($path,0777,true);
    }

    // if(!empty($this->allowedDir['dirNames'])){
    //   foreach ($this->allowedDir['dirNames'] as $dir) {
    //     $dirName = $path.'/'.$dir;
    //     if(!is_dir($dirName)){
    //       mkdir($dirName,0777,true);
    //     }
    //   }
    // }

    // return true;

  }

  public function deleteTempData($formToken = null) {

    if(empty($formToken)) {
      $formToken = $this->formToken;
    }

    $tempFile = new TempFile;
    $tempFile->deleteRecordByToken($formToken,Session::get('Person.id'));
    $tempFile->deleteTempDir($formToken);
  }

  public function checkExistById($id) {
    return $this->find($id)->exists();
  }

  public function getData($options = array()) {
    $model = $this;

    if(!empty($options['conditions'])){
      $model = $model->where($options['conditions']);
    }

    if(empty($model->count())) {
      return null;
    }

    if(!empty($options['fields'])){
      $model = $model->select($options['fields']);
    }

    if(!empty($options['first']) && $options['first']) {
      return $model->first();
    }

    return $model->get();
  }

  public function getRalatedDataByModelName($modelName,$options = array()) {

    $model = Service::loadModel($modelName);

    if(!$model->checkHasFieldModelAndModelId()) {
      return false;
    }

    $conditions = array(
      ['model','=',$this->modelName],
      ['model_id','=',$this->id],
    );

    if(!empty($options['conditions'])){
      $options['conditions'] = array_merge($options['conditions'],$conditions);
    }else{
      $options['conditions'] = $conditions;
    }

    return $model->getData($options);

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

    if(!is_array($value)) {
      $value = array($value);
    }

    return array_merge($value,array(
      'model' => $this->modelName,
      'model_id' => $this->id
    ));

  }

}
