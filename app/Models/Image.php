<?php

namespace App\Models;

use App\Models\Model;
use Auth;
use Storage;
use File;

class Image extends Model
{
  protected $table = 'images';
  protected $fillable = ['model','model_id','alias','name'];
  public $timestamps  = false;
  public $maxFileSize = 3145728; 
  public $allowedFileTypes = ['image/jpg','image/jpeg','image/png', 'image/pjpeg']; 

  public function __construct() {  
    parent::__construct();
  }

  public function generateFileName($model,$image) {
    $code = time().'_'.$this->generateCode().'_'.$model->id.'_'.$image->getSize();
    return $code.'.'.$image->getClientOriginalExtension();  
  }

  public function getImageUrl() {
    $imageDirPath = 'app/public/'.strtolower($this->model).'/';
    $path = storage_path($imageDirPath.$this->model_id.'/images/'.$this->name);

    if(File::exists($path)){
      $path = '/safe_image/'.$this->name;
    }else{
      $path = $this->noImagePath;
    }

    return $path;
  }

  public function base64Encode() {

    $imageDirPath = 'image/'.strtolower($this->model).'/';
    $path = storage_path($imageDirPath.$this->model_id.'/images/'.$this->name);

    if(!File::exists($path)){
      $path = public_path('/images/no-img.png');
    }

    return base64_encode(File::get($path));
  }

  public function saveImages($model,$images) {

    foreach ($images as $image) {
      $imageModel = new Image;
      $imageModel->model = $model->modelName;
      $imageModel->model_id = $model->id;
      $imageModel->name = $imageModel->generateFileName($model,$image);
      if($imageModel->save()){
        $imageModel->saveImage($model,$image,$imageModel->name);
      }
    }
    
    return true;
  }

  public function saveImage($model,$image,$filename) {

    if($this->checkMaxSize($image->getSize()) && $this->checkType($image->getMimeType())) {

      $image->move(storage_path($model->imageDirPath).$this->attributes['model_id'].'/images', $filename);

      // use disk in filesystems.php
      // Storage::disk($model->disk)->put($this->attributes['model_id'].'/images'.'/'.$filename, file_get_contents($image->getRealPath()));
      return true;
    }

    return false;

  }

  public function checkMaxSize($size) {
    if($size <= $this->maxFileSize) {
      return true;
    }
    return false;
  }

  public function checkType($type) {
    if (in_array($type, $this->allowedFileTypes)) {
      return true;
    }
    return false;
  }

}
