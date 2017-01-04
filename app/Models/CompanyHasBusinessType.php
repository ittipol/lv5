<?php

namespace App\Models;

class CompanyHasBusinessType extends Model
{
  public $table = 'company_has_business_types';
  protected $fillable = ['company_id','business_type_id'];
  public $timestamps  = false;

  public function __construct() {  
    parent::__construct();
  }

  public function businessType() {
    return $this->hasOne('App\Models\BusinessType','id','business_type_id');
  }

  public function saveSpecial($model,$value) {
    $businessType = new BusinessType;
    $businessType->setFormToken($this->formToken);
    if($businessType->checkAndSave($value)) {
      return $this->checkAndSave($model->id,$businessType->getBusinessTypeByName($value)->id);
    }

    return false;
  }

  // private function _save($value) {
  //   $companyHasBusinessType = new CompanyHasBusinessType;
  //   $companyHasBusinessType->fill($value);
  //   $companyHasBusinessType->setFormToken($this->formToken);
  //   return $companyHasBusinessType->save();
  // }

  public function checkAndSave($companyId,$businessTypeId) {
    if(!$this->checkRecordExist($companyId,$businessTypeId)) {
      return $this->clearAndSave($companyId,$businessTypeId);
    }

    return true;
  }

  public function clearAndSave($companyId,$businessTypeId) {
    $this->where('company_id','=',$companyId)->delete();
    return $this->_save(array('company_id' => $companyId, 'business_type_id' => $businessTypeId));
  }

  public function checkRecordExist($companyId,$businessTypeId) {
    return $this->where([
      ['company_id','=',$companyId],
      ['business_type_id','=',$businessTypeId]
    ])->count() ? true : false;
  }

}
