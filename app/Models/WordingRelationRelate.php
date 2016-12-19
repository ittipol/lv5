<?php

namespace App\Models;

use App\Models\Model;

class WordingRelationRelate extends Model
{
  public $table = 'wording_relation_relates';
  protected $fillable = ['model','model_id','wording_relation_id'];
  public $timestamps  = false;

  public function _save($model,$wordingRelationId) {
    $wordingRelationRelate = new WordingRelationRelate;
    $wordingRelationRelate->model = $model->modelName;
    $wordingRelationRelate->model_id = $model->id;
    $wordingRelationRelate->wording_relation_id = $wordingRelationId;
    return $wordingRelationRelate->save();
  }

  public function checkAndSave($model,$wordingRelationId) {
    if(!$this->checkRecordExist($model,$wordingRelationId)) {
      return $this->_save($model,$wordingRelationId);
    }

    return true;
  }

  public function checkRecordExist($model,$wordingRelationId) {
    return $this->where([
      ['model','=',$model->modelName],
      ['model_id','=',$model->id],
      ['wording_relation_id','=',$wordingRelationId]
    ])->count() ? true : false;
  }
}
