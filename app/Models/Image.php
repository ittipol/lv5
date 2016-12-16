<?php

namespace App\Models;

use App\Models\Model;
use App\Models\TempFile;
use App\library\Token;
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
  public $noImagePath = '/images/no-img.png';

  public function __construct() {  
    parent::__construct();
  }

  // public function generateFileName($image) {
  //   $name = time().'_'.Token::generateNumber(15).'_'.$image->getSize();
  //   return $name.'.'.$image->getClientOriginalExtension(); 
  // }

  public function getImageUrl() {
    $dirPath = $this->storagePath.strtolower($this->model).'/';
    $path = storage_path($dirPath.$this->model_id.'/images/'.$this->name);

    if(File::exists($path)){
      $path = '/safe_image/'.$this->name;
    }else{
      $path = $this->noImagePath;
    }

    return $path;
  }

  public function base64Encode() {

    $dirPath = 'image/'.strtolower($this->model).'/';
    $path = storage_path($dirPath.$this->model_id.'/images/'.$this->name);

    if(!File::exists($path)){
      $path = public_path('/images/no-img.png');
    }

    return base64_encode(File::get($path));
  }

  // public function saveImages($model,$images) {

  //   foreach ($images as $image) {
  //     $imageModel = new Image;
  //     $imageModel->model = $model->modelName;
  //     $imageModel->model_id = $model->id;
  //     $imageModel->name = $imageModel->generateFileName($model,$image);
  //     if($imageModel->save()){
  //       $imageModel->saveImage($model,$image,$imageModel->name);
  //     }
  //   }
    
  //   return true;
  // }

  // public function saveImage($model,$image,$filename) {

  //   if($this->checkMaxSize($image->getSize()) && $this->checkType($image->getMimeType())) {

  //     $image->move(storage_path($model->dirPath).$this->attributes['model_id'].'/images', $filename);

  //     // use disk in filesystems.php
  //     // Storage::disk($model->disk)->put($this->attributes['model_id'].'/images'.'/'.$filename, file_get_contents($image->getRealPath()));
  //     return true;
  //   }

  //   return false;

  // }

  public function saveUploadImages($model,$token,$personId) {
    $tempFileModel = new TempFile;

    $imagesTemp = $tempFileModel->where([
      ['type','=','image'],
      ['token','=',$token],
      ['status','=','add'],
      ['created_by','=',$personId]
    ]);

    $images = $imagesTemp->get();

    foreach ($images as $image) {
      $filename = $image['attributes']['name'];

      // if(!in_array($filename, $filenames)) {
      //   continue;
      // }

      $path = storage_path($tempFileModel->tempFileDir).$token.'/'.$filename;

      if(!file_exists($path)){
        continue;
      }

      $to = storage_path($model->dirPath).$model->id.'/images/'.$filename;

      // move to real dir
      File::move($path, $to);
    
      //
      $imageModel = new Image;
      $imageModel->model = $model->modelName;
      $imageModel->model_id = $model->id;
      $imageModel->name = $filename;
      $imageModel->save();

      //
      // $tempFile->find($image['attributes']['id'])->delete();

    }
    
    // remove temp dir
    $tempFileModel->deleteTempDir($token);

    // delete temp file records
    $imagesTemp->delete();

  }

  public function deleteImages($model,$token,$personId) {

    $tempFileModel = new TempFile;

    $imagesTemp = $tempFileModel->where([
      ['type','=','image'],
      ['token','=',$token],
      ['status','=','delete'],
      ['created_by','=',$personId]
    ]);

    $images = $imagesTemp->get();

    foreach ($images as $image) {

      $this->where([
        ['model','=',$model->modelName],
        ['model_id','=',$model->id],
        ['name','=',$image['attributes']['name']]
      ])->delete();

      File::Delete(storage_path($model->dirPath).$model->id.'/images/'.$image['attributes']['name']);
    }

    // delete temp file records
    $imagesTemp->delete();

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
