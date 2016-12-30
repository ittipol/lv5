<?php

namespace App\Http\Controllers;

use App\library\service;
use Route;
use Redirect;
use Session;

class FormController extends Controller
{
  private $model;
  private $modelAlias;

  public function __construct(array $attributes = []) { 

    $this->formToken = Token::generateformToken(Session::get('Person.id'));

    $param = Route::current()->parameters();

    $modelName = service::generateModelByModelAlias($param['modelAlias']);

    $this->modelAlias = $param['modelAlias'];
    $this->model = service::loadModel($modelName);
  }

  public function formAdd() {
    
    dd($this->model->allowedRelatedModel);

    // set form token
    Session::put($this->formToken,1);

    return $this->view('pages.'.$this->modelAlias.'.form.add');

  }

  public function add() {

    $this->model->fill($request->all());

    if($this->model->save()){

    }

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
      $this->data['districts'] = $_districts;
    }
    
    return $_districts;

  }

}
