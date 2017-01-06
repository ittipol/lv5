<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomFormRequest;
use App\library\service;
use App\library\token;
use App\library\message;
use App\library\Form;
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
    $this->loadRequiredFormData($this->model->form['requiredModelData']);

    $this->data = array(
      'type' => 'add',
      'form' => $this->model->form['add'],
    );

    return $this->view('form.add.'.$this->modelAlias);
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
    $this->loadRequiredFormData($this->slugModel->form['requiredModelData']);

    $form = new Form($this->slugModel);

    foreach ($this->slugModel->allowed['relatedModel'] as $key => $modelName) {

      if(is_array($modelName)){
        $modelName = $key;
      }

      $form->loadData($modelName);

    }
dd($form->get());
    $data = array();

    $this->data = array(
      'type' => 'edit',
      'form' => $this->slugModel->form['edit'],
    );

    return $this->view('form.edit.'.$this->modelAlias);

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

  private function loadRequiredFormData($RequiredData){
    foreach ($RequiredData as $modelName => $options) {
      $this->loadFormData($modelName,$options);
    }
  }

  private function loadFormData($modelName,$options = array()){
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

    $this->formData[$options['name']] = $data;
  
    return $data;
  }

}
