<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomFormRequest;
use App\Models\BusinessEntity;
use App\Models\District;
use App\library\service;
use App\library\token;
use App\library\message;
use Redirect;
use Session;
use Request;

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

    $districts = District::all();
    $_districts = array();
    foreach ($districts as $district) {
      $_districts[$district->id] = $district->name;
    }

    $businessEntities = BusinessEntity::all();
    $_businessEntities = array();
    foreach ($businessEntities as $businessEntity) {
      $_businessEntities[$businessEntity->id] = $businessEntity->name;
    }

    // return $this->view('form.form');

    $this->data = array(
      'districts' => $_districts,
      'businessEntities' => $_businessEntities
    );

    return $this->view('form.forms.add.'.$this->modelAlias);

  }

  public function add(CustomFormRequest $request) {

    $this->model->fill($request->all());

    if($this->model->save()){
      // delete temp dir & records
      $this->model->deleteTempData();
      // reomove form token
      Session::forget($this->model->formToken);
dd('saved');
      $message = new Message;
      $message->addingSuccess('ร้านค้าหรือสถานประกอบการ');
    }else{
      $message = new Message;
      $message->error('ไม่สามารถเพิ่มสถานประกอบการหรือร้านค้า กรุณาลองใหม่อีกครั้ง');
      // return Redirect::to('company/add');
    }
dd('reere');
    return Redirect::to('company/list');

  }

  // public function formAddCompany() {

  // }

  private function getAllDistricts($pass = true){
    $districts = District::all();
    $_districts = array();
    foreach ($districts as $district) {
      $_districts[$district->id] = $district->name;
    }

    // pass value
    if($pass){
      $this->formData['districts'] = $_districts;
    }
    
    return $_districts;

  }

}
