<?php

namespace App\Models;

use App\Models\Model;

class Company extends Model
{
  public $table = 'companies';
  protected $fillable = ['name','description','business_type','phone_number','email','website','facebook','instagram','line','created_by'];
  public $timestamps  = false;
  public $lookupFormat = array(
    'keyword' => '{{name}}',
    'keyword_1' => '{{business_type}}',
    'description' => '{{description}}',
  );

  public function __construct() {  
    parent::__construct();
  }

  public function companyHasDepartments() {
    return $this->hasMany('App\Models\CompanyHasDepartment','company_id','id');
  }

  public function companyHasPeople() {
    return $this->hasMany('App\Models\PersonHasCompany','company_id','id');
  }

  public function createImageFolder() {

    $coverFolder = storage_path($this->imageDirPath).'/'.$this->attributes['id'].'/cover';
    $imageFolder = storage_path($this->imageDirPath).'/'.$this->attributes['id'].'/images';
    // $storyFolder = storage_path($this->profileFolderName).'/'.$this->attributes['id'].'/story';

    if(!is_dir($coverFolder)){
      mkdir($coverFolder,0777,true);
    }

    if(!is_dir($imageFolder)){
      mkdir($imageFolder,0777,true);
    }

    // if(!is_dir($storyFolder)){
    //   mkdir($storyFolder,0777,true);
    // }
    
  }

  public function checkExistById($companyId) {
    return $this->where('id','=',$companyId)->count() ? true : false;
  }

}
