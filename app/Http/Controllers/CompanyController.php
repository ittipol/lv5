<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use App\Models\Tagging;
use App\Models\PersonHasCompany;
use App\Models\BusinessType;
use App\Models\CompanyHasBusinessType;
use App\Models\District;
use App\Models\Address;
use App\Models\Person;
use App\Models\Role;
use App\Models\Lookup;
use App\Models\Image;
use App\Models\Wiki;
use App\Models\Tag;
use App\Models\TempFile;
use App\library\message;
use App\library\string;
use App\library\service;
use App\library\token;
use Auth;
use Redirect;
use Session;

class CompanyController extends Controller
{
  public function listView() {

    // พนักงานประจำ
    // พนักงานสัญญาจ้าง

    $string = new String;

    // Get company
    $personHasCompany = PersonHasCompany::where('person_id','=',Session::get('Person.id'))->get();

    $companies = array();
    foreach ($personHasCompany as $value) {

      $company = $value->company;
      $image = $company->imageUrl();

      $companies[] = array(
        'id' => $company->id,
        'name' => $company->name,
        'description' => $string->subString($company->description,120),
        'business_type' => $company->business_type,
        'total_department' => $company->companyHasDepartments->count(),
        // 'image' => !empty($image) ? $image : '/images/no-img.png',
        'image' => $image,
        // 'totalImage' => $image->count()
      );
    }

    $this->data = array(
      'companies' => $companies
    );

    return $this->view('pages.company.list');
  }

  public function formAdd() {

    $action = app('request')->route()->getAction();

    $districtRecords = District::all();

    $districts = array();
    foreach ($districtRecords as $district) {
      $districts[$district->id] = $district->name;
    }

    $this->data = array(
      'formToken' => Token::generateFormToken('Company','add',Session::get('Person.id')),
      'districts' => $districts,
    );

    return $this->view('pages.company.form.add');
  }

  public function add(CompanyRequest $request) {

    $company = new Company;
    $company->fill($request->all());

    $service = new Service;
    $company->ip_address = $service->ipAddress();
    $company->created_by = Auth::user()->id;

    // save
    if($company->save()){

      // create folder
      $company->createImageFolder();

      // save company image
      if(!empty($request->get('filenames'))){
        $image = new Image;
        $image->saveUploadImages($company,$request->get('_token'),Session::get('Person.id'),$request->get('filenames'));
      }

      // Add person to company
      $personHasCompany = new PersonHasCompany;
      $personHasCompany->person_id = Session::get('Person.id');
      $personHasCompany->company_id = $company->id;
      $role = new Role;
      $personHasCompany->role_id = $role->getIdByalias('admin');  
      $personHasCompany->save();

      // business type
      $businessType = new BusinessType;
      $businessType = $businessType->checkAndSave($request->input('business_type'));

      // Company has business type
      $companyHasBusinessType = new CompanyHasBusinessType;
      $companyHasBusinessType->company_id = $company->id;
      $companyHasBusinessType->business_type_id = $businessType->id;
      $companyHasBusinessType->save();

      $tags = array();
      if(!empty($request->input('tags'))){
        $tag = new Tag;
        $tags = $tag->saveTags($request->input('tags'));
      }

      $tagging = new Tagging;
      // Company Tagging
      $tagging->deleteAndSave($company->modelName,$company->id,$tags);
      // Bussiness type Tagging
      $tagging->checkAndSave($businessType->modelName,$businessType->id,$tags);

      $options = array(
        'data' => $company->getAttributes(),
        'tags' => $tags
      );

      // Add to Lookup table
      $lookup = new Lookup;
      $lookup->saveSpecial($company,$options);

      // save address
      $address = new Address;
      $address->fill($request->all());
      $address->model = $company->modelName;
      $address->model_id = $company->id;
      $address->save();

      // wiki
      if(!empty($request->input('wiki'))){
        $wiki = new Wiki;
        $wiki->model = $company->modelName;
        $wiki->model_id = $company->id;
        $wiki->subject = $company->name;
        $wiki->description = $company->description;
        $wiki->save();
      }
    }

    $message = new Message;
    $message->addingSuccess('สถานประกอบการ');

    return Redirect::to('company/list');

  }

  public function formEdit($companyId) {
    
    $company = Company::find($companyId);

    $districtRecords = District::all();

    $districts = array();
    foreach ($districtRecords as $district) {
      $districts[$district->id] = $district->name;
    }

    // Get Address
    $address = $company->address();
    // Get Images
    $images = $company->images();

    $_images = array();
    foreach ($images as $image) {
      $_images[] = array(
        'name' => $image->getImageUrl()
      );
    }

    // Get Tag
    $tags = $company->tags(true);

    $_tags = array();
    foreach ($tags as $tag) {
      $_tags[] = array(
        'id' =>  $tag['id'],
        'name' =>  $tag['name']
      );
    }

    $this->data = array(
      'company' => $company,
      'address' => $address,
      'imageJson' => json_encode($_images),
      'tagJson' => json_encode($_tags),
      'districts' => $districts,
    );

    return $this->view('pages.company.form.edit');

  }

  public function edit(CompanyRequest $request,$companyId) {

  }

  public function dataView() {
    
  }

}
