<?php

namespace App\Models;

use App\Models\Model;

class CompanyHasBusinessType extends Model
{
  public $table = 'company_has_business_types';
  protected $fillable = ['company_id','business_type_id'];
  public $timestamps  = false;

  public function __construct() {  
    parent::__construct();
  }

  public function checkRecordExist($companyId,$businessTypeId) {
    return $this->where([
      ['company_id','=',$companyId],
      ['business_type_id','=',$businessTypeId]
    ])->count() ? true : false;
  }

  public function checkAndSave($companyId,$businessTypeId) {
    if(!$this->checkRecordExist($companyId,$businessTypeId)) {
      $this->where('company_id','=',$companyId)->delete();
      $this->_save($companyId,$businessTypeId);
    }
  }

  private function _save($companyId,$businessTypeId) {
    $companyHasBusinessType = new CompanyHasBusinessType;
    $companyHasBusinessType->company_id = $companyId;
    $companyHasBusinessType->business_type_id = $businessTypeId;
    $companyHasBusinessType->save();
  }

}
