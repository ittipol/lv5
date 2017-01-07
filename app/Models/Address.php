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

  public function __saveRelatedData($model,$options = array()) {

    $address = $model->getRalatedDataByModelName($this->modelName,
      array(
        'first' => true
      )
    );

    if(($model->state == 'update') && !empty($address)){
      return $address
      ->setFormToken($this->formToken)
      ->fill($options['value'])
      ->save();
    }else{
      return $this->fill($model->includeModelAndModelId($options['value']))->save();
    }
    
  }

  public function buildFormData($options = array()) {
    $this->formData['address'] = $address;

    $geography = array();
    if(!empty($address['lat']) && !empty($address['lng'])) {
      $geography['lat'] = $address['lat'];
      $geography['lng'] = $address['lng'];
    }

    $this->formData['geography'] = json_encode($geography);

    return $address;
  }
}
