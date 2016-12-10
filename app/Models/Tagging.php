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

  public function checkRecordExist($model,$modelId,$tagId) {
    return $this->where([
      ['model','=',$model],
      ['model_id','=',$modelId],
      ['tag_id','=',$tagId]
    ])->count() ? true : false;
  }

  public function checkAndSave($model,$modelId,$tagId) {
    if(!$this->checkRecordExist($model,$modelId,$tagId)) {
      $this->model = $model;
      $this->model_id = $modelId;
      $this->tag_id = $tagId;
      $this->save();
    }
  }

}
