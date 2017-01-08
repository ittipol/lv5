<?php

namespace App\library;

class Form {
  
  private $model;
  private $data;

  public function __construct($model) {
    $this->model = $model;
    $this->data[lcfirst($this->model->modelName)] = $this->model->getAttributes();
  }

  public function getRequiredFormData($requiredData){
    foreach ($requiredData as $modelName => $options) {
      $this->_getRequiredFormData($modelName,$options);
    }
  }

  private function _getRequiredFormData($modelName,$options = array()){
    $model = Service::loadModel($modelName);

    $records = array();
    if(!empty($options['conditions']) && is_array($options['conditions'])) {
      $records = $model->where($options['conditions']);
    }else{
      $records = $model->all();
    }

    $data = array();
    foreach ($records as $key => $record) {
      // $data[$record->{$options['key']}] = $record->{$options['field']};
      if(is_array($options['field'])){

        $arr = current($options['field']);
        
        switch (key($options['field'])) {
          case 'relation':
            $_data[$record->{$options['key']}] = $record->{$arr['with']}->{$arr['field']};
            break;
          
          case 'fx':
            $_data[$record->{$options['key']}] = $record->{$arr}();
            break;
        }

      }else{
        $data[$record->{$options['key']}] = $record->{$options['field']};
      }

    }

    $this->data[$options['name']] = $data;
  
    return $data;
  }

  public function getRelatedData($relatedModel = array()) {
    foreach ($relatedModel as $key => $modelName) {

      if(is_array($modelName)){
        $modelName = $key;
      }

      $this->_getRelatedData($modelName);

    }
  }


  private function _getRelatedData($modelName,$options = array()) {

    switch ($modelName) {
      case 'Address':
        $address = $this->model->getRalatedDataByModelName('Address',
          array(
            'first' => true,
            'fields' => array('address','district_id','sub_district_id','description','lat','lng')
          )
        );

        if(empty($address)) {
          $this->data['address'] = array();
          $this->data['geographic'] = json_encode(array());
          break;
        }

        $geographic = array();
        if(!empty($address['lat']) && !empty($address['lng'])) {
          $geographic['lat'] = $address['lat'];
          $geographic['lng'] = $address['lng'];
        }

        $this->data['address'] = $address->getAttributes();
        $this->data['geographic'] = json_encode($geographic);

        break;

      case 'Tagging':
        $taggings = $this->model->getRalatedDataByModelName('Tagging',
          array(
            'fields' => array('word_id')
          )
        );

        if(empty($taggings)){
          $this->data['taggings'] = json_encode(array());
          break;
        }

        $word = array();
        foreach ($taggings as $tagging) {
          $word[] = array(
            'id' =>  $tagging->word->id,
            'name' =>  $tagging->word->word
          );
        }
        
        $this->data['taggings'] = json_encode($word);

        break;

      case 'OfficeHour':

        $officeHour = $this->model->getRalatedDataByModelName('OfficeHour',array(
          'first' => true,
          'fields' => array('same_time','time')
        ));

        if(empty($officeHour)){
          $this->data['officeHour'] = array();
          break;
        }

        $this->data['sameTime'] = $officeHour->same_time;

        $time = json_decode($officeHour->time,true);
        $officeHour = array();
        foreach ($time as $day => $value) {

          $startTime = explode(':', $value['start_time']);
          $endTime = explode(':', $value['end_time']);

          $officeHour[$day] = array(
            'open' => $value['open'],
            'start_time' => array(
              'hour' => (int)$startTime[0],
              'min' => (int)$startTime[1]
            ),
            'end_time' => array(
              'hour' => (int)$endTime[0],
              'min' => (int)$endTime[1]
            )
          );
        }

        $this->data['officeHour'] = json_encode($officeHour);

        break;

      case 'Contact':

        $contact = $this->model->getRalatedDataByModelName('Contact',array(
          'first' => true,
          'fields' => array('phone_number','email','website','facebook','instagram','line')
        ));

        if(empty($contact)) {
          $this->data['contact'] = array();
          break;
        }

        $this->data['contact'] = $contact->getAttributes();

        break;

    }

  }

  public function get() {
    return $this->data;
  }

  public function clear() {
    $this->data = null;
  }

}

?>