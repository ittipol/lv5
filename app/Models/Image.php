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
  public $imageMaxSize = 3145728; 

  public function __construct() {  
    parent::__construct();
  }

  public function generateFileName($model,$image) {

    // $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    // $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet = "0123456789";

    $name = '';
    $len = strlen($codeAlphabet);

    for ($i = 0; $i < 15; $i++) {
      $name .= $codeAlphabet[rand(0,$len-1)];
    };

    $name = time().'_'.$name.'_'.$model->id.'_'.$image->getSize();

    return $name.'.'.$image->getClientOriginalExtension();  
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
      $this->model = $model->modelName;
      $this->model_id = $model->id;
      $this->name = $this->generateFileName($model,$image);
      if($this->save()){
        $this->saveImage($model,$image,$this->name);
      }
    }
    return true;
  }

  public function saveImage($model,$image,$filename) {

    if($image->getSize() <= $this->imageMaxSize){

      $image->move(storage_path($model->imageDirPath).$this->attributes['model_id'].'/images', $filename);

      // use disk in filesystems.php
      // Storage::disk($model->disk)->put($this->attributes['model_id'].'/images'.'/'.$filename, file_get_contents($image->getRealPath()));
      return true;
    }

    return false;

  }

}
