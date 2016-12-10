<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class CompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
      // Only allow logged in users
      return Auth::check();
    }

    public function messages()
    {
      return [
        'name.required' => 'กรุณากรอกชื่อสถานประกอบการ',
        'email.email' => 'อีเมลไม่ถูกต้อง',
        'email.unique' => 'อีเมลถูกใช้งานแล้ว',
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
          'email' => 'email|unique:users,email',
        ];
    }
}
