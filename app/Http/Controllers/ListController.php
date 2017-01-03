<?php

namespace App\Http\Controllers;

use App\Models\PersonHasEntity;
use App\library\string;
use App\library\service;
use Request;
use Session;
use Schema;
use Input;

class ListController extends Controller
{

  protected $allowedModel = array('Company','Department','Job','Product'); 

  public function __construct(array $attributes = []) { 
    parent::__construct($attributes);

    $this->query = Request::query();

    if(!empty($this->query['q'])) {
      $this->model = Service::loadModel(service::generateModelNameByModelAlias($this->query['q']));
      $this->modelAlias = $this->query['q'];
    }

    if(empty($this->model)) {
      // error
      exit('error model not found!!!');
    }

  }

  public function index() {

    // URL
    // list?q=company&filter=franchise:assassins,franchise:tom&sort=name:asc

    // $url = Request::url();

    // foreach($qs as $key => $value){
    //   $qs[$key] = sprintf('%s=%s',$key, urlencode($value));
    // }
    // $url = sprintf('%s?%s', $url, implode('&', $qs));

    $sort = 'name';
    $order = 'ASC';
    if(!empty($this->query['sort'])){
      $parts = explode(':', $this->query['sort']);

      if(!empty($parts[1]) && strtolower($parts[1]) == 'desc'){
        $order = 'DESC';
      }

      if(Schema::hasColumn($this->model->table, $parts[0])) {
        $sort = $parts[0];
      }

    }

    $personHasEntity = new PersonHasEntity;

    $records = $this->model
               ->select($this->model->table.'.*')
               ->join($personHasEntity->table, $personHasEntity->table.'.model_id', '=', $this->model->table.'.id')
               ->where([
                 [$personHasEntity->table.'.person_id','=',Session::get('Person.id')],
                 [$personHasEntity->table.'.model','=',$this->model->modelName]
               ])
               ->orderBy($this->model->table.'.'.$sort, $order)
               ->get();

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


    $lists = array();
    foreach ($records as $record) {
      // Get Entity
      // $record = $this->model->find($record->model_id);

      // Get slug
      $slug = null;
      if(!empty($record->checkRelatedDataExist('Slug'))) {
        $slug = array(
          'name' => $record->getRalatedDataByModelName('Slug',true)->name,
          'url' => url($record->getRalatedDataByModelName('Slug',true)->name)
        );
      }

      $logo = ''; // default cover
      if(!empty($record->checkRelatedDataExist('Image',[['type','=','logo']]))) {
        $logo = $record->getRalatedDataByModelName('Image',true,[['type','=','logo']])->getImageUrl();
      }

      $cover = ''; // default cover
      if(!empty($record->checkRelatedDataExist('Image',[['type','=','cover']]))) {
        $cover = $record->getRalatedDataByModelName('Image',true,[['type','=','cover']])->getImageUrl();
      }

      $image = '';
      if(!empty($record->checkRelatedDataExist('Image',[['type','=','images']]))) {
        $image = $record->getRalatedDataByModelName('Image',true,[['type','=','images']])->getImageUrl();
      }

      $lists[] = array(
        'id' => $record->id,
        'slug' => $slug,
        'name' => $record->name,
        // 'description' => String::subString($record->description,120),
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

    $sortingOptions = array(
      'sort' => array(
        'title' => 'เรียง',
        'type' => 'radio',
        'options' => $this->generateSorting($this->model->sortingFields,$sort,$order)
      ),
      'filter' => array(
        'title' => 'กรอง',
        'type' => 'checkbox',
        'options' => array()
      )
    );

    $this->data = array(
      'lists' => $lists,
      'title' => $this->getTitle($this->model->modelName),
      'sortingOptions' => $sortingOptions
    );

    return $this->view('list.default_list');

  }

  private function generateSorting($sortingFields,$sort,$order) {
    $options = array();

    foreach ($sortingFields as $sortingField) {

      $checked = false;
      if(($sortingField == $sort) && (strtolower($order) == 'asc')){
        $checked = true;
      }                       

      $options[] = array(
        'name' => $this->getsortiongOptionName($sortingField,'asc'),
        'value' => $sortingField.':asc',
        'id' => $this->modelAlias.':'.$sortingField.':asc',
        'checked' => $checked
      );

      $checked = false;
      if(($sortingField == $sort) && (strtolower($order) == 'desc')){
        $checked = true;
      }     

      $options[] = array(
        'name' => $this->getsortiongOptionName($sortingField,'desc'),
        'value' => $sortingField.':desc',
        'id' => $this->modelAlias.':'.$sortingField.':desc',
        'checked' => $checked
      );

    }

    return $options;
  }

  private function getsortiongOptionName($field, $order) {

    $name = '';

    if(($field == 'name') && ($order == 'asc')) {
      $name = 'ตัวอักษร A - Z ก - ฮ';
    }elseif(($field == 'name') && ($order == 'desc')){
      $name = 'ตัวอักษร Z - A ฮ - ก';
    }elseif(($field == 'created') && ($order == 'asc')){
      $name = 'วันที่เก่าที่สุดไปหาใหม่ที่สุด';
    }elseif(($field == 'created') && ($order == 'desc')){
      $name = 'วันที่ใหม่ที่สุดไปหาเก่าที่สุด';
    }

    return $name;

  }

  // private function getOption($modelName) {

  // }

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
