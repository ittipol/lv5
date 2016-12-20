<?php

namespace App\Models;

use App\Models\Model;

class Wiki extends Model
{
  protected $table = 'wikis';
  protected $fillable = ['model','model_id','subject','description'];
  public $timestamps  = false;

  public function __construct() {  
    parent::__construct();
  }

  public function saveSpecial($model,$options = array()) {

    $value = array();

    $data = $model->getAttributes();

    $result = $this->parser($model,$data);

    if(!empty($result)){
      foreach ($result as $key => $_value){
        $value[$key] = $_value;
      }
    }

    if(($model->state == 'update') && $model->checkRelatedDataExist($this->modelName)){
      return $model->getRalatedDataByModelName($this->modelName,true)->fill($value)->save();
    }else{
      return $this->fill($model->includeModelAndModelId($value))->save();
    }

  }

  private function parser($model,$data = array()) {

    if(empty($model->wikiFormat)){
      return false;
    }

    $formats = $model->wikiFormat;

    $parseFormat = '/{{[\w\d|._,=>]+}}/';
    $parseValue = '/[\w\d|._,=>]+/';

    $result = array();

    foreach ($formats as $key => $format){

      preg_match_all($parseFormat, $format, $matches);

      if(!empty($matches[0])){

        $result[$key] = $format;

        foreach ($matches[0] as $value) {

          preg_match_all($parseValue, $value, $_matches);

          if(!empty($_matches[0][0])){
            $result[$key] = $this->_replace($data[$_matches[0][0]],$value,$result[$key]);
          }
        }

        $result[$key] = trim($result[$key]);

      }

    }

    return $result;

  }

  private function _replace($value,$key1,$key2) {
    $value = $this->_clean($value);
    return str_replace($key1, $value, $key2);
  }

  private function _clean($value) {
    $value = strip_tags($value);
    $value = trim(preg_replace('/\s\s+/', ' ', $value));
    return $value;
  }

}
