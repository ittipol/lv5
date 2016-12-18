<?php

namespace App\Models;

use App\Models\Model;

class Address extends Model
{
  protected $table = 'addresses';
  protected $fillable = ['model','model_id','place_name','address','district_id','sub_district_id','description','lat','lng'];
  public $timestamps  = false;

  public function __construct() {  
    parent::__construct();
  }

  public function __saveWithModelAndModelId($model,$value) {
    return $this->clearAndSave($model,$value);
  }

  private function _save($model,$value) {
    $address = new Address;
    $address->fill($value);
    $address->model = $model->modelName;
    $address->model_id = $model->id;
    return $address->save();
  }

  public function clearAndSave($model,$value) {
    $this->deleteByModelNameAndModelId($model->modelName,$model->id);
    return $this->_save($model,$value);
  }

}
