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
      $message->error('ไม่สามารถเพิ่มสถานประกอบการหรือร้านค้า กรุณาลองใหม่อีกครั้ง');
      return Redirect::back();
    }

    return Redirect::to($this->to($this->model));

  }

  public function formEdit() {
    // $this->setFormToken();
    $this->loadRequiredFormData($this->slugModel->modelName);

    // $this->loadAddress($this->slugModel);

    $this->loadImage($this->slugModel,'logo',array(
      'conditons' => [['type','=','logo']],
      'field' => 'name',
      'indexName' => 'logoJson'
    ));

    $this->loadImage($this->slugModel,'cover',array(
      'conditons' => [['type','=','cover']],
      'field' => 'name',
      'indexName' => 'coverJson'
    ));

    $this->loadImage($this->slugModel,'images',array(
      'conditons' => [['type','=','images']],
      'field' => 'name',
      'indexName' => 'imagesJson'
    ));

    // load tag

    $taggings = $company->getRalatedDataByModelName('Tagging');
    $_words = array();
    if(!empty($taggings)){
      foreach ($taggings as $tagging) {
        $_words[] = array(
          'id' =>  $tagging->word->id,
          'name' =>  $tagging->word->word
        );
      }
    }

  }

  private function loadImage($model,$type,$options = array()) {
    $images = $model->getRalatedDataByModelName('Image',false,$options['conditons']);

    $data = array();
    foreach ($images as $image) {
      $data[] = array(
        'name' => $image->{$options['field']},
        'url' => $image->getImageUrl()
      );
    }

    $this->formData[$options['indexName']] = json_encode($data); 

    return json_encode($data);

  }

  // private function loadAddress($model,$pass = true) {
  //   $address = $model->getRalatedDataByModelName('Address',true);
  //   $geographic = array();
  //   if(!empty($address->lat) && !empty($address->lng)) {
  //     $geographic['lat'] = $address->lat;
  //     $geographic['lng'] = $address->lng;
  //   }

  //   'geographic' => json_encode($geographic)

  // }

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

        $this->loadData('District',array(
          'key' => 'id',
          'field' => 'name',
          'indexName' => 'districts'
        ));

        $this->loadData('BusinessEntity',array(
          'key' => 'id',
          'field' => 'name',
          'indexName' => 'businessEntities'
        ));

        break;

      case 'Company':

       break;

    }

  }

  private function loadData($modelName,$options = array(),$pass = true){
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
