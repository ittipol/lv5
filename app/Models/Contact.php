<?php

namespace App\Models;

class Contact extends Model
{
  public $table = 'contacts';
  protected $fillable = ['model','model_id','phone_number','email','website','facebook','instagram','line'];
  public $timestamps  = false;

  public function __saveRelatedData($model,$options = array()) {

    $contact = $model->getRalatedDataByModelName($this->modelName,
      array(
        'first' => true
      )
    );

    if(($model->state == 'update') && !empty($contact)){
      return $contact
      ->setFormToken($this->formToken)
      ->fill($options['value'])
      ->save();
    }else{
      return $this->fill($model->includeModelAndModelId($options['value']))->save();
    }
    
  }
  
}
