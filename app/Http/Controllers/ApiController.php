<?php

namespace App\Http\Controllers;

use App\Models\SubDistrict;
use App\Models\Image;
use App\Models\TempFile;
use App\library\service;
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

    $service = new Service;
    $imageModel = new Image;

    $image = Input::file('file');

    if($imageModel->checkMaxSize($image->getSize()) && $imageModel->checkType($image->getMimeType())) {
      $tempFile = new TempFile;
      $tempFile->name = $service->generateFileName($image);
      $tempFile->type = 'image';
      $tempFile->token = Input::get('formToken');
      $tempFile->status = 'add'; 
      $tempFile->created_by = Session::get('Person.id');

      if($tempFile->save()){
        $success = true;
        $tempFile->uploadtempImage($image,$tempFile->token,$tempFile->name);

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

    $success = false;

    // check image already exist in image table
    $imageModel = new Image;
    $total = $imageModel->where('name','=',Input::get('filename'))->count();

    $tempFile = new TempFile;

    if($total){
      $tempFile->name = Input::get('filename');
      $tempFile->type = 'image';
      $tempFile->status = 'delete';
      $tempFile->token = Input::get('formToken');
      $tempFile->created_by = Session::get('Person.id');
      
      if($tempFile->save()){
        $success = true;
      }
    }else{
      $success = $tempFile->deletetempImage(Input::get('formToken'),Input::get('filename'));

      if($success){
        $tempFile->deleteRecords(Input::get('filename'),'image','add',Input::get('formToken'),Session::get('Person.id'));
      }

    }

    $result = array(
      'success' => $success
    );

    return response()->json($result);

  }

}
