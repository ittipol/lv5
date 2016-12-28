<?php

namespace App\Models;

use App\Models\Model;
use App\Models\Word;

class Tagging extends Model
{
  public $table = 'taggings';
  protected $fillable = ['model','model_id','word_id'];
  public $timestamps  = false;

  public function __construct() {  
    parent::__construct();
  }

  public function word() {
    return $this->hasOne('App\Models\Word','id','word_id');
  }

  public function __saveRelatedData($model,$value) {
    
    $word = new Word;
    $word->setFormToken($this->formToken);
    $wordIds = $word->saveSpecial($value);

    foreach ($wordIds as $wordId) {

      if(($model->state == 'update') && $model->checkRelatedDataExist($this->modelName,[['word_id','=',$wordId]])){
        $model->getRalatedDataByModelName($this->modelName,true,[['word_id','=',$wordId]])
        ->setFormToken($this->formToken)
        ->fill($value)
        ->save();
      }else{
        $this->_save($model->includeModelAndModelId(array('word_id' => $wordId)));
      }

    }

    return true;
    
  }

  public function clearAndSaves($model,$wordIds) {
    // clear old record
    $this->deleteByModelNameAndModelId($model->modelName,$model->id);

    foreach ($wordIds as $wordId) {
      $this->_save($model->includeModelAndModelId(array('word_id' => $wordId)));
    }

    return true;
  }

}
