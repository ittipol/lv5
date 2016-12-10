<?php

namespace App\Models;

use App\Models\Model;

class Department extends Model
{
  public $table = 'departments';
  protected $fillable = ['name','description','phone_number','email','website','facebook','line','company_address','created_by'];
  public $timestamps  = false;

  public $lookupFormat = array(
    'keyword' => '{{name}}',
    'keyword_1' => '{{_companyName}}',
    'keyword_2' => '{{_businessType}}',
    'description' => '{{description}}',
  );

  public function __construct() {  
    parent::__construct();
  }

  public function createImageFolder() {

    $coverFolder = storage_path($this->imageDirPath).'/'.$this->attributes['id'].'/cover';
    $imageFolder = storage_path($this->imageDirPath).'/'.$this->attributes['id'].'/images';

    if(!is_dir($coverFolder)){
      mkdir($coverFolder,0777,true);
    }

    if(!is_dir($imageFolder)){
      mkdir($imageFolder,0777,true);
    }
    
  }
}
