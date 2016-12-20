<?php

namespace App\Models;

use App\Models\Model;

class Wiki extends Model
{
  protected $table = 'wikis';
  protected $fillable = ['model','model_id','subject','description'];
  public $timestamps  = false;

  public function __construct() {  
    parent::__construct();
  }

  public function __saveSpecial($model,$value) {
    // return $this->clearAndSave($model,$value);
    return $this->_save($model,$value);
  }

  private function _save($model,$subject,$description) {
    $wiki = new Wiki;
    $wiki->model = $model->modelName;
    $wiki->model_id = $model->id;
    $wiki->subject = $subject;
    $wiki->description = $description;
    $wiki->save();
  }

  // public function clearAndSave($model,$value) {
  //   $this->deleteByModelNameAndModelId($model->modelName,$model->id);
  //   return $this->_save($model,$value);
  // }
}
