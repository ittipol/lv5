<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentRequest;
use App\Models\Company;
use App\Models\Department;
use App\Models\PersonHasCompany;
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
        $image = $department->imageUrl();

        $departments[] = array(
          'id' => $department->id,
          'name' => $department->name,
          'description' => $string->subString($department->description,120),
          'business_type' => $department->business_type,
          // 'image' => !empty($image) ? $image : '/images/no-img.png',
          'image' => $image,
        );

      }

    }

    $this->data = array(
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

    // clear temp dir and records
    $tempFile = new TempFile;
    $tempFile->deleteRecordByToken($this->pageToken,Session::get('Person.id'));
    $tempFile->deleteTempDir($this->pageToken);

    // Get Company name
    $company = Company::find($companyId);

    $this->data = array(
      'companyName' => $company->name,
      'districts' => $districts,
    );

    return $this->view('pages.department.form.add');
  }

  public function add(DepartmentRequest $request,$companyId) {

    if(empty($request->get('__token')) || ($request->get('__token') != $this->pageToken)) {
      exit;
    }

    // check company exist and person who is in company or not
    $personHasCompany = new PersonHasCompany;
    $company = new Company;
    if(!$personHasCompany->checkPersonInCompany($companyId,Session::get('Person.id')) || !$company->checkExistById($companyId)){
      $message = new Message;
      $message->companyCheckFail();
      return Redirect::to('company/list'); 
    }

    // Store Company id
    Session::put($this->pageToken.'.compay_id',$companyId);

    $department = new Department;
    $department->fill($request->all());

    if($department->save()){

      //
      $companyHasDepartment = new CompanyHasDepartment;
      $companyHasDepartment->company_id = $companyId;
      $companyHasDepartment->department_id = $department->id;
      $companyHasDepartment->save();

      $options = array(
        'data' => $department->getAttributes(),
      );
 
      //
      $company = Company::where('id','=',$companyId)->first();
      $options['data'] = array_merge($options['data'],array(
        '_companyName' => $company->name,
        '_businessType' => $company->business_type
      ));

      // Add to Lookup table
      $lookup = new Lookup;
      $lookup->saveSpecial($department,$options);

      // wiki
      if(!empty($request->input('wiki'))){
        $wiki = new Wiki;
        $wiki->model = $department->modelName;
        $wiki->model_id = $department->id;
        $wiki->subject = $department->name;
        $wiki->description = $department->description;
        $wiki->save();
      }

      $message = new Message;
      $message->addingSuccess('แผนก');

      return Redirect::to('department/list/'.$companyId);

    }

  }

}
