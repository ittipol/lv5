<?php

namespace App\library;

class Form {
  
  private $model;
  private $data;

  public function __construct($model) {
    $this->model = $model;
  }

  public function loadData($modelName,$options = array()) {

    switch ($modelName) {
      case 'Address':
        $address = $this->model->getRalatedDataByModelName('Address',
          array(
            'onlyFirst' => true,
            'fields' => array('address','district_id','sub_district_id','description','lat','lng')
          )
        );

        if(empty($address)) {
          $this->data['address'] = array();
          $this->data['geographic'] = array();
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
          $this->data['taggings'] = array();
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
          'onlyFirst' => true,
          'fields' => array('time')
        ));

        if(empty($officeHour)){
          $this->data['officeHour'] = array();
          break;
        }

        $time = json_decode($officeHour->time,true);
        $officeHour = array();
        foreach ($time as $day => $value) {

          $_startTime = explode(':', $value['start_time']);
          $_endTime = explode(':', $value['end_time']);

          $_officeHours[$day] = array(
            'open' => $value['open'],
            'start_time' => array(
              'hour' => (int)$_startTime[0],
              'min' => (int)$_startTime[1]
            ),
            'end_time' => array(
              'hour' => (int)$_endTime[0],
              'min' => (int)$_endTime[1]
            )
          );
        }

        $this->data['officeHour'] = json_encode($officeHour);

        break;

      case 'Contact':

        $contact = $this->model->getRalatedDataByModelName('Contact',array(
          'onlyFirst' => true,
          'fields' => array('phone_number','email','website','facebook','instagram','line')
        ));

        if(empty($contact)) {
          $this->data['contact'] = array();
          break;
        }

        $this->data['contact'] = $contact->getAttributes();

      case 'Contact':

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