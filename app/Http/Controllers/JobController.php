<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobRequest;
use App\Models\Job;
use App\Models\Company;
use App\Models\Person;
use App\Models\PersonHasCompany;
use App\Models\EmploymentType;
use App\library\message;
use Auth;
use Redirect;
use Session;

class JobController extends Controller
{

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

    // Get Company name
    $company = Company::find($companyId);

    // Get departments filter by person in department
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
      return Redirect::to('company/add/'.$companyId);
    }

    return Redirect::to('job/list/'.$companyId);
  }

  public function formEdit() {

    
  }

}
