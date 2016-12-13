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

  public function checkRecordExist($model,$modelId,$tagId) {
    return $this->where([
      ['model','=',$model],
      ['model_id','=',$modelId],
      ['tag_id','=',$tagId]
    ])->count() ? true : false;
  }

  public function checkAndSave($model,$modelId,$tags) {
    foreach ($tags as $tagId => $tag) {
      if(!$this->checkRecordExist($model,$modelId,$tagId)) {
        $this->_save($model,$modelId,$tagId);
      }
    }
  }

  public function deleteAndSave($model,$modelId,$tags) {
    // Delete first
    $this->where([
      ['model','=',$model],
      ['model_id','=',$modelId],
    ])->delete();
    foreach ($tags as $tagId => $tag) {
      $this->_save($model,$modelId,$tagId);
    }
  }

  private function _save($model,$modelId,$tagId) {
    $tagging = new Tagging;
    $tagging->model = $model;
    $tagging->model_id = $modelId;
    $tagging->tag_id = $tagId;
    $tagging->save();
  }

}
