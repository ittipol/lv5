<?php

namespace App\Models;

use App\Models\Model;
use App\Models\Day;

class OfficeHour extends Model
{
  public $table = 'office_hours';
  protected $fillable = ['model','model_id','day_id','start_time','end_time','open'];
  public $timestamps  = false;

  public function __saveRelatedData($model,$value) {

    $officeHours = array();

    $days = Day::all();

    foreach ($days as $key => $day) {

      $_data['model'] = $model->modelName;
      $_data['model_id'] = $model->id;
      $_data['day_id'] = $day->id;

      $_data['open'] = 0;
      $_data['start_time'] = '00:00:00';
      $_data['start_time'] = '00:00:00';

      if(!empty($value[$day->id])){

        $startSeconds = ($value[$day->id]['start_time']['hour']*60*60) + ($value[$day->id]['start_time']['min']*60);
        $endSeconds = ($value[$day->id]['end_time']['hour']*60*60) + ($value[$day->id]['end_time']['min']*60);

        if($startSeconds < $endSeconds) {
          $_data['open'] = $value[$day->id]['open'];
          $_data['start_time'] = $value[$day->id]['start_time']['hour'].':'.$value[$day->id]['start_time']['min'].':00';
          $_data['end_time'] = $value[$day->id]['end_time']['hour'].':'.$value[$day->id]['end_time']['min'].':00';
        }

      }

      $officeHours[$day->id] = $_data;
    }

    foreach ($officeHours as $key => $officeHour) {
      if(($model->state == 'update') && $model->checkRelatedDataExist($this->modelName)){
        $model->getRalatedDataByModelName($this->modelName,true,[['day_id','=',$officeHour['day_id']]])->setFormToken($this->formToken)->_save($officeHour);
      }else{
        $this->_save($officeHour);
      }
    }

    return true;

  }



}
