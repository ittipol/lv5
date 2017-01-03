<?php

namespace App\Http\Controllers;

use App\library\service;
use App\library\token;
use Redirect;
use Session;

class FormController extends Controller
{

  protected $allowedAdd = array('Company','Department','Job','Product'); 

  public function __construct(array $attributes = []) { 

    parent::__construct();

    // Generate Form token
    $this->middleware(function ($request, $next) {
      $this->formToken = Token::generateformToken(Session::get('Person.id'));
      return $next($request);
    });

  }

  public function formAdd() {
    
    // dd($this->model->allowedRelatedModel);

    // set form token
    // Session::put($this->formToken,1);

    // return $this->view('form.form');

    return $this->view('form.forms.company');

    // return $this->view('pages.'.$this->modelAlias.'.form.add');

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
      $this->formData['districts'] = $_districts;
    }
    
    return $_districts;

  }

}
