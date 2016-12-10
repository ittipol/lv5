<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Company;
use App\Models\Person;
use App\library\date;
use App\library\message;
use Auth;
use Redirect;

class JobController extends Controller
{

  public function formAdd() {

    if(!Auth::check()){
      $message = new Message;
      $message->loginRequest();
      return Redirect::to('login'); 
    }

    // Check user at least has 1 company
    if(Person::where('user_id','=',Auth::user()->id)->count() == 0){
      $message = new Message;
      $message->companyRequest();
      return Redirect::to('company/add'); 
    }

    $districtRecords = District::all();

    $districts = array();
    foreach ($districtRecords as $district) {
      $districts[$district['attributes']['id']] = $district['attributes']['name'];
    }

    $dateModel = new Date;
    $this->data = array(
      'districts' => $districts,
      'last_date' => $dateModel->covertDateToSting(date("Y-m-d", strtotime("+1 month", time())))
    );

    return $this->view('pages.job.form');
  }

  public function add(AdvertisingRequest $request) {
    dd($request->all());
  }

  public function formEdit() {

    
  }

}
