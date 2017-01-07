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
    $wordIds = $word->saveSpecial($options['value']);

    $currentTaggings = $model->getRalatedDataByModelName($this->modelName,array(
      'fields' => array('id','word_id')
    ));

    $currentId = array();
    if(!empty($currentTaggings)){
      foreach ($currentTaggings as $tagging) {
      
        if(in_array($tagging->word_id, $wordIds)) {
          $currentId[] = $tagging->word_id;
          continue;
        }

        // delete
        $this->find($tagging->id)->delete();

      }
    }

    foreach ($wordIds as $wordId) {
      if(!in_array($wordId, $currentId)) {
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
