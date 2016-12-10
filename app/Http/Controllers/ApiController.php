<?php

namespace App\Http\Controllers;

use App\Models\SubDistrict;

class ApiController extends Controller
{
  public function GetSubDistrict($districtId = null) {

    $subDistrictRecords = SubDistrict::where('district_id', '=', $districtId)->get(); 

    $subDistricts = array();
    foreach ($subDistrictRecords as $subDistrict) {
      $subDistricts[$subDistrict['attributes']['id']] = $subDistrict['attributes']['name'];
    }

    return response()->json($subDistricts);
  }
}
