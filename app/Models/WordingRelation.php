<?php

namespace App\Models;

class WordingRelation extends Model
{
  public $table = 'wording_relations';
  protected $fillable = ['word','relate_to_word'];
  public $timestamps  = false;

  public  function saveSpecial($model1,$model2,$value) {

    $wordingRelationRelate = new WordingRelationRelate;
    $wordingRelationRelate->setFormToken($this->formToken);

    $taggings = $model1->getRalatedDataByModelName('Tagging',array(
      'fields' => array('word_id')
    ));

    if(!empty($taggings)){

      foreach ($taggings as $tagging) {
        $this->checkAndSave($value,$tagging->word->word);
        $data = $this->getDataByWordAndRelateToWord($value,$tagging->word->word);
 
        if(!empty($data->id)){
          $wordingRelationRelate->checkAndSave($model2,$data->id);
        }
      }

    }
    
    return true;
  }

  public function checkAndSave($word,$relateToWord) {
    if(!$this->checkRecordExist($word,$relateToWord)) {
      return $this->_save(array('word' => $word, 'relate_to_word' => $relateToWord));
    }

    return true;
  }

  public function checkRecordExist($word,$relateToWord) {
    return $this->where([
      ['word','like',$word],
      ['relate_to_word','like',$relateToWord],
    ])->count() ? true : false;
  }

  public function getDataByWordAndRelateToWord($word,$relateToWord) {
    return $this->where([
      ['word','like',$word],
      ['relate_to_word','like',$relateToWord]
    ])->first();
  }

  public function getDataByWord($word) {
    return $this->where('word','like',$word)->get();
  }

  public function getDataByRelateToWord($relateToWord) {
    return $this->where('relate_to_word','like',$relateToWord)->get();
  }
}
