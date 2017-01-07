<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\library\service;
use Auth;
use Route;
use Request;

class CustomFormRequest extends FormRequest
{
  private $model;

  public function __construct() {dd(Request::all());
    $data = Request::all();
    $this->model = service::loadModel($data['model']);
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

    return $this->model->validation['rules'];
  }
}
