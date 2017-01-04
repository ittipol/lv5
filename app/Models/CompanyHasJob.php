<?php

namespace App\Models;

class CompanyHasJob extends Model
{
  public $table = 'company_has_jobs';
  protected $fillable = ['company_id','job_id'];
  public $timestamps  = false;

  public function __construct() {  
    parent::__construct();
  }

  public function company() {
    return $this->hasOne('App\Models\Company','id','company_id');
  }

  public function job() {
    return $this->hasOne('App\Models\Job','id','job_id');
  }

  public function departmentHasJob() {
    return $this->hasOne('App\Models\DepartmentHasJob','company_has_job_id','id');
  }

  public function saveSpecial($companyId,$jobId) {

    if(!$this->checkCompanyHasJob($companyId,$jobId)) {

      $value = array(
        'company_id' => $companyId,
        'job_id' => $jobId
      );

      return $this->_save($value);
    }

    return true;
  }

  public function checkCompanyHasJob($companyId,$jobId) {
    return $this->where([
      ['company_id','=',$companyId],
      ['job_id','=',$jobId]
    ])->exists();
  }
}
