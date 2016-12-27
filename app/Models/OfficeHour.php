<?php

namespace App\Models;

use App\Models\Model;
use App\Models\Day;

class OfficeHour extends Model
{
  public $table = 'office_hours';
  protected $fillable = ['model','model_id','same_time','time','display'];
  public $timestamps  = false;

  public function __saveRelatedData($model,$value) {

    $officeHours = array();

    $days = Day::all();

    $display = false;

    foreach ($days as $key => $day) {

      $_data['open'] = 0;
      $_data['start_time'] = '00:00:00';
      $_data['end_time'] = '00:00:00';

      if(!empty($value['time'][$day->id])){

        $display = true;

        // $startSeconds = ($value['time'][$day->id]['start_time']['hour']*60*60) + ($value['time'][$day->id]['start_time']['min']*60);
        // $endSeconds = ($value['time'][$day->id]['end_time']['hour']*60*60) + ($value['time'][$day->id]['end_time']['min']*60);

        // if($startSeconds < $endSeconds) {
        //   $_data['open'] = $value['time'][$day->id]['open'];
        //   $_data['start_time'] = $value['time'][$day->id]['start_time']['hour'].':'.$value['time'][$day->id]['start_time']['min'].':00';
        //   $_data['end_time'] = $value['time'][$day->id]['end_time']['hour'].':'.$value['time'][$day->id]['end_time']['min'].':00';
        // }

        $_data['open'] = $value['time'][$day->id]['open'];
        $_data['start_time'] = $value['time'][$day->id]['start_time']['hour'].':'.$value['time'][$day->id]['start_time']['min'].':00';
        $_data['end_time'] = $value['time'][$day->id]['end_time']['hour'].':'.$value['time'][$day->id]['end_time']['min'].':00';

      }

      $officeHours[$day->id] = $_data;
    }

    $value = array(
      'same_time' => !empty($value['same_time']) ? 1 : 0,
      'time' => json_encode($officeHours),
      'display' => $display
    );

    if(($model->state == 'update') && $model->checkRelatedDataExist($this->modelName)){
      return $model->getRalatedDataByModelName($this->modelName,true)
            ->setFormToken($this->formToken)
            ->fill($value)
            ->save();
    }else{
      return $this->_save($model->includeModelAndModelId($value));
    }

  }



}
