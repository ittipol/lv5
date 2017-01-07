<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\library\service;
// use Auth;
// use Route;
use Request;
use Session;

class CustomFormRequest extends FormRequest
{
  // private $model;
  public $formTokenData;

  public function __construct() {
    $data = Request::all();
    $this->formTokenData = Session::get($data['__token']);
    $this->model = service::loadModel($this->formTokenData['modelName']);
  }

  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
    // return Auth::check();
  }

  public function messages()
  {
    return $this->model->validation['messages'];
  }

  public function rules()
  {

    // '__token' => 'required',
    // 'model' => 'required'

    $rules = array();
    foreach ($this->model->validation['rules'] as $key => $value) {

      if(in_array($key, $this->model->form['fieldsExceptValidation'][$this->formTokenData['action']])) {
        continue;
      }

      $rules[$key] = $value;
    }

    return $rules;
  }
}
