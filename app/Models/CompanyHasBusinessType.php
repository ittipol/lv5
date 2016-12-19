<?php

namespace App\Models;

use App\Models\Model;
use App\Models\BusinessType;

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

  public function __saveSpecial($model,$value) {
    $businessType = new BusinessType;
    if($businessType->checkAndSave($value)) {
      return $this->checkAndSave($model->id,$businessType->getBusinessTypeByName($value)->id);
    }

    return false;
  }

  private function _save($companyId,$businessTypeId) {
    $companyHasBusinessType = new CompanyHasBusinessType;
    $companyHasBusinessType->company_id = $companyId;
    $companyHasBusinessType->business_type_id = $businessTypeId;
    return $companyHasBusinessType->save();
  }

  public function checkAndSave($companyId,$businessTypeId) {
    if(!$this->checkRecordExist($companyId,$businessTypeId)) {
      return $this->clearAndSave($companyId,$businessTypeId);
    }

    return true;
  }

  public function clearAndSave($companyId,$businessTypeId) {
    $this->where('company_id','=',$companyId)->delete();
    return $this->_save($companyId,$businessTypeId);
  }

  public function checkRecordExist($companyId,$businessTypeId) {
    return $this->where([
      ['company_id','=',$companyId],
      ['business_type_id','=',$businessTypeId]
    ])->count() ? true : false;
  }

}
