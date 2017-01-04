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
    foreach ($this->slugModel->allowedRelatedModel as $modelName) {
      $data[] = Service::loadModel($modelName)->loadAndBuildToForm();
    }

    $this->loadGeography($this->loadAddress($this->slugModel));
    $this->loadOfficehour($this->slugModel);
    // $geography = array();
    // if(!empty($address->lat) && !empty($address->lng)) {
    //   $geography['lat'] = $address->lat;
    //   $geography['lng'] = $address->lng;
    // }

    // load images
    // model Image->loadAndBuildDataForForm('logo','logoJson');
    // __buildFormData();
    $this->loadImages($this->slugModel,'logo','logoJson');
    $this->loadImages($this->slugModel,'cover','coverJson');
    $this->loadImages($this->slugModel,'images','imagesJson');
    // load Taggings
    $this->loadTaggings($this->slugModel,'tagJson');

    dd($this->formData);
  }

  private function loadData($model,$modelName,$options = array()) {

    $conditons = array();
    if(!empty($options['conditons'])){
      $conditons = array_merge($options['conditons'],$conditons);
    }

    $records = $model->getRalatedDataByModelName($modelName,false,$conditons);

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

  private function loadImages($model,$type,$dataIndexName) {
    return $this->loadData($model,'Image',array(
      'dataIndexName' => $dataIndexName,
      'json' => true,
      'passToview' => true,
      'conditons' => [['type','=',$type]],
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
    return $this->loadData($model,'Tagging',array(
      'dataIndexName' => $dataIndexName,
      'json' => true,
      'passToview' => true,
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
    $address = $model->getRalatedDataByModelName('Address',true);

    $_address = null;
    if($address){
      $_address = $address->getAttributes();
    }

    $this->formData['address'] = $_address;

    return $_address;
  }

  private function loadGeography($address) {

    $geography = array();

    if(!empty($address['lat']) && !empty($address['lng'])) {
      $geography['lat'] = $address['lat'];
      $geography['lng'] = $address['lng'];
    }

    $this->formData['geography'] = json_encode($geography);

    return $geography;
  }

  private function loadOfficehour($model) {

  }

  public function edit(CustomFormRequest $request) {

  }

  private function to($model) {

    $to = '/';
    if(($model->modelName == 'Company') || ($model->modelName == 'OnlineShop')) {
      $to = $model->getRalatedDataByModelName('Slug',true)->name;
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
      // $_conditons = [
      //   ['model','=',$this->modelName],
      //   ['model_id','=',$this->id],
      // ];

      // $conditons = array_merge($conditons,$_conditons);

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
