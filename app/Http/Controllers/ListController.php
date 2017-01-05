<?php

namespace App\Http\Controllers;

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

    $personHasEntity = Service::loadModel('PersonHasEntity');

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

      // Get slug
      $slug = $record->getRalatedDataByModelName('Slug',
        array(
          'onlyFirst' => true,
          'fields' => array('name')
        )
      );
      if(!empty($slug)) {
        $slug = array(
          'name' => $slug->name,
          'url' => url($slug->name)
        );
      }

      // $logo = $record->getRalatedDataByModelName('Image',
      //   array(
      //     'onlyFirst' => true,
      //     'conditions' => [['type','=','logo']],
      //     'fields' => array('model','model_id','name','type') 
      //   )
      // );
      // if(!empty($logo)) {
      //   $logo = $logo->getImageUrl();
      // }

      $cover = $record->getRalatedDataByModelName('Image',
        array(
          'onlyFirst' => true,
          'conditions' => [['type','=','cover']],
          'fields' => array('model','model_id','name','type')
        )
      );
      if(!empty($cover)) {
        $cover = $cover->getImageUrl();
      }

      // $images = $record->getRalatedDataByModelName('Image',
      //   array(
      //     'onlyFirst' => true,
      //     'conditions' => [['type','=','images']]
      //     'fields' => array('model','model_id','name','type') 
      //   )
      // );
      // if(!empty($images)) {
      //   $images = $images->getImageUrl();
      // }

      $lists[] = array(
        'id' => $record->id,
        'slug' => $slug,
        'name' => $record->name,
        // 'description' => String::subString($record->description,120),
        // 'logo' => $logo,
        'cover' => $cover,
        // 'images' => $images,
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

}
