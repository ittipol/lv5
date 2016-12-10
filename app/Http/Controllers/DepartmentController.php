<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentRequest;
use App\Models\Company;
use App\Models\Department;
use App\Models\CompanyHasDepartment;
use App\Models\Person;
use App\Models\PersonHasCompany;
use App\Models\PersonHasDepartment;
use App\Models\Role;
use App\Models\Lookup;
use App\Models\Image;
use App\Models\District;
use App\Models\Address;
use App\Models\Wiki;
use App\library\message;
use Auth;
use Redirect;
use Session;

class DepartmentController extends Controller
{

  public function listView($companyId = null) {

    dd('sss');

    return $this->view('pages.department.list');
  }

  public function formAdd($companyId = null) {

    // check company exist and person who is in company or not
    $personHasCompany = new PersonHasCompany;
    $company = new Company;
    if(!$personHasCompany->checkPersonInCompany(Session::get('Person.id'),$companyId) || !$company->checkExistById($companyId)){
      $message = new Message;
      $message->companyCheckFail();
      return Redirect::to('company/list'); 
    }

    $districtRecords = District::all();

    $districts = array();
    foreach ($districtRecords as $district) {
      $districts[$district->id] = $district->name;
    }

    // Get Company name
    $company = Company::where('id','=',$companyId)->first();

    $this->data = array(
      'companyName' => $company->name,
      'districts' => $districts,
    );

    return $this->view('pages.department.form');
  }

  public function add(DepartmentRequest $request,$companyId) {

    // check company exist and person who is in company or not
    $personHasCompany = new PersonHasCompany;
    $company = new Company;
    if(!$personHasCompany->checkPersonInCompany(Session::get('Person.id'),$companyId) || !$company->checkExistById($companyId)){
      $message = new Message;
      $message->companyCheckFail();
      return Redirect::to('company/list'); 
    }
  
    $department = new Department;
    $department->fill($request->all());
    $department->created_by = Auth::user()->id;

    if($department->save()){

      // create folder
      $department->createImageFolder();

      // save company image
      if(!empty($request->file('images'))){
        $imageModel = new Image;
        $imageModel->saveImages($department,$request->file('images'));
      }

      //
      $companyHasDepartment = new CompanyHasDepartment;
      $companyHasDepartment->company_id = $companyId;
      $companyHasDepartment->department_id = $department->id;
      $companyHasDepartment->save();

      $options = array(
        'data' => $department['attributes'],
      );

      $company = Company::where('id','=',$companyId)->first();
      $options['data'] = array_merge($options['data'],array(
        '_companyName' => $company->name,
        '_businessType' => $company->business_type
      ));

      // Add to Lookup table
      $lookup = new Lookup;
      $lookup->saveSpecial($department,$options);

      // Address
      if(empty($request->input('company_address'))){
        // save address
        $address = new Address;
        $address->fill($request->all());
        $address->model = $department->modelName;
        $address->model_id = $department->id;
        $address->save();
      }

      // add person to department
      $personHasDepartment = new PersonHasDepartment;
      $personHasDepartment->person_id = Session::get('Person.id');
      $personHasDepartment->department_id = $department->id;

      // role
      $role = new Role;
      $personHasDepartment->role_id = $role->getIdByalias('admin');  
      $personHasDepartment->save();

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
