<?php

namespace App\Models;

use App\Models\Model;

class BusinessType extends Model
{
  public $table = 'business_types';
  protected $fillable = ['name','description'];
  public $timestamps  = false;
  public $requireValue = array('name');

  public function __construct() {  
    parent::__construct();
  }

  private function _save($value) {
    $businessType = new BusinessType;
    $businessType->name = $value;
    return $businessType->save();
  }

  public function checkAndSave($businessType) {
    if(!$this->checkRecordExistByName($businessType)) {
      return $this->_save($businessType);
    }

    return true;
  }

  public function checkRecordExistByName($data) {
    return $this->where('name','like',$data)->count() ? true : false;
  }

  public function getBusinessTypeByName($name) {
    return $this->where('name','like',$name)->first();
  }

  // public function checkAndSave($businessType) {
    
  //   $result = null;

  //   if($this->checkRecordExist('name',$businessType)){
  //     $result = $this->where('like',$businessType)->first();
  //   }else{
  //     $this->name = $businessType;
  //     $this->save();

  //     if($this->save()){
  //       $result = $this->find($this->id)->first();
  //     }
  //   }

  //   return $result;

  // }

}
