<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobRequest;
use App\Models\Job;
use App\Models\Company;
use App\Models\Person;
use App\Models\PersonHasCompany;
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
    $departments = array();
    foreach ($company->companyHasDepartments as $key => $companyHasDepartment) {
      if($companyHasDepartment->departmentHasPeople->where('person_id','=',Session::get('Person.id'))->first()){
        $department = $companyHasDepartment->departmentHasPeople->where('person_id','=',Session::get('Person.id'))->first()->department;
        $departments[$department->id] = $department->name;
      }
    }

    $departments = array_merge(array(0 => 'ไม่กำหนด'),$departments);

    $this->data = array(
      'companyName' => $company->name,
      'departments' => $departments
    );

    Session::put($this->formToken,1);

    return $this->view('pages.job.form.add');
  }

  public function add(JobRequest $request, $companyId) {
    dd($request->all());


  }

  public function formEdit() {

    
  }

}
