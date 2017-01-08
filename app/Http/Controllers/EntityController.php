<?php

namespace App\Http\Controllers;

use App\Models\Slug;
use App\library\service;
use App\library\string;
use Redirect;
use Session;

class EntityController extends Controller
{
  public function __construct(array $attributes = []) { 
    parent::__construct($attributes);
  }

  public function index() {

    $shop = array();

    $logo = $this->entity['model']->getRalatedDataByModelName('Image',
      array(
        'first' => true,
        'conditions' => [['type','=','logo']]
      )
    );
    if(!empty($logo)) {
      $logo = $logo->getImageUrl();
    }

    $cover = $this->entity['model']->getRalatedDataByModelName('Image',
      array(
        'first' => true,
        'conditions' => [['type','=','cover']]
      )
    );
    if(!empty($cover)) {
      $cover = $cover->getImageUrl();
    }

    // $contact = $this->entity['model']->getRalatedDataByModelName('Contact',
    //   array(
    //     'first' => true,
    //   )
    // );
    // if(!empty($contact)) {
    //   $contact = $contact->getAttributes();
    // }

    // $officeHour = $this->entity['model']->getRalatedDataByModelName('OfficeHour',
    //   array(
    //     'first' => true,
    //     'fields' => array('time')
    //   )
    // );
    // if(!empty($officeHour)) {
    //   $officeHour = json_decode($officeHour->time,true);
    // }

    // $today = date('N');
    // $shop = array(
    //   // 'display' => true,
    //   'status' => 'วันนี้ปิดทำการ',
    //   'workingTime' => array()
    // );
    // $day = Service::loadModel('Day');
    // foreach ($officeHour as $key => $time) {

    //   $startTime = explode(':', $time['start_time']);
    //   $endTime = explode(':', $time['end_time']);

    //   $_time = 'ปิด';
    //   if($time['open']){
    //     $_time = $startTime[0].':'.$startTime[1].'-'.$endTime[0].':'.$endTime[1];
    //   }

    //   if(($today == $key) && $time['open']) {
    //     $shop['status'] = 'วันนี้เปิดทำการ '.$_time ;
    //   }

    //   $shop['workingTime'][$key] = array(
    //     'day' => $day->find($key)->name,
    //     'workingTime' => $_time
    //   );

    // }
// dd($this->entity);
    $this->data = array(
      // 'name' => $this->entity['model']->name,
      // 'description' => $this->entity['model']->description,
      // 'short_description' => String::subString($this->entity['model']->description,800),
      'logo' => $logo,
      'cover' => $cover,
    );

    return $this->view('entity.template.main');

  } 
}
