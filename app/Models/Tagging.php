<?php

namespace App\Models;

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

  public function __saveRelatedData($model,$options = array()) {

    $word = new Word;
    $word->setFormToken($this->formToken);
    $wordIds = $word->saveSpecial($$options['value']);

    foreach ($wordIds as $wordId) {

      $taggigs = $model->getRalatedDataByModelName($this->modelName,
        array(
          'first' => true,
          'conditions' => [['word_id','=',$wordId]]
        )
      );

      if(($model->state == 'update') && !empty($taggigs)){
        $taggigs
        ->setFormToken($this->formToken)
        ->fill($$options['value'])
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
