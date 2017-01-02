<?php

namespace App\Http\Controllers;

use App\Models\PersonHasEntity;
use App\library\string;
use Session;

class ListController extends Controller
{

  protected $allowedModel = array('Company','Department','Job','Product'); 

  public function __construct(array $attributes = []) { 
    parent::__construct($attributes);
  }

  public function listView() {

    // Get Order by
    // if empty
    // get default order by
    // name ASC

    // switch ($this->model->modelName) {
    //   case 'Company':
    //     $this->companyListView();
    //     break;
    // }

    // Get Companies filter by person id
    // $records = PersonHasEntity::where([
    //   ['person_id','=',Session::get('Person.id')],
    //   ['model','=',$this->model->modelName]
    // ]);

    $personHasEntity = new PersonHasEntity;

    $records = $this->model
               ->select($this->model->table.'.*')
               ->join($personHasEntity->table, $personHasEntity->table.'.model_id', '=', $this->model->table.'.id')
               ->where([
                 [$personHasEntity->table.'.person_id','=',Session::get('Person.id')],
                 [$personHasEntity->table.'.model','=',$this->model->modelName]
               ])
               ->orderBy($this->model->table.'.name', 'ASC')
               ->get();

    // $xxx = PersonHasEntity::where([
    //   ['person_id','=',Session::get('Person.id')],
    //   ['model','=',$this->model->modelName]
    // ])
    // ->with('onlineShops')
    // ->orderBy('name', 'ASC')
    // ->get();

    // $records = PersonHasEntity::where([
    //   ['person_id','=',Session::get('Person.id')],
    //   ['model','=',$this->model->modelName]
    // ])
    // ->join('online_shops', 'person_has_entities.model_id', '=', 'online_shops.id')
    // ->orderBy('online_shops.name', 'ASC')
    // ->select('online_shops.*')
    // ->get();

    // $a = \DB::table('person_has_entities')
    // ->join('online_shops', 'person_has_entities.model_id', '=', 'online_shops.id')
    // ->orderBy('online_shops.name', 'ASC')
    // ->get();


    $entities = array();
    foreach ($records as $entity) {
      // Get Entity
      // $entity = $this->model->find($record->model_id);

      // Get slug
      $slug = null;
      if(!empty($entity->checkRelatedDataExist('Slug'))) {
        $slug = array(
          'name' => $entity->getRalatedDataByModelName('Slug',true)->name,
          'url' => url($entity->getRalatedDataByModelName('Slug',true)->name)
        );
      }

      $logo = '';
      if(!empty($entity->checkRelatedDataExist('Image',[['type','=','logo']]))) {
        $logo = $entity->getRalatedDataByModelName('Image',true,[['type','=','logo']])->getImageUrl();
      }

      $cover = '';
      if(!empty($entity->checkRelatedDataExist('Image',[['type','=','cover']]))) {
        $cover = $entity->getRalatedDataByModelName('Image',true,[['type','=','cover']])->getImageUrl();
      }

      $image = '';
      if(!empty($entity->checkRelatedDataExist('Image',[['type','=','images']]))) {
        $image = $entity->getRalatedDataByModelName('Image',true,[['type','=','images']])->getImageUrl();
      }

      $entities[] = array(
        'id' => $entity->id,
        'slug' => $slug,
        'name' => $entity->name,
        // 'description' => String::subString($entity->description,120),
        'logo' => $logo,
        'cover' => $cover,
        'image' => $image,
        // 'options' => array(
        //   'delete' => array(
        //     'name' => 'ลบ'
        //     'url' => url($slug.'/delete')
        //   )
        // )
      );

    }

    // pattern
    // $listPage = array(
    //   'topLeftNav' => array(
    //     'nav1' => array(
    //       'name' => 'เพิ่มบริษัทหรือร้านค้าของคุณของคุณ',
    //       'url' => url('company/add');
    //     ),
    //     'nav1' => array(
    //       'name' => 'เพิ่มบริษัทหรือร้านค้าของคุณของคุณ',
    //       'type' => 'add', // display as plus icon (material design)
    //       'url' => url('company/add');
    //     ),
    //     'group_nav' => array(
    //       array(
    //         'name' => 'เพิ่มบริษัทหรือร้านค้าของคุณของคุณ',
    //         'url' => url('company/add');
    //       ),
    //       array(
    //         'name' => 'เพิ่มบริษัทหรือร้านค้าของคุณของคุณ',
    //         'url' => url('company/add');
    //       )
    //     )
    //   )
    // )

    $this->data = array(
      'entities' => $entities,
      'title' => $this->getTitle($this->model->modelName)
    );

    return $this->view('list.default_list');

  }

  private function getOption($modelName) {

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
  
  private function getTitle($modelName) {

    $title = '';
    switch ($modelName) {
      case 'Company':
        $title = 'บริษัทหรือร้านค้าของคุณของคุณ';
        break;
      
      case 'OnlineShop':
        $title = 'ร้านค้าออนไลน์ของคุณ';
        break;
    }

    return $title;

  }

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
