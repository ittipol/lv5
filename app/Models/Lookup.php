<?php

namespace App\Models;

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

  // public function __construct() {  
  //   parent::__construct();
  // }

  public function __saveRelatedData($model,$options = array()) {

    if(empty($model->allowed['Lookup']['format'])) {
      return false;
    }

    $value = array();

    $data = $model->getAttributes();
    if(!empty($options['data'])){
      $data = array_merge($data,$options['data']);
    }

    $taggings = $model->getRalatedDataByModelName('Tagging');

    $_words = array();
    if(!empty($taggings)){
      foreach ($taggings as $tagging) {
        $_words[] = $tagging->word->word;
      }
    }

    if(!empty($_words)){
      $value['words'] = implode(' ',$_words);
    }

    $_addresses = $this->__getAddress($model);
    if($_addresses){
      $value['address'] = $_addresses;
    }

    $options = array(
      'data' => $data,
      'format' => $model->allowed['Lookup']['format']
    );

    // Parser
    $result = $this->parser($model,$options);

    if(!empty($result)){
      foreach ($result as $key => $_value){
        $value[$key] = $_value;
      }
    }

    // Get releated lookup data
    $lookup = $model->getRalatedDataByModelName($this->modelName,
      array(
        'first' => true
      )
    );

    if(($model->state == 'update') && !empty($lookup)){
      return $lookup
      ->setFormToken($this->formToken)
      ->fill($value)
      ->save();
    }else{
      return $this->fill($model->includeModelAndModelId($value))->save();
    }

  }

  private function parser($model,$options = array()) {

    if(empty($options['format']) || empty($options['data'])){
      return false;
    }

    $parseFormat = '/{{[\w\d|._,=>@]+}}/';
    $parseValue = '/[\w\d|._,=>@]+/';

    $result = array();

    foreach ($options['format'] as $key => $format){

      if(is_array($format)){
        $records = $this->_parser($format['get'],$model,array(
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

        $result[$key] = $this->_clean($_value);

      }else{
        preg_match_all($parseFormat, $format, $matches);

        if(!empty($matches[0])){

          $result[$key] = $format;

          foreach ($matches[0] as $value) {

            preg_match_all($parseValue, $value, $_matches);

            if(!empty($_matches[0][0])){

              if(substr($_matches[0][0],0,2) == '__'){
                $_value = $this->{$_matches[0][0]}($model);
              }elseif(array_key_exists($_matches[0][0],$options['data'])) {
                $_value = $options['data'][$_matches[0][0]];
              }else{
                $parts = explode('|', $_matches[0][0]);

                if(!empty($parts[1])){

                  $records = $this->_parser($parts[0],$model,array(
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
  
  private function _parser($fields,$class,$options = array()) {

    $data = array();

    if(empty($class)){
      return false;
    }

    if(!empty($options['lookupStringFormat'])) {

      $lookup = new Lookup;

      $formats = explode(',', $options['lookupStringFormat']);

      $records = array();
      foreach ($formats as $format) {
        list($key1,$key2) = explode('=>', $format);
        $records = $this->__lookupFormatParser($class,$key1,$key2,$records);
      }

      $fields = explode('.', $fields);

      $data = array();
      foreach ($records as $key => $record) {
        $data[$fields[0]][$key][$fields[1]] = $record[$fields[1]];
      }

    }elseif(!empty($options['lookupArrayFormat'])) {

      $lookup = new Lookup;

      $formats = $options['lookupArrayFormat'];

      $records = array();
      foreach ($formats as $key1 => $key2) {
        $records = $this->__lookupFormatParser($class,$key1,$key2,$records);
      }

      $fields = explode('.', $fields);

      $data = array();
      foreach ($records as $key => $record) {
        $data[$fields[0]][$key][$fields[1]] = $record[$fields[1]];
      }
    }

    return $data;

  }

  private function __lookupFormatParser($class,$key1,$key2,$records = array()) {

    $temp = array();

    if(substr($key1, 0, 1) == '@') {
      $func = substr($key1, 1);
      $records = $class->{$func}($key2);
      
      foreach ($records as $key => $_record) {
        $temp[] = $_record;
      }

      return $temp;
    }

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

  private function __getAddress($model) {
    $addresses = $model->getRalatedDataByModelName('Address');

    $_address = array();
    foreach ($addresses as $address) {
      $_address[] = trim($address->district->name.' '.$address->subDistrict->name.' '.$address->address);
    }

    $_address = implode(' ', $_address);

    return $this->_clean($_address);

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
