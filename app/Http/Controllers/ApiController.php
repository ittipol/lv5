<?php

namespace App\Http\Controllers;

use App\Models\SubDistrict;
use App\Models\Image;
use App\Models\TempFile;
use Input;
use Session;

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

  public function uploadTempImage() {

    if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
      exit;  //trygetRealPath detect AJAX request, simply exist if no Ajax
    }

    if (!Input::hasFile('file')) {
      exit;
    }

    $success = false;
    $fileName = '';

    $image = Input::file('file');

    $imageModel = new Image;
  
    if($imageModel->checkMaxSize($image->getSize()) && $imageModel->checkType($image->getMimeType())) {
      $tempFile = new TempFile;
      $tempFile->name = $tempFile->generateTempFileName($image);
      $tempFile->type = 'image';
      $tempFile->token = Input::get('_token'); 
      $tempFile->created_by = Session::get('Person.id');

      if($tempFile->save()){
        $success = true;
        $tempFile->uploadtempImage($image,$tempFile->type,$tempFile->name);

        $fileName = $tempFile->name;

      }
    }

    $result = array(
      'success' => $success,
      'filename' => $fileName,
    );

    return response()->json($result);
  }

  public function deleteTempImage() {

    if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
      exit;  //trygetRealPath detect AJAX request, simply exist if no Ajax
    }

    $tempFile = new TempFile;
    $success = $tempFile->deletetempImage('image',Input::get('filename'));

    if($success){
      $file = $tempFile->where([
        ['name','=',Input::get('filename')],
        ['type','=','image'],
        ['token','=',Input::get('_token')],
        ['created_by','=',Session::get('Person.id')]
      ])->delete();
    }

    $result = array(
      'success' => $success
    );

    return response()->json($result);

  }

}
