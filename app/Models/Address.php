<?php

namespace App\Models;

class Address extends Model
{
  protected $table = 'addresses';
  protected $fillable = ['model','model_id','place_name','address','district_id','sub_district_id','description','lat','lng'];
  public $timestamps  = false;

  public function __construct() {  
    parent::__construct();
  }

  public function district() {
    return $this->hasOne('App\Models\District','id','district_id');
  }

  public function subDistrict() {
    return $this->hasOne('App\Models\SubDistrict','id','sub_district_id');
  }

  public function __saveRelatedData($model,$value) {

    $address = $model->getRalatedDataByModelName($this->modelName,
      array(
        'onlyFirst' => true
      )
    );

    if(($model->state == 'update') && !empty($address)){
      return $address
      ->setFormToken($this->formToken)
      ->fill($value)
      ->save();
    }else{
      return $this->fill($model->includeModelAndModelId($value))->save();
    }
    
  }
}
