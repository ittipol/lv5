<?php

namespace App\Http\Controllers;

use Session;

class ListController extends Controller
{

  protected $allowedModel = array('Company','Department','Job','Product'); 

  public function __construct(array $attributes = []) { 
    parent::__construct();
  }

  public function listView() {
    dd($this->model->modelName);
  }

  public function companyListView() {
    // Get company
    // $personHasCompany = PersonHasCompany::where('person_id','=',Session::get('Person.id'))->get();

    // $companies = array();
    // foreach ($personHasCompany as $value) {
    //   $company = $value->company;

    //   $image = '';
    //   if(!empty($company->getRalatedDataByModelName('Image',true,[['type','=','images']]))) {
    //     $image = $company->getRalatedDataByModelName('Image',true,[['type','=','images']])->getImageUrl();
    //   }

    //   $companies[] = array(
    //     'id' => $company->id,
    //     'name' => $company->name,
    //     'description' => String::subString($company->description,120),
    //     'business_type' => $company->business_type,
    //     'total_department' => $company->companyHasDepartments->count(),
    //     'image' => $image,
    //   );
    // }
  }

  private function getImages($type = 'images',$pass = true) {
    $images = '';
    if(!empty($company->getRalatedDataByModelName('Image',false,[['type','=',$type]]))) {
      $images = $company->getRalatedDataByModelName('Image',false,[['type','=',$type]])->getImageUrl();

      // foreach ($images as $image) {
      //   # code...
      // }
    }

    // pass value
    if($pass){
      $this->formData[$type] = $images;
    }

    return $images;

  }

}
