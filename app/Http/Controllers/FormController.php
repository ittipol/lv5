<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomFormRequest;
use App\library\service;
use App\library\token;
use App\library\message;
use Redirect;
use Session;
// use Request;

class FormController extends Controller
{

  protected $allowedAdd = array('Company','Department','Job','Product'); 

  public function __construct(array $attributes = []) { 

    parent::__construct();

    // $this->middleware(function ($request, $next) {
    //   // (Request::method() == 'POST')
    //   return $next($request);
    // });

  }

  private function setFormToken() {
    // Generate form token
    $this->formToken = Token::generateformToken(Session::get('Person.id'));
    // Add form token to session
    Session::put($this->formToken,1);
  }

  public function formAdd() {
    $this->setFormToken();
    $this->loadRequiredFormData($this->model->modelName);
    return $this->view('form.forms.add.'.$this->modelAlias);
  }

  public function add(CustomFormRequest $request) {

    $this->model->fill($request->all());

    if($this->model->save()){
      // delete temp dir & records
      $this->model->deleteTempData();
      // reomove form token
      Session::forget($this->model->formToken);

      $message = new Message;
      $message->addingSuccess('ร้านค้าหรือสถานประกอบการ');
    }else{
      $message = new Message;
      // $message->cannotAdd();
      $message->error('ไม่สามารถเพิ่มสถานประกอบการหรือร้านค้า กรุณาลองใหม่อีกครั้ง');
      return Redirect::back();
    }

    return Redirect::to($this->to($this->model));

  }

  public function formEdit() {
    // $this->setFormToken();
    $this->loadRequiredFormData($this->slugModel->modelName);
// dd($this->slugModel->allowedRelatedModel);
    $data = array();
    // foreach ($this->slugModel->allowedRelatedModel as $modelName) {
    //   $this->loadData($modelName);
    // }

    // foreach ($this->slugModel->allowedDir['dirNames'] as $dirName) {
    //  $this->loadImages($this->slugModel,$dirName,$dirName.'Json');
    // }

    $this->data = array(
      'formType' => 'add'
    );

    return $this->view('form.forms.add.'.$this->modelAlias);

  }

  private function loadData($modelName) {

    switch ($modelName) {
      case 'Address':
        $this->loadAddress($this->slugModel);
        break;

      case 'Tagging':
        $this->loadTaggings($this->slugModel,'tagJson');
        break;
      
      case 'OfficeHour':
        $this->loadOfficehour($this->slugModel,'officeHoursJson');
        break;

      case 'Contact':
        $this->loadContact($this->slugModel,'contactJson');
        break;
    }

  }

  private function loadSpecifiedData($model,$modelName,$options = array()) {

    $records = $model->getRalatedDataByModelName($modelName,$options['relatedData']);

    $_data = array();
    if(!empty($records) && !empty($options['dataFormat'])){
      foreach ($records as $key => $record) {
        foreach ($options['dataFormat'] as $format) {

          if(is_array($format['field'])){

            $arr = current($format['field']);

            switch (key($format['field'])) {
              case 'relation':
                $_data[$key][$format['key']] = $record->{$arr['with']}->{$arr['field']};
                break;
              
              case 'fx':
                $_data[$key][$format['key']] = $record->{$arr}();
                break;
            }

          }else{
            $_data[$key][$format['key']] = $record->{$format['field']};
          }

        }
      }
    }

    if(!empty($options['json'])){
      $_data = json_encode($_data);
    }

    if(!empty($options['dataIndexName'])) {
      $data[$options['dataIndexName']] = $_data;
    }else{
      $data = $_data;
    }

    if(!empty($options['passToview'])){
      if(is_array($data)){
        $this->formData[$options['dataIndexName']] = $data[$options['dataIndexName']];
      }else{
        $this->formData = $data;
      }
    }

    return $data;
  }

  private function loadOfficehour($model) {

    $officeHour = $model->getRalatedDataByModelName('OfficeHour',array(
      'onlyFirst' => true,
      'fields' => array('time')
    ));

    if(!empty($officeHour)){
      $time = json_decode($officeHour->time,true);

      $officeHour = array();
      foreach ($time as $day => $value) {

        $_startTime = explode(':', $value['start_time']);
        $_endTime = explode(':', $value['end_time']);

        $officeHour[$day] = array(
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
    }

    $this->formData['officeHoursJson'] = json_encode($officeHour);

    return $officeHour;

  }

  private function loadContact($model) {
    $contact = $model->getRalatedDataByModelName('Contact',array(
      'onlyFirst' => true,
      'fields' => array('phone_number','email','website','facebook','instagram','line')
    ));

    if(!empty($contact)) {
      $contact = $contact->getAttributes();
    }

    $this->formData['contact'] = $contact;

    return $contact;
  }

  private function loadImages($model,$type,$dataIndexName) {
    return $this->loadSpecifiedData($model,'Image',array(
      'dataIndexName' => $dataIndexName,
      'json' => true,
      'passToview' => true,
      'relatedData' => array(
        'conditions' => [['type','=',$type]],
        'fields' => array('name')
      ),
      'dataFormat' => array(
        array(
          'key' => 'name',
          'field' => 'name'
        ),
        array(
          'key' => 'url',
          'field' => array(
            'fx' => 'getImageUrl'
          )
        )
      )
    ));
  }

  private function loadTaggings($model,$dataIndexName) {
    return $this->loadSpecifiedData($model,'Tagging',array(
      'dataIndexName' => $dataIndexName,
      'json' => true,
      'passToview' => true,
      'relatedData' => array(
        'fields' => array('word_id'),
      ),
      'dataFormat' => array(
        array(
          'key' => 'id',
          'field' => array(
            'relation' => array(
              'with' => 'word',
              'field' => 'id'
            )
          )
        ),
        array(
          'key' => 'name',
          'field' => array(
            'relation' => array(
              'with' => 'word',
              'field' => 'word'
            )
          )
        )
      )
    ));
  }

  private function loadAddress($model) {

    $address = $model->getRalatedDataByModelName('Address',
      array(
        'onlyFirst' => true,
        'fields' => array('address','district_id','sub_district_id','description','lat','lng')
      )
    );
  dd($address);
    if(!empty($address)) {
      $address = $address->getAttributes();
    }

    $this->formData['address'] = $address;

    $geography = array();
    if(!empty($address['lat']) && !empty($address['lng'])) {
      $geography['lat'] = $address['lat'];
      $geography['lng'] = $address['lng'];
    }

    $this->formData['geography'] = json_encode($geography);

    return $address;
  }

  // public function edit(CustomFormRequest $request) {
  // }

  private function to($model) {

    $to = '/';
    if(($model->modelName == 'Company') || ($model->modelName == 'OnlineShop')) {
      $to = $model->getRalatedDataByModelName('Slug',
        array(
          'onlyFirst' => true
        )
      )->name;
    }

    return $to;

  }

  private function loadRequiredFormData($modelName){

    switch ($modelName) {
      case 'Company':

        $this->loadFormData('District',array(
          'key' => 'id',
          'field' => 'name',
          'indexName' => 'districts'
        ));

        $this->loadFormData('BusinessEntity',array(
          'key' => 'id',
          'field' => 'name',
          'indexName' => 'businessEntities'
        ));

        break;

      case 'OnlineShop':

       break;

    }

  }

  private function loadFormData($modelName,$options = array(),$pass = true){
    $model = Service::loadModel($modelName);

    $records = array();
    if(!empty($options['conditions']) && is_array($options['conditions'])) {
      // $_conditions = [
      //   ['model','=',$this->modelName],
      //   ['model_id','=',$this->id],
      // ];

      // $conditions = array_merge($conditions,$_conditions);

      $records = $model->where($options['conditions']);
    }else{
      // Get all
      $records = $model->all();
    }

    $data = array();
    foreach ($records as $record) {
      $data[$record->{$options['key']}] = $record->{$options['field']};
    }

    if($pass){
      $this->formData[$options['indexName']] = $data;
    }

    return $data;
  }

}
