<?php

namespace App\Models;

use App\Models\Model;
use App\Models\Tagging;

class Lookup extends Model
{
  protected $table = 'lookups';
  protected $fillable = ['model','model_id','keyword','description','keyword_1','keyword_2','keyword_3','keyword_4'];
  public $timestamps  = false;

  //  Lookup Special Format
  // 'keyword' => '{{Department.name|CompanyHasDepartment.company_id.id:Department.id.department_id}}',
  // 'keyword' => array(
  //   'get' => 'Department.name',
  //   'key' => array(
  //     'Company.id' => 'CompanyHasDepartment.company_id',
  //     'CompanyHasDepartment.department_id' => 'Department.id'
  //   )
  // ),

  private function parser($model,$data = array()) {

    $formats = $model->lookupFormat;

    $parseFormat = '/{{[\w\d|:.]+}}/';
    $parseValue = '/[\w\d|:.]+/';

    $result = array();

    foreach ($formats as $key => $format){

      if(is_array($format)){
        $records = $this->getData($format['get'],$model,array(
          'lookupArrayFormat' => $format['key'],
          'id' => $model->id
        ));

        list($class,$field) = explode('.', $format['get']);

        $_value = array();

        if(!empty($records[$class])){
          foreach ($records[$class] as $record) {
            $_value[] = $record[$field];
          }
        }
      
        $_value = implode(' ', $_value);

        $result[$key] = trim(preg_replace('/\s\s+/', ' ', strip_tags($_value)));

      }else{
        preg_match_all($parseFormat, $format, $matches);

        if(!empty($matches[0])){

          $result[$key] = $format;

          foreach ($matches[0] as $value) {

            preg_match_all($parseValue, $value, $_matches);

            if(!empty($_matches[0][0])){

              // First: check data in $data
              if(array_key_exists($_matches[0][0],$data)) {
                $_value = $data[$_matches[0][0]];
              }else{
                $parts = explode('|', $_matches[0][0]);

                if(!empty($parts[1])){

                  $records = $this->getData($parts[0],$model,array(
                    'lookupStringFormat' => $parts[1]
                  ));

                  list($class,$field) = explode('.', $parts[0]);

                  $_value = array();

                  if(!empty($records[$class])){
                    foreach ($records[$class] as $record) {
                      $_value[] = $record[$field];
                    }
                  }
                
                  $_value = implode(' ', $_value);

                }
              }

              $str = strip_tags($_value);
              $str = trim(preg_replace('/\s\s+/', ' ', $str));
              $result[$key] = str_replace($value, $str, $result[$key]);

            }
          }

          $result[$key] = trim($result[$key]);

        }
      }

    }

    return $result;

  }

  public function saveSpecial($model,$options = array()) {

    if(empty($model->lookupFormat)){
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

    // Parser
    $result = $this->parser($model,$data);

    foreach ($result as $key => $value){
      $this->$key = $value;
    }

    $this->model = $model->modelName;
    $this->model_id = $model->id;

    return $this->save();
  }

}
