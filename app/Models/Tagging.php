<?php

namespace App\Models;

use App\Models\Model;

class Tagging extends Model
{
  public $table = 'taggings';
  protected $fillable = ['model','model_id','tag_id'];
  public $timestamps  = false;

  public function __construct() {  
    parent::__construct();
  }

  public function tag() {
    return $this->hasOne('App\Models\Tag','id','tag_id');
  }

  public function checkRecordExist($model,$tagId) {
    return $this->where([
      ['model','=',$model->modelName],
      ['model_id','=',$model->id],
      ['tag_id','=',$tagId]
    ])->count() ? true : false;
  }

  public function checkAndSave($model,$tags) {
    foreach ($tags as $tagId => $tag) {
      if(!$this->checkRecordExist($model,$tagId)) {
        $this->_save($model,$tagId);
      }
    }
  }

  public function clearAndSave($model,$tags) {
    // clear old record
    $this->deleteByModelNameAndModelId($model->modelName,$model->id);

    // save
    foreach ($tags as $tagId => $tag) {
      $this->_save($model,$tagId);
    }
  }

  private function _save($model,$tagId) {
    $tagging = new Tagging;
    $tagging->model = $model->modelName;
    $tagging->model_id = $model->id;
    $tagging->tag_id = $tagId;
    $tagging->save();
  }

}
