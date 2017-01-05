<?php

namespace App\Models;

class Contact extends Model
{
  public $table = 'contacts';
  protected $fillable = ['model','model_id','phone_number','email','website','facebook','instagram','line'];
  public $timestamps  = false;

  public function __saveRelatedData($model,$value) {

    $contact = $model->getRalatedDataByModelName($this->modelName,
      array(
        'onlyFirst' => true
      )
    );

    if(($model->state == 'update') && !empty($contact)){
      return $contact
      ->setFormToken($this->formToken)
      ->fill($value)
      ->save();
    }else{
      return $this->fill($model->includeModelAndModelId($value))->save();
    }
    
  }
  
}
