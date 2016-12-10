<?php

namespace App\Models;

use App\Models\Model;

class BusinessType extends Model
{
  public $table = 'business_types';
  protected $fillable = ['name','description'];
  public $timestamps  = false;

  public function __construct() {  
    parent::__construct();
  }

  public function checkRecordExist($field, $data) {
    return $this->where($field,'like',$data)->count() ? true : false;
  }

  public function checkAndSave($businessType) {
    
    $result = null;

    if($this->checkRecordExist('name',$businessType)){
      $result = $this->where('name','like',$businessType)->first();
    }else{
      $this->name = $businessType;
      $this->save();

      if($this->save()){
        $result = $this->find($this->id)->first();
      }
    }

    return $result;

  }

}
