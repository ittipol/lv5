<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobRequest;
use App\Models\Job;
use App\Models\Company;
use App\Models\CompanyHasJob;
use App\Models\PersonHasCompany;
use App\Models\EmploymentType;
use App\library\message;
use App\library\string;
use Auth;
use Redirect;
use Session;

class JobController extends Controller
{

  public function listView($companyId) {

    $string = new String;

    $companyHasJobs = CompanyHasJob::where('company_id','=',$companyId)->get();

    $jobs = array();
    foreach ($companyHasJobs as $companyHasJob) {
      $job = $companyHasJob->job;

      $image = '';
      if(!empty($job->getRalatedDataByModelName('Image',true,[['type','=','images']]))) {
        $image = $job->getRalatedDataByModelName('Image',true,[['type','=','images']])->getImageUrl();
      }

      $jobs[] = array(
        'id' => $job->id,
        'name' => $job->name,
        'description' => $string->subString($job->description,120),
        'image' => $image,
      );
    }

    $this->data = array(
      'companyId' => $companyId,
      'jobs' => $jobs
    );

    return $this->view('pages.job.list');
  }

  public function formAdd($companyId) {

    $company = new Company;
    $personHasCompany = new PersonHasCompany;
    if(!$personHasCompany->checkPersonHasCompany(Session::get('Person.id'))) {
      $message = new Message;
      $message->companyRequireAtLeastOne();
      return Redirect::to('company/add');
    }

    if(!$personHasCompany->checkPersonInCompany($companyId,Session::get('Person.id')) || !$company->checkExistById($companyId)){
      $message = new Message;
      $message->companyNotFound();
      return Redirect::to('company/list'); 
    }

    // Get Company
    $company = Company::find($companyId);

    // Get departments
    $departments[0] = 'ไม่กำหนด';
    foreach ($company->companyHasDepartments as $key => $companyHasDepartment) {
      if($companyHasDepartment->departmentHasPeople->where('person_id','=',Session::get('Person.id'))->first()){
        $department = $companyHasDepartment->departmentHasPeople->where('person_id','=',Session::get('Person.id'))->first()->department;
        $departments[$department->id] = $department->name;
      }
    }

    // Get employment types
    $employmentTypes = EmploymentType::all();
    $_employmentTypes = array();
    foreach ($employmentTypes as $employmentType) {
      $_employmentTypes[$employmentType->id] = $employmentType->name;
    }

    $this->data = array(
      'companyName' => $company->name,
      'departments' => $departments,
      'employmentTypes' => $_employmentTypes,
    );

    Session::put($this->formToken,1);

    return $this->view('pages.job.form.add');
  }

  public function add(JobRequest $request, $companyId) {

    $company = new Company; 
    $personHasCompany = new PersonHasCompany;
    if(!$personHasCompany->checkPersonHasCompany(Session::get('Person.id'))) {
      $message = new Message;
      $message->companyRequireAtLeastOne();
      return Redirect::to('company/add');
    }

    if(!$personHasCompany->checkPersonInCompany($companyId,Session::get('Person.id')) || !$company->checkExistById($companyId)){
      $message = new Message;
      $message->companyNotFound();
      return Redirect::to('company/list'); 
    }

    $request['company_id'] = $companyId;

    $job = new Job;
    $job->fill($request->all());

    if($job->save()){
      // delete temp dir & records
      $job->deleteTempData();
      // reomove form token
      Session::forget($job->formToken);

      $message = new Message;
      $message->addingSuccess('ประกาศงาน');
    }else{
      $message = new Message;
      $message->error('ไม่สามารถเพิ่มประกาศงานได้ กรุณาลองใหม่อีกครั้ง');
      return Redirect::to('job/add/'.$companyId);
    }

    return Redirect::to('job/list/'.$companyId);
  }

  public function formEdit($jobId) {

    $job = Job::find($jobId);

    // get company
    $company = $job->companyHasJob->company;

    $departmentId = null;
    // get department has department
    $departmentHasJob = $job->companyHasJob->departmentHasJob;
    if(!empty($departmentHasJob)) {
      $departmentId = $departmentHasJob->department_id;
    }

    // Get departments
    $departments[0] = 'ไม่กำหนด';
    foreach ($company->companyHasDepartments as $key => $companyHasDepartment) {
      if($companyHasDepartment->departmentHasPeople->where('person_id','=',Session::get('Person.id'))->first()){
        $department = $companyHasDepartment->departmentHasPeople->where('person_id','=',Session::get('Person.id'))->first()->department;
        $departments[$department->id] = $department->name;
      }
    }

    $employmentTypes = EmploymentType::all();
    $_employmentTypes = array();
    foreach ($employmentTypes as $employmentType) {
      $_employmentTypes[$employmentType->id] = $employmentType->name;
    }

    // Get Images
    $images = $job->getRalatedDataByModelName('Image',false,[['type','=','images']]);
    $_images = array();
    if(!empty($images)){
      foreach ($images as $image) {
        $_images[] = array(
          'name' => $image->name,
          'url' => $image->getImageUrl()
        );
      }
    }

    // Get Tag
    $taggings = $job->getRalatedDataByModelName('Tagging');
    $_tags = array();
    if(!empty($taggings)){
      foreach ($taggings as $tagging) {
        $_tags[] = array(
          'id' =>  $tagging->tag->id,
          'name' =>  $tagging->tag->name
        );
      }
    }

    $this->data = array(
      'job' => $job,
      'imageJson' => json_encode($_images),
      'tagJson' => json_encode($_tags),
      'companyName' => $company->name,
      'departments' => $departments,
      'departmentId' => $departmentId,
      'employmentTypes' => $_employmentTypes
    );

    Session::put($this->formToken,1);

    return $this->view('pages.job.form.edit');
    
  }

}
