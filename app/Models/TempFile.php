<?php

namespace App\Models;

use App\Models\Model;
use App\library\Token;
use Storage;
use File;

class TempFile extends Model
{
  protected $table = 'temp_files';
  protected $fillable = ['name','type','token','created_by'];
  public $timestamps  = false;

  public function generateTempFileName($image) {
    $code = time().'_'.Token::generateNumber(15).'_'.$image->getSize();
    return $code.'.'.$image->getClientOriginalExtension();  
  }

  public function uploadtempImage($image,$token,$filename) {
    $image->move(storage_path($this->tempFileDir).$token, $filename);
  }

  public function deletetempImage($token,$filename) {
    return File::Delete(storage_path($this->tempFileDir).$token.'/'.$filename);
  }

}
