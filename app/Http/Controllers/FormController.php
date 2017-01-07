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

  // protected $allowed = array('Company','Department','Job','Product');
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

    // Add form token to session
    Session::put($this->formToken,$options);
  }

  public function form($action) {

    $this->setFormToken(array(
      'action' => $action,
    ));

    $this->form->loadRequiredFormData($this->formModel->form['requiredModelData']);

    if(!empty($this->formModel->form['relatedModel']) && ($action == 'edit')){
      $this->form->loadData($this->formModel->form['relatedModel']);
    }
    
    $this->data = array_merge(array(
      'modelName' => $this->formModel->modelName,
      'action' => $action,
      'form' => $this->formModel->form[$action],
    ),$this->form->get());

    return $this->view('form.'.$action.'.'.$this->formModel->modelAlias);
  }

  public function formSave($request,$type = null) {

    $this->formModel->fill($request->all());

    if($this->formModel->save()){
      // delete temp dir & records
      $this->formModel->deleteTempData();
      // reomove form token
      Session::forget($this->formModel->formToken);

      $message = new Message;
      $message->addingSuccess('ร้านค้าหรือสถานประกอบการ');
    }else{
      $message = new Message;
      // $message->cannotAdd();
      $message->error('ไม่สามารถเพิ่มสถานประกอบการหรือร้านค้า กรุณาลองใหม่อีกครั้ง');
      return Redirect::back();
    }

    return Redirect::to($this->to($this->formModel));

  }

  public function formAdd() {
    return $this->form('add');
  }

  public function add(CustomFormRequest $request) {

    return $this->formSave($request,'add');

    // $this->formModel->fill($request->all());

    // if($this->formModel->save()){
    //   // delete temp dir & records
    //   $this->formModel->deleteTempData();
    //   // reomove form token
    //   Session::forget($this->formModel->formToken);

    //   $message = new Message;
    //   $message->addingSuccess('ร้านค้าหรือสถานประกอบการ');
    // }else{
    //   $message = new Message;
    //   // $message->cannotAdd();
    //   $message->error('ไม่สามารถเพิ่มสถานประกอบการหรือร้านค้า กรุณาลองใหม่อีกครั้ง');
    //   return Redirect::back();
    // }

    // return Redirect::to($this->to($this->formModel));

  }

  public function formEdit() {
    return $this->form('edit');
  }

  public function edit(CustomFormRequest $request) {

    // if(!$this->pagePermission['edit']) {}
    $this->formModel->fill($request->all());

    if($this->formModel->save()){
      // delete temp dir & records
      $this->formModel->deleteTempData();
      // reomove form token
      Session::forget($this->formModel->formToken);

      $message = new Message;
      $message->addingSuccess('ร้านค้าหรือสถานประกอบการ');
    }else{
      $message = new Message;
      // $message->cannotAdd();
      $message->error('ไม่สามารถเพิ่มสถานประกอบการหรือร้านค้า กรุณาลองใหม่อีกครั้ง');
      return Redirect::back();
    }
dd('edited');
    return Redirect::to($this->to($this->formModel));

  }

  private function to($model) {

    $to = '/';
    if(($model->modelName == 'Company') || ($model->modelName == 'OnlineShop')) {
      $to = $model->getRalatedDataByModelName('Slug',
        array(
          'first' => true
        )
      )->name;
    }

    return $to;

  }

}
