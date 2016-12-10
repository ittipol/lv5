<?php

namespace App\Models;

use App\Models\Model;

class Lookup extends Model
{
  protected $table = 'lookups';
  protected $fillable = ['model','model_id','keyword','description','keyword_1','keyword_2','keyword_3','keyword_4'];
  public $timestamps  = false;

  public function parser($formats,$data = array()) {

    $parseFormat = '/{{[\w\d]+}}/';
    $parseValue = '/[\w\d]+/';

    $result = array();

    foreach ($formats as $key => $format) {
      preg_match_all($parseFormat, $format, $matches);
      if(!empty($matches[0])){

        $result[$key] = $format;

        foreach ($matches[0] as $value) {
          preg_match_all($parseValue, $value, $_matches);
          if(!empty($_matches[0][0])){
            $str = strip_tags($data[$_matches[0][0]]);
            $str = trim(preg_replace('/\s\s+/', ' ', $str));
            $result[$key] = str_replace($value, $str, $result[$key]);
          }
        }

        $result[$key] = trim($result[$key]);

      }
    }

    return $result;

  }

  public function saveSpecial($model,$options = array()) {
    $this->model = $model->modelName;
    $this->model_id = $model->id;

    if(!empty($options['tags'])){
      $this->tags = implode(' ',$options['tags']);
    }

    $result = $this->parser($model->lookupFormat,$options['data']);

    foreach ($result as $key => $value) {
      $this->$key = $value;
    }

    return $this->save();
  }

}
