<?php

namespace App\Models;

class CompanyHasDepartment extends Model
{
  public $table = 'company_has_departments';
  protected $fillable = ['company_id','department_id'];
  public $timestamps  = false;

  public function __construct() {  
    parent::__construct();
  }

  public function company() {
    return $this->hasOne('App\Models\Company','id','company_id');
  }
  
  public function department() {
    return $this->hasOne('App\Models\Department','id','department_id');
  }

  public function departmentHasPeople() {
    return $this->hasMany('App\Models\PersonHasDepartment','department_id','department_id');
  }

  public function saveSpecial($companyId,$departmentId) {
    if(!$this->checkRecordExist($companyId,$departmentId)) {
      return $this->_save(array('company_id' => $companyId, 'department_id' => $departmentId));
    }
    return true;
  }

  public function checkRecordExist($companyId,$departmentId) {
    return $this->where([
      ['company_id','=',$companyId],
      ['department_id','=',$departmentId]
    ])->exists();
  }
}
