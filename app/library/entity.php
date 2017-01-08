<?php

namespace App\library;

class Entity
{
  private $slugName;
  private $model;

  public function __construct($slug) {
    $this->slugName = $slug->name;
    $this->model = service::loadModel($slug->model)->find($slug->model_id);
  }

  public function buildData() {

    return array_merge(
      array(
        'model' => $this->model,
        'slugName' => $this->slugName,
        'permission' => $this->getPermission(),
        'info' => $this->getInfo(),
      ),
      $this->getData()
    );

  }

  public function getInfo() {
    return array(
      'name' => $this->model->name,
      'description' => $this->model->description,
      'short_description' => strip_tags(String::subString($this->model->description,800)),
      // 'brand_story'
      // 'logo' => $logo,
      // 'cover' => $cover,
    );
  }

  public function getPermission() {

    $permission = array();

    $personhasEntity = $this->model->getRalatedDataByModelName('PersonHasEntity',
      array(
        'first' => true,
        'conditions' => [['person_id','=',session()->get('Person.id')]]
      )
    );

    if(!empty($personhasEntity)) {
      $pagePermission = $personhasEntity->role;

      $permission = array(
        'add' => $personhasEntity->role->adding_permission,
        'edit' => $personhasEntity->role->editing_permission,
        'delete' => $personhasEntity->role->deleting_permission,
      );
    }

    return $permission;

  }

  public function getData() {

    $additionalData = array();
    if(!empty($this->model->relatedModel)){
      foreach ($this->model->relatedModel as $key => $modelName) {

        if(is_array($modelName)){
          $modelName = $key;
        }

        $model = Service::loadModel($modelName);
        
        $data = array();
        switch ($modelName) {
          case 'Address':
            $data = $this->getAddress();
            break;
          
          case 'Tagging':
            $data = $this->getTagging();
            break;

          case 'OfficeHour':
            $data = $this->getOfficeHour();
            break;

          case 'Contact':
            $data = $this->getContact();
            break;
        }

        $additionalData[$modelName] = $data;

      }
    }  

    return $additionalData;

  }

  public function getAddress() {
    $address = $this->model->getRalatedDataByModelName('Address',array(
      'fields' => array('address','district_id','sub_district_id','description')
    ));

    if(empty($address)) {
      return null;
    }

    // get district and subdistrict
    $address = array_merge($address->getAttributes(),array(
      'districtName' => $address->district->name,
      'subDistrictName' => $address->subDistrict->name,
      'fullAddress' => strip_tags($address->address).' '.$address->subDistrict->name.' '.$address->district->name.' ชลบุรี'
    ));

    return $address;
  }

  public function getTagging() {
    $taggings = $this->model->getRalatedDataByModelName('Tagging',
      array(
        'fields' => array('word_id')
      )
    );

    if(empty($taggings)) {
      return null;
    }

    $words = array();
    foreach ($taggings as $tagging) {
      $words[] = array(
        // 'id' =>  $tagging->word->id,
        'name' =>  $tagging->word->word
      );
    }

    return $words;

  }

  public function getOfficeHour() {
    $officeHour = $this->model->getRalatedDataByModelName('OfficeHour',
      array(
        'first' => true,
        'fields' => array('time')
      )
    );

    if(empty($officeHour)) {
      return null;
    }

    $workingTime = json_decode($officeHour->time,true);

    $today = date('N');
    $officeHour = array(
      // 'display' => true,
      'status' => array(
        'name' => 'status-close',
        'text' => 'วันนี้ปิดทำการ'
      ),
      'workingTime' => array()
    );
    $day = Service::loadModel('Day');
    foreach ($workingTime as $key => $time) {

      $startTime = explode(':', $time['start_time']);
      $endTime = explode(':', $time['end_time']);

      $_time = 'ปิด';
      if($time['open']){
        $_time = $startTime[0].':'.$startTime[1].'-'.$endTime[0].':'.$endTime[1];
      }

      if(($today == $key) && $time['open']) {
        $officeHour['status'] =  array(
          'name' => 'status-open',
          'text' => 'วันนี้เปิดทำการ '.$_time
        );
      }

      $officeHour['workingTime'][$key] = array(
        'day' => $day->find($key)->name,
        'workingTime' => $_time
      );

    }

    return $officeHour;

  }

  public function getContact() {
    $contact = $this->model->getRalatedDataByModelName('Contact',array(
      'fields' => array('phone_number','email','website','facebook','instagram','line')
    ));

    if(empty($contact)) {
      return null;
    }

    return $contact->getAttributes();
  } 

}

?>