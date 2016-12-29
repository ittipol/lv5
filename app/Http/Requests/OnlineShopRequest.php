<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;
use Validator;

class OnlineShopRequest extends FormRequest
{
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
    return [
      'name.required' => 'กรุณากรอกชื่อร้านค้า',
      'Contact.email.email' => 'อีเมลไม่ถูกต้อง',
      'Contact.email.unique' => 'อีเมลถูกใช้งานแล้ว',
    ];
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'name' => 'required|max:255',
      'Contact.phone_number' => 'max:255',
      'Contact.website' => 'max:255',
      'Contact.email' => 'email|unique:contacts,email|max:255',
      'Contact.facebook' => 'max:255',
      'Contact.instagram' => 'max:255',
      'Contact.line' => 'max:255'
    ];
  }
}
