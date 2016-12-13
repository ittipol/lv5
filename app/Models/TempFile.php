<?php

namespace App\Models;

use App\Models\Model;
use Storage;
use File;

class TempFile extends Model
{
  protected $table = 'temp_files';
  protected $fillable = ['name','type','token','created_by'];
  public $timestamps  = false;

  public function generateTempFileName($image) {
    $code = time().'_'.$this->generateCode().'_'.$image->getSize();
    return $code.'.'.$image->getClientOriginalExtension();  
  }

  public function uploadtempImage($image,$type,$filename) {
    $image->move(storage_path($this->tempFileDir).$type, $filename);
  }

  public function deletetempImage($type,$filename) {
    return File::Delete(storage_path($this->tempFileDir).$type.'/'.$filename);
  }

}
