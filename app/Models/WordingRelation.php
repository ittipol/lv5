<?php

namespace App\Models;

use App\Models\Model;
use App\Models\WordingRelationRelate;

class WordingRelation extends Model
{
  public $table = 'wording_relations';
  protected $fillable = ['word','relate_to_word'];
  public $timestamps  = false;

  public  function saveSpecial($model1,$model2,$value) {

    $taggings = $model1->getRalatedDataByModelName('Tagging');

    if(!empty($taggings)){
      
      foreach ($taggings as $tagging) {
        $this->checkAndSave($value,$tagging->tag->name);
        $data = $this->getDataByWordAndRelateToWord($value,$tagging->tag->name);

        if(!empty($data->id)){
          $this->checkAndSave($model2,$data->id);
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
