<?php

namespace App\Models;

class Wiki extends Model
{
  protected $table = 'wikis';
  protected $fillable = ['model','model_id','subject','description'];
  public $timestamps  = false;

  public function __construct() {  
    parent::__construct();
  }

  public function __saveRelatedData($model,$options = array()) {

    if(empty($model->allowed['Wiki']['format'])) {
      return false;
    }

    $options = array(
      'format' => $model->allowed['Wiki']['format']
    );

    $result = $this->parser($model,$options);

    $value = array();
    if(!empty($result)){
      foreach ($result as $key => $_value){
        $value[$key] = $_value;
      }
    }

    $wiki = $model->getRalatedDataByModelName($this->modelName,
      array(
        'onlyFirst' => true
      )
    );

    if(($model->state == 'update') && !empty($wiki)){
      return $wiki
      ->setFormToken($this->formToken)
      ->fill($value)
      ->save();
    }else{
      return $this->fill($model->includeModelAndModelId($value))->save();
    }

  }

  private function parser($model,$options = array()) {

    if(empty($options['format'])){
      return false;
    }

    $data = $model->getAttributes();

    $parseFormat = '/{{[\w\d|._,=>]+}}/';
    $parseValue = '/[\w\d|._,=>]+/';

    $result = array();

    foreach ($options['format'] as $key => $format){

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
