<?php

namespace App\Models;

use App\Models\Model;
use App\Models\Tagging;

class Lookup extends Model
{
  protected $table = 'lookups';
  protected $fillable = ['model','model_id','keyword','description','keyword_1','keyword_2','keyword_3','keyword_4'];
  public $timestamps  = false;

  private function parser($model,$data = array()) {

    $formats = $model->lookupFormat;

    $parseFormat = '/{{[\w\d|:.]+}}/';
    $parseValue = '/[\w\d|:.]+/';

    $result = array();

    foreach ($formats as $key => $format) {
      preg_match_all($parseFormat, $format, $matches);

      if(!empty($matches[0])){

        $result[$key] = $format;

        foreach ($matches[0] as $value) {

          preg_match_all($parseValue, $value, $_matches);

          if(!empty($_matches[0][0])){

            // First: check data in $data
            if(array_key_exists($_matches[0][0],$data)) {
              $str = strip_tags($data[$_matches[0][0]]);
              $str = trim(preg_replace('/\s\s+/', ' ', $str));
              $result[$key] = str_replace($value, $str, $result[$key]);
            }else{
              $parts = explode('|', $_matches[0][0]);

              if(!empty($parts[1])){

                $records = $this->getData($parts[0],$model,array(
                  'lookup' => $parts[1]
                ));

                list($class,$field) = explode('.', $parts[0]);

                $data = array();

                if(!empty($records[$class])){
                  foreach ($records[$class] as $record) {
                    $data[] = $record[$field];
                  }
                }
              
                $data = implode(' ', $data);

                $str = strip_tags($data);
                $str = trim(preg_replace('/\s\s+/', ' ', $str));
                $result[$key] = str_replace($value, $str, $result[$key]);
              }
            }

          }
        }

        $result[$key] = trim($result[$key]);

      }
    }

    return $result;

  }

  public function saveSpecial($model,$options = array()) {

    if(empty($model->lookupFormat)) {
      return false;
    }

    $data = $model->getAttributes();

    if(!empty($options['data'])){
      $data = array_merge($data,$options['data']);
    }

    $tags = Tagging::where([
      ['model','=',$model->modelName],
      ['model_id','=',$model->id]
    ])->get();

    $_tags = array();
    foreach ($tags as $tag) {
      $_tags[] = $tag->tag->name;
    }

    if(!empty($_tags)){
      $this->tags = implode(' ',$_tags);
    }

    $result = $this->parser($model,$data);

    foreach ($result as $key => $value) {
      $this->$key = $value;
    }

    $this->model = $model->modelName;
    $this->model_id = $model->id;

    return $this->save();
  }

}
