<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use App\Models\District;
use App\Models\BusinessEntity;
use App\Models\Lookup;
use App\Models\Wiki;
use App\Models\TempFile;
use App\library\message;
use App\library\string;
use App\library\service;
use Auth;
use Redirect;
use Session;

class CompanyController extends Controller
{
  public function __construct(array $attributes = []) { 
    parent::__construct();
  }

  // public function listView() {

  //   // Get company
  //   $personHasCompany = PersonHasCompany::where('person_id','=',Session::get('Person.id'))->get();

  //   $companies = array();
  //   foreach ($personHasCompany as $value) {
  //     $company = $value->company;

  //     $image = '';
  //     if(!empty($company->getRalatedDataByModelName('Image',true,[['type','=','images']]))) {
  //       $image = $company->getRalatedDataByModelName('Image',true,[['type','=','images']])->getImageUrl();
  //     }

  //     $companies[] = array(
  //       'id' => $company->id,
  //       'name' => $company->name,
  //       'description' => String::subString($company->description,120),
  //       'business_type' => $company->business_type,
  //       'total_department' => $company->companyHasDepartments->count(),
  //       'image' => $image,
  //     );
  //   }

  //   $this->data = array(
  //     'companies' => $companies
  //   );

  //   return $this->view('pages.company.list');
  // }

  public function formAdd() {

    $districts = District::all();
    $_districts = array();
    foreach ($districts as $district) {
      $_districts[$district->id] = $district->name;
    }

    $businessEntities = BusinessEntity::all();
    $_businessEntities = array();
    foreach ($businessEntities as $businessEntity) {
      $_businessEntities[$businessEntity->id] = $businessEntity->name;
    }

    $this->data = array(
      'districts' => $_districts,
      'businessEntities' => $_businessEntities
    );

    // set form token
    Session::put($this->formToken,1);

    return $this->view('pages.company.form.add');
  }

  public function add(CompanyRequest $request) {

    $company = new Company;
    $company->fill($request->all());

    if($company->save()){
      // delete temp dir & records
      $company->deleteTempData();
      // reomove form token
      Session::forget($company->formToken);

      $message = new Message;
      $message->addingSuccess('ร้านค้าหรือสถานประกอบการ');
    }else{
      $message = new Message;
      $message->error('ไม่สามารถเพิ่มสถานประกอบการหรือร้านค้า กรุณาลองใหม่อีกครั้ง');
      return Redirect::to('company/add');
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

    $address = $company->getRalatedDataByModelName('Address',true);
    $geographic = array();
    if(!empty($address->lat) && !empty($address->lng)) {
      $geographic['lat'] = $address->lat;
      $geographic['lng'] = $address->lng;
    }

    // Get logo
    $logo = $company->getRalatedDataByModelName('Image',true,[['type','=','logo']]);
    $_logo = array();
    if($logo){
      $_logo[] = array(
        'name' => $logo->name,
        'url' => $logo->getImageUrl()
      );
    }

    // Get Images
    $images = $company->getRalatedDataByModelName('Image',false,[['type','=','images']]);
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
    $taggings = $company->getRalatedDataByModelName('Tagging');
    $_words = array();
    if(!empty($taggings)){
      foreach ($taggings as $tagging) {
        $_words[] = array(
          'id' =>  $tagging->word->id,
          'name' =>  $tagging->word->word
        );
      }
    }

    $officeHour = $company->getRalatedDataByModelName('OfficeHour',true);
    $time = json_decode($officeHour->time,true);
    $_officeHours = array();
    foreach ($time as $day => $value) {

      $_startTime = explode(':', $value['start_time']);
      $_endTime = explode(':', $value['end_time']);

      $_officeHours[$day] = array(
        'open' => $value['open'],
        'start_time' => array(
          'hour' => (int)$_startTime[0],
          'min' => (int)$_startTime[1]
        ),
        'end_time' => array(
          'hour' => (int)$_endTime[0],
          'min' => (int)$_endTime[1]
        )
      );
    }

    $this->data = array(
      'company' => $company,
      'address' => $address,
      'sameTime' => $officeHour['same_time'],
      'logoJson' => json_encode($_logo),
      'imageJson' => json_encode($_images),
      'tagJson' => json_encode($_words),
      'geographic' => json_encode($geographic),
      'officeHoursJson' => json_encode($_officeHours),
      'districts' => $districts
    );

    Session::put($this->formToken,1);

    return $this->view('pages.company.form.edit');

  }

  public function edit(CompanyRequest $request,$companyId) {

    $company = Company::find($companyId);
    $company->fill($request->all());
    $company->save();

    if($company->save()){
      // delete temp dir & records
      $company->deleteTempData();
      // reomove form token
      Session::forget($company->formToken);

      $message = new Message;
      $message->editingSuccess('ร้านค้าหรือสถานประกอบการ');
    }else{
      $message = new Message;
      $message->error('ไม่สามารถแก้ไขสถานประกอบการได้หรือร้านค้า กรุณาลองใหม่อีกครั้ง');
      return Redirect::to('company/edit/'.$companyId);
    }

    return Redirect::to('company/list');

  }

}
