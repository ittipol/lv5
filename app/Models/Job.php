<?php

namespace App\Models;

use App\Models\Model;
use App\Models\CompanyHasJob;
use App\Models\DepartmentHasJob;

class Job extends Model
{
  public $table = 'jobs';
  protected $fillable = ['name','description','salary','employment_type_id','nationality','age','gender','educational_level','experience','number_of_position','welfare'];
  public $timestamps  = false;
  public $lookupFormat = array(
    'keyword' => '{{name}} {{salary}} {{nationality}} {{educational_level}}',
    'keyword_1' => '{{EmploymentType.name|Job.employment_type_id=>EmploymentType.id}}',
    'keyword_2' => '{{Company.name|Job.id=>CompanyHasJob.job_id,CompanyHasJob.company_id=>Company.id}}',
    'keyword_3' => '{{Department.name|Job.id=>DepartmentHasJob.job_id,CompanyHasJob.department_id=>Department.id}}',
    'description' => '{{description}}',
  );
  public $createDir = true;
  public $dirNames = array('images');
  public $createImage = true;
  public $allowedRelatedModel = array('Tagging');
  public $temporaryData = array('company_id','department_id');

  public function __construct() {  
    parent::__construct();
  }

  public static function boot() {

    parent::boot();

    Job::saved(function($job){

      if($job->state == 'create') {
        $companyHasJob = new CompanyHasJob;
        $companyHasJob->setFormToken($job->formToken);
        $companyHasJob->saveSpecial($job->temporaryData['company_id'],$job->id);
      }

      if(!empty($job->companyHasJob->id) && !empty($job->temporaryData['department_id'])) {
        $departmentHasJob = new DepartmentHasJob;
        $departmentHasJob->setFormToken($job->formToken);
        $departmentHasJob->saveSpecial($job->companyHasJob->id,$job->temporaryData['department_id'],$job->id);
      }

      $lookup = new Lookup;
      $lookup->setFormToken($job->formToken)->__saveRelatedData($job);

    });
  }

  public function companyHasJob() {
    return $this->hasOne('App\Models\CompanyHasJob','job_id','id');
  }

}
