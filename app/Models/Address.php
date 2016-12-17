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

  public function clearAndSave($model,$address) {
    // clear old record
    $this->deleteByModelNameAndModelId($model->modelName,$model->id);
    // save
    $this->_save($model,$address);
  }

  private function _save($model,$address) {
    $address = new Address;
    $address->fill($address);
    $address->model = $model->modelName;
    $address->model_id = $model->id;
    $address->save();
  }

}
