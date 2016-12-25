<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class JobRequest extends FormRequest
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
        'name.required' => 'กรุณากรอกชื่อตำแหน่องงาน',
        'salary.required' => 'กรุณากรอกเงินเดือน',
        'nationality.required' => 'กรุณากรอกสัญชาติ',
        'age.required' => 'กรุณากรอกอายุ',
        'educational_level.required' => 'กรุณากรอกระดับการศึกษา',
        'experience.required' => 'กรุณากรอกประสบการณ์การทำงาน',
        'number_of_position.required' => 'กรุณากรอกจำนวนที่รับ',
        'number_of_position.numeric' => 'กรุณากรอกจำนวนที่รับเป็นตัวเลข',
        'description.required' => 'กรุณากรอกรายละเอียดงาน',
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
          // 'name' => 'required|max:255',
          // 'salary' => 'required|max:255',
          // 'nationality' => 'required|max:255',
          // 'age' => 'required|max:255',
          // 'educational_level' => 'required|max:255',
          // 'experience' => 'required|max:255',
          // 'number_of_position' => 'required|numeric|max:3', 
          // 'description' => 'required'
        ];
    }
}
