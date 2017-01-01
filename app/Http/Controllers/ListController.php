<?php

namespace App\Http\Controllers;

use App\Models\PersonHasEntity;
use App\library\string;
use Session;

class ListController extends Controller
{

  protected $allowedModel = array('Company','Department','Job','Product'); 

  public function __construct(array $attributes = []) { 
    parent::__construct();
  }

  public function listView() {
    // dd($this->model->modelName);

    // switch ($this->model->modelName) {
    //   case 'Company':
    //     $this->companyListView();
    //     break;
      
    // }

    // Get Companies filter by person id
    $records = PersonHasEntity::where([
      ['person_id','=',Session::get('Person.id')],
      ['model','=',$this->model->modelName]
    ])->get();

    foreach ($records as $record) {
      // Get Entity
      $entity = $this->model->find($record->model_id);

      $logo = '';
      if(!empty($entity->checkRelatedDataExist('Image',[['type','=','logo']]))) {
        $logo = $entity->getRalatedDataByModelName('Image',true,[['type','=','logo']])->getImageUrl();
      }

      $image = '';
      if(!empty($entity->checkRelatedDataExist('Image',[['type','=','images']]))) {
        $image = $entity->getRalatedDataByModelName('Image',true,[['type','=','images']])->getImageUrl();
      }

      $entities[] = array(
        'id' => $entity->id,
        'name' => $entity->name,
        'description' => String::subString($entity->description,120),
        'logo' => $logo,
        'image' => $image,
      );

    }

    $this->data = array(
      'entities' => $entities
    );

    return $this->view('list.default_list');

  }

  // private function companyListView() {

  //   // Get Companies filter by person id
  //   $records = PersonHasEntity::where([
  //     ['person_id','=',Session::get('Person.id')],
  //     ['model','=',$this->model->modelName]
  //   ])->get();

  //   foreach ($records as $record) {
  //     // Get Entity
  //     $entity = $this->model->find($record->model_id);

  //     $logo = '';
  //     if(!empty($entity->checkRelatedDataExist('Image',[['type','=','logo']]))) {
  //       $logo = $entity->getRalatedDataByModelName('Image',true,[['type','=','logo']])->getImageUrl();
  //     }

  //     $image = '';
  //     if(!empty($entity->checkRelatedDataExist('Image',[['type','=','images']]))) {
  //       $image = $entity->getRalatedDataByModelName('Image',true,[['type','=','images']])->getImageUrl();
  //     }

  //     $companies[] = array(
  //       'id' => $entity->id,
  //       'name' => $entity->name,
  //       'description' => String::subString($entity->description,120),
  //       'logo' => $logo,
  //       'image' => $image,
  //     );

  //   }

  // }

  private function getImages($type = 'images',$pass = true) {
    $images = '';
    if(!empty($company->checkRelatedDataExist('Image',[['type','=',$type]]))) {
      $images = $company->getRalatedDataByModelName('Image',false,[['type','=',$type]]);

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
