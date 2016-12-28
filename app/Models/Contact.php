<?php

namespace App\Models;

use App\Models\Model;

class Contact extends Model
{
  public $table = 'contact';
  protected $fillable = ['phone_number','email','website','facebook','instagram','line'];
  public $timestamps  = false;

  public function __saveRelatedData($model,$value) {

    if(($model->state == 'update') && $model->checkRelatedDataExist($this->modelName)){
      return $model->getRalatedDataByModelName($this->modelName,true)
      ->setFormToken($this->formToken)
      ->fill($value)
      ->save();
    }else{
      return $this->fill($model->includeModelAndModelId($value))->save();
    }
    
  }
  
}
