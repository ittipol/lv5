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

      $companies[] = array(
        'id' => $company->id,
        'name' => $company->name,
        'description' => $string->subString($company->description,120),
        'business_type' => $company->business_type,
        'total_department' => $company->companyHasDepartments->count(),
        'image' => $company->getRalatedDataByModelName('Image',true)->getImageUrl(),
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

    // clear temp dir and records
    $tempFile = new TempFile;
    $tempFile->deleteRecordByToken($this->pageToken,'add',Session::get('Person.id'));
    $tempFile->deleteTempDir($this->pageToken);

    $this->data = array(
      'districts' => $districts,
    );

    return $this->view('pages.company.form.add');
  }

  public function add(CompanyRequest $request) {

    if(empty($request->get('__token')) || ($request->get('__token') != $this->pageToken)) {
      exit;
    }

    $company = new Company;
    $company->fill($request->all());
    $company->pageToken = $this->pageToken;

    // save
    if($company->save()){

      // $company->saveRelatedModelData();

      // // save company image
      // if(!empty($request->get('filenames'))){
      //   $image = new Image;
      //   $image->saveUploadImages($company,$request->get('form_token'),$request->get('filenames'),Session::get('Person.id'));
      // }

      // save address
      // $address = new Address;
      // $address->fill($request->get('address'));
      // $address->model = $company->modelName;
      // $address->model_id = $company->id;
      // $address->save();

      // $tags = array();
      // if(!empty($request->get('tags'))){
      //   $tag = new Tag;
      //   $tags = $tag->saveTags($request->get('tags'));
      // }

      // business type
      // $businessType = new BusinessType;
      // $businessType = $businessType->checkAndSave($request->input('business_type'));

      // Company has business type
      // $companyHasBusinessType = new CompanyHasBusinessType;
      // $companyHasBusinessType->checkAndSave($company->id,$businessType->id);
      
      // $tagging = new Tagging;
      // Company Tagging
      // $tagging->deleteAndSave($company->modelName,$company->id,$tags);
      // Bussiness type Tagging
      // $tagging->checkAndSave($businessType,$tags);

      // $options = array(
      //   'data' => $company->getAttributes(),
      //   'tags' => $tags
      // );

      // // Add to Lookup table
      // $lookup = new Lookup;
      // $lookup->saveSpecial($company,$options);

      // wiki
      if(!empty($request->input('wiki'))){
        $wiki = new Wiki;
        $wiki->model = $company->modelName;
        $wiki->model_id = $company->id;
        $wiki->subject = $company->name;
        $wiki->description = $company->description;
        $wiki->save();
      }

      $message = new Message;
      $message->addingSuccess('ร้านค้าหรือสถานประกอบการ');

    }else{

      $message = new Message;
      $message->error('ไม่สามารถเพิ่มร้านค้าหรือสถานประกอบการได้');

    }

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

    $geographic = array();
    if(!empty($address->lat) && !empty($address->lng)) {
      $geographic['lat'] = $address->lat;
      $geographic['lng'] = $address->lng;
    }

    // Get Images
    $images = $company->images();

    $_images = array();
    if($images){
      foreach ($images as $image) {
        $_images[] = array(
          'name' => $image->name,
          'url' => $image->getImageUrl()
        );
      }
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

    // $company->includeRelatedData(array(
    //   'Address' => array(
    //     'fields' => array('address','district_id','sub_district_id','lat','lng')
    //   ),
    //   'Tag' => array(
    //     'fields' => array('name'),
    //     'options' => array(
    //       'related' => 'Tagging.tag'
    //     )
    //   ),
    //   'Image' => array(
    //     'fields' => array('name')
    //   )
    // ));

    // form token
    $formToken = Token::generateFormToken('Company','edit',Session::get('Person.id'));

    $tempFile = new TempFile;
    $tempFile->deleteRecordByToken($formToken,'image',Session::get('Person.id'));

    $this->data = array(
      'company' => $company,
      'address' => $address,
      'imageJson' => json_encode($_images),
      'tagJson' => json_encode($_tags),
      'geographic' => json_encode($geographic),
      'formToken' => $formToken,
      'districts' => $districts,
    );

    return $this->view('pages.company.form.edit');

  }

  public function edit(CompanyRequest $request,$companyId) {

    $company = Company::find($companyId);
    $company->fill($request->all());
    $company->save();

    if(!empty($request->get('filenames'))){
      $image = new Image;
      $image->saveUploadImages($company,$request->get('form_token'),$request->get('filenames'),Session::get('Person.id'));
      $image->deleteImages($company,$request->get('form_token'),Session::get('Person.id'));
    }

    // save address
    $address = new Address;
    $address->fill($request->get('address'));
    $address->model = $company->modelName;
    $address->model_id = $company->id;
    $address->save();

    $tags = array();
    if(!empty($request->get('tags'))){
      $tag = new Tag;
      $tags = $tag->saveTags($request->get('tags'));
    }

    // business type
    $businessType = new BusinessType;
    $businessType = $businessType->checkAndSave($request->input('business_type'));

    // Company has business type
    $companyHasBusinessType = new CompanyHasBusinessType;
    $companyHasBusinessType->checkAndSave($company->id,$businessType->id);

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
    
  }

  public function dataView() {
    
  }

}
