<?php

namespace App\Models;

class OfficeHour extends Model
{
  public $table = 'office_hours';
  protected $fillable = ['model','model_id','same_time','time','display'];
  public $timestamps  = false;

  public function __saveRelatedData($model,$options = array()) {

    $value = $options['value'];

    $officeHours = array();

    $days = Day::all();

    $display = false;

    foreach ($days as $key => $day) {

      $_data['open'] = 0;
      $_data['start_time'] = '00:00:00';
      $_data['end_time'] = '00:00:00';

      if(!empty($value['time'][$day->id])){

        $display = true;

        $_data['open'] = $value['time'][$day->id]['open'];

        if(strlen($value['time'][$day->id]['start_time']['min']) == 1) {
          $value['time'][$day->id]['start_time']['min'] = '0'.$value['time'][$day->id]['start_time']['min'];
        }

        if(strlen($value['time'][$day->id]['end_time']['min']) == 1) {
          $value['time'][$day->id]['end_time']['min'] = '0'.$value['time'][$day->id]['end_time']['min'];
        }

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

    $officeHour = $model->getRalatedDataByModelName($this->modelName,
      array(
        'first' => true
      )
    );

    if(($model->state == 'update') && !empty($officeHour)){
      return $officeHour
      ->setFormToken($this->formToken)
      ->fill($value)
      ->save();
    }else{
      return $this->_save($model->includeModelAndModelId($value));
    }

  }



}
