<?php

namespace App\Models;

use App\Models\Model;

class CompanyHasJob extends Model
{
  public $table = 'company_has_jobs';
  protected $fillable = ['company_id','job_id'];
  public $timestamps  = false;

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
