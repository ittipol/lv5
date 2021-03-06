<?php

namespace App\Models;

class DepartmentHasJob extends Model
{
  public $table = 'department_has_jobs';
  protected $fillable = ['company_has_job_id','department_id','job_id'];
  public $timestamps  = false;

  public function saveSpecial($companyHasJobId,$departmentId,$jobId) {

    $value = array(
      'company_has_job_id' => $companyHasJobId,
      'department_id' => $departmentId,
      'job_id' => $jobId
    );

    if($this->checkDepartmentHasJob($companyHasJobId,$departmentId,$jobId)){
      return $this->where([
        ['company_has_job_id','=',$companyHasJobId],
        ['department_id','=',$departmentId],
        ['job_id','=',$jobId]
      ])
      ->first()
      ->setFormToken($this->formToken)
      ->fill($value)
      ->save();
    }else{
      return $this->fill($model->includeModelAndModelId($value))->save();
    }

  }

  public function checkDepartmentHasJob($companyHasJobId,$departmentId,$jobId) {
    return $this->where([
      ['company_has_job_id','=',$companyHasJobId],
      ['department_id','=',$departmentId],
      ['job_id','=',$jobId]
    ])->exists();
  }
}
