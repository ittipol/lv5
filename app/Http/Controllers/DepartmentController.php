<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentRequest;
use App\Models\Company;
use App\Models\Department;
use App\Models\PersonHasCompany;
use App\Models\CompanyHasDepartment;
use App\Models\District;
use App\Models\TempFile;
use App\library\message;
use App\library\string;
use Auth;
use Redirect;
use Session;

class DepartmentController extends Controller
{

  public function listView($companyId = null) {

    $string = new String;

    $companyHasDepartments = Company::find($companyId)->companyHasDepartments;

    $departments = array();

    foreach ($companyHasDepartments as $value) {

      if($value->departmentHasPeople->where('person_id','=',Session::get('Person.id'))->first()){

        $department = $value->departmentHasPeople->where('person_id','=',Session::get('Person.id'))->first()->department;

        $image = '';
        if(!empty($department->getRalatedDataByModelName('Image',true,[['type','=','images']]))) {
          $image = $department->getRalatedDataByModelName('Image',true,[['type','=','images']])->getImageUrl();
        }

        $departments[] = array(
          'id' => $department->id,
          'name' => $department->name,
          'description' => $string->subString($department->description,120),
          'business_type' => $department->business_type,
          'image' => $image,
        );

      }

    }

    $this->data = array(
      'companyId' => $companyId,
      'companyName' => Company::find($companyId)->name,
      'departments' => $departments
    );

    return $this->view('pages.department.list');
  }

  public function formAdd($companyId = null) {

    // check company exist and person who is in company or not
    $personHasCompany = new PersonHasCompany;
    $company = new Company;
    if(!$personHasCompany->checkPersonInCompany($companyId,Session::get('Person.id')) || !$company->checkExistById($companyId)){
      $message = new Message;
      $message->companyCheckFail();
      return Redirect::to('company/list'); 
    }

    $districtRecords = District::all();

    $districts = array();
    foreach ($districtRecords as $district) {
      $districts[$district->id] = $district->name;
    }

    Session::put($this->formToken,1);

    // Get Company name
    $company = Company::find($companyId);

    $this->data = array(
      'companyName' => $company->name,
      'districts' => $districts,
    );

    return $this->view('pages.department.form.add');
  }

  public function add(DepartmentRequest $request,$companyId) {

    // check company exist and person who is in company or not
    $personHasCompany = new PersonHasCompany;
    $company = new Company;
    if(!$personHasCompany->checkPersonInCompany($companyId,Session::get('Person.id')) || !$company->checkExistById($companyId)){
      $message = new Message;
      $message->companyCheckFail();
      return Redirect::to('company/list'); 
    }

    // need to store value
    $request['company_id'] = $companyId;

    $department = new Department;
    $department->fill($request->all());

    if($department->save()){
      // delete temp dir & records
      $company->deleteTempData($company->formToken);
      // reomove form token
      Session::forget($company->formToken);

      $message = new Message;
      $message->addingSuccess('แผนก');

    }else{
      $message = new Message;
      $message->error('ไม่สามารถเพิ่มแผนกได้ กรุณาลองใหม่อีกครั้ง');
      return Redirect::to('department/add/'.$companyId);
    }

    return Redirect::to('department/list');

  }

  public function formEdit($departmentId) {
   
    $department = Department::find($departmentId);

    // find company id
    $company = CompanyHasDepartment::where('department_id','=',$departmentId)->first()->company;

     dd($company);

    $districtRecords = District::all();

    $districts = array();
    foreach ($districtRecords as $district) {
      $districts[$district->id] = $district->name;
    }

    Session::put($this->formToken,1);

    // Get Company name
    $company = Company::find($companyId);

    $this->data = array(
      'companyName' => $company->name,
      'districts' => $districts,
    );

    Session::put($this->formToken,1);

    // Get Company name
    $company = Company::find($companyId);

    $this->data = array(
      'companyName' => $company->name,
      'districts' => $districts,
    );

    return $this->view('pages.department.form.edit');
  }

}
