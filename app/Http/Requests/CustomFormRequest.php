<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\library\service;
use Auth;
use Route;

class CustomFormRequest extends FormRequest
{
  private $model;

  public function __construct(array $attributes = []) { 
    $this->param = Route::current()->parameters();
    $this->model = service::loadModel(service::generateModelNameByModelAlias($this->param['modelAlias']));
  }

  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return Auth::check();
  }

  public function messages()
  {
    return $this->model->validation['messages'];
  }

  public function rules()
  {
    return $this->model->validation['rules'];
  }
}
