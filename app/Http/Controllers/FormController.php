<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomFormRequest;
use App\library\service;
use App\library\token;
use App\library\message;
use App\library\Form;
use Redirect;
use Session;
use Request;

class FormController extends Controller
{

  private $allowedModel = array('Company','Department','Job','Product');
  private $form;
  private $formModel;

  public function __construct(array $attributes = []) { 

    parent::__construct();

    $this->middleware(function ($request, $next) {

      if(!empty($this->model)) {
        $this->formModel = $this->model;
      }else{
        $this->formModel = $this->slugModel;
      }

      $this->form = new Form($this->formModel);

      if((strtolower(Request::method()) == 'post') || (strtolower(Request::method()) == 'patch')) {
        // dd(Session::all());
        // check form token
        // dd(Request::all());

        // if(empty(Session::get({formToken}))) {
        //   return false;
        // }
      }

      return $next($request);
    });

  }

  private function setFormToken($options = array()) {
    // Generate form token
    $this->formToken = Token::generateformToken(Session::get('Person.id'));

    $options = array_merge($options,array(
      'time' => time(),
      'modelName' => $this->formModel->modelName
    ));

    // can include some data controll form model
    // etc. company_id

    // Add form token to session
    Session::put($this->formToken,$options);
  }

  private function form($action) {

    $this->setFormToken(array(
      'action' => $action,
    ));

    $this->form->getRequiredFormData($this->formModel->form['requiredModelData']);

    if(!empty($this->formModel->$relatedModel) && ($action == 'edit')){
      $this->form->getRelatedData($this->formModel->$relatedModel);
    }

    $this->data = array_merge(array(
      'modelName' => $this->formModel->modelName,
      'action' => $action,
      'form' => $this->formModel->form['template'][$action],
    ),$this->form->get());

    return $this->view('form.template.'.$action.'.'.$this->formModel->modelAlias);
  }

  private function formSubmit($request) {

    $message = new Message;

    $this->formModel->fill($request->all());

    if($this->formModel->save()){
      // delete temp dir & records
      $this->formModel->deleteTempData();
      // reomove form token
      Session::forget($this->formModel->formToken);

      $message->display($this->formModel->form['messages'][$request->formTokenData['action']]['success'],'success');

      // $message->addingSuccess('ร้านค้าหรือสถานประกอบการ');
    }else{
      $message->display($this->formModel->form['messages'][$request->formTokenData['action']]['fail'],'error');
      // $message->error('ไม่สามารถเพิ่มสถานประกอบการหรือร้านค้า กรุณาลองใหม่อีกครั้ง');
      return Redirect::back();
    }

    return Redirect::to($this->to($this->formModel));

  }

  public function formAdd() {
    return $this->form('add');
  }

  public function add(CustomFormRequest $request) {
    return $this->formSubmit($request);
  }

  public function formEdit() {
    return $this->form('edit');
  }

  public function edit(CustomFormRequest $request) {

    // check time out 20 mins

    // dd($request->formTokenData);
    return $this->formSubmit($request);

  }

  private function to($model) {

    $to = '/';
    if(($model->modelName == 'Company') || ($model->modelName == 'OnlineShop')) {
      $to = $model->getRalatedDataByModelName('Slug',
        array(
          'first' => true,
          'fields' => array('name')
        )
      )->name;
    }

    return $to;

  }

}
