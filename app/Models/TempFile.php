<?php

namespace App\Models;

use App\library\Token;
use Storage;
use File;

class TempFile extends Model
{
  protected $table = 'temp_files';
  protected $fillable = ['name','type','token','status','created_by'];
  public $timestamps  = false;
  public $tempFileDir = 'tmp/';

  public function __construct() {  
    parent::__construct();
  }

  public function uploadtempFile($image,$token,$filename) {
    $image->move(storage_path($this->tempFileDir).$token, $filename);
  }

  public function deletetempFile($token,$filename) {
    return File::Delete(storage_path($this->tempFileDir).$token.'/'.$filename);
  }

  public function deleteTempDir($token) {
    return File::deleteDirectory(storage_path($this->tempFileDir).$token);
  }

  public function deleteRecord($name,$token,$type,$status,$personId) {
    return $this->where([
      ['name','=',$name],
      ['token','=',$token],
      ['type','=',$type],
      ['status','=',$status],
      ['created_by','=',$personId]
    ])->delete();
  }

  public function deleteRecords($token,$type,$status,$personId) {
    return $this->where([
      ['token','=',$token],
      ['type','=',$type],
      ['status','=',$status],
      ['created_by','=',$personId]
    ])->delete();
  }

  public function deleteRecordByToken($token,$personId) {
    return $this->where([
      ['token','=',$token],
      ['created_by','=',$personId]
    ])->delete();
  }

  public function checkDataExistByToken($token) {
    return $this->where([
      ['token','=',$token]
    ])->count() ? true : false;
  }

}
