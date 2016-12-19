<?php

namespace App\Models;

use App\Models\Model;
use App\Models\Tagging;
use App\library\service;

class Lookup extends Model
{
  protected $table = 'lookups';
  protected $fillable = ['model','model_id','keyword','description','keyword_1','keyword_2','keyword_3','keyword_4','address','tags'];
  public $timestamps  = false;

  //  Lookup Special Format
  // 'keyword' => '{{Department.name|Company.id=>CompanyHasDepartment.company_id,CompanyHasDepartment.department_id=>Department.id}}',
  // 'keyword' => array(
  //   'get' => 'Department.name',
  //   'key' => array(
  //     'Company.id' => 'CompanyHasDepartment.company_id',
  //     'CompanyHasDepartment.department_id' => 'Department.id'
  //   )
  // ),
  // 
  // Call Method
  // 'address' => '{{__getAddress}}'

  private function parser($model,$data = array()) {

    if(empty($model->lookupFormat)){
      return false;
    }

    $formats = $model->lookupFormat;

    $parseFormat = '/{{[\w\d|._,=>]+}}/';
    $parseValue = '/[\w\d|._,=>]+/';

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

        $result[$key] = $this->_replace($_value,$value,$result[$key]);
        // $result[$key] = trim(preg_replace('/\s\s+/', ' ', strip_tags($_value)));

      }else{
        preg_match_all($parseFormat, $format, $matches);

        if(!empty($matches[0])){

          $result[$key] = $format;

          foreach ($matches[0] as $value) {

            preg_match_all($parseValue, $value, $_matches);

            if(!empty($_matches[0][0])){

              // First: check data in $data
              if(substr($_matches[0][0],0,2) == '__'){
                $_value = $this->{$_matches[0][0]}($model);
              }elseif(array_key_exists($_matches[0][0],$data)) {
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

              $result[$key] = $this->_replace($_value,$value,$result[$key]);

            }
          }

          $result[$key] = trim($result[$key]);

        }
      }

    }

    return $result;

  }

  public function saveSpecial($model,$options = array()) {

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

    $_addresses = $this->__getAddress($model);
    if($_addresses){
      $this->address = $_addresses;
    }

    // Parser
    $result = $this->parser($model,$data);

    if(!empty($result)){
      foreach ($result as $key => $value){
        $this->$key = $value;
      }
    }

    $this->model = $model->modelName;
    $this->model_id = $model->id;

    return $this->save();
  }

  public function __getAddress($model) {
    $addresses = $model->getRalatedDataByModelName('Address');

    $_address = array();
    foreach ($addresses as $address) {
      $_address[] = trim($address->district->name.' '.$address->subDistrict->name.' '.$address->address);
    }

    $_address = implode(' ', $_address);

    return $this->_clean($_address);

  }

  public function __lookupFormatParser($class,$key1,$key2,$records = array()) {

    $temp = array();

    list($class1,$field1) = explode('.', $key1);
    list($class2,$field2) = explode('.', $key2);

    $class1 = Service::loadModel($class1);
    $class2 = Service::loadModel($class2);

    if(($class->modelName == $class1->modelName) && empty($records)){
      $records = $class->getAttributes();
    }

    if(array_key_exists($field1,$records)) {

      $_records = $class2->where($field2,'=',$records[$field1])->get();

      foreach ($_records as $key => $_record) {
        $temp[] = $_record;
      }

      $records = $temp;

    }else{

      foreach ($records as $key => $record) {

        if(empty($record[$field1])) {
          continue;
        }

        $_records = $class2->where($field2,'=',$record[$field1])->get();

        foreach ($_records as $key => $_record) {
          $temp[] = $_record->getAttributes();
        }
        
      }

      $records = $temp;

    }

    return $records;

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
