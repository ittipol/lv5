<?php

namespace App\Models;

class BusinessType extends Model
{
  public $table = 'business_types';
  protected $fillable = ['name','description'];
  public $timestamps  = false;
  public $requireValue = array('name');

  public function __construct() {  
    parent::__construct();
  }

  public function checkAndSave($businessType) {
    if(!$this->checkRecordExistByName($businessType)) {
      return $this->_save(array('name' => $businessType));
    }

    return true;
  }

  public function checkRecordExistByName($data) {
    return $this->where('name','like',$data)->exists();
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
