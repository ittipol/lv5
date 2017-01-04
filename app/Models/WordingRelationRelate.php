<?php

namespace App\Models;

class WordingRelationRelate extends Model
{
  public $table = 'wording_relation_relates';
  protected $fillable = ['model','model_id','wording_relation_id'];
  public $timestamps  = false;

  public function checkAndSave($model,$wordingRelationId) {
    if(!$this->checkRecordExist($model,$wordingRelationId)) {

      $value = array(
        'wording_relation_id' => $wordingRelationId,
      );

      return $this->_save($model->includeModelAndModelId($value));
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
