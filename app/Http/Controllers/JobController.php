<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Company;
use App\Models\Person;
use App\Models\PersonHasCompany;
use App\library\date;
use App\library\message;
use Auth;
use Redirect;
use Session;

class JobController extends Controller
{

  public function formAdd() {

    $personHasCompany = new PersonHasCompany;
    if(!$personHasCompany->checkPersonHasCompany(Session::get('Person.id'))) {
      $message = new Message;
      $message->companyRequireAtLeastOne();
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
