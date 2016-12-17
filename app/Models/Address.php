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

  public function clearAndSave() {
    // clear old record
    $this->deleteByModelNameAndModelId($model->modelName,$model->id);
  }

  // private function _save($model,$tagId) {
  //   $tagging = new Tagging;
  //   $tagging->model = $model->modelName;
  //   $tagging->model_id = $model->id;
  //   $tagging->tag_id = $tagId;
  //   $tagging->save();
  // }

}
