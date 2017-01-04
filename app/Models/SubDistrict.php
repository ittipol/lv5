<?php

namespace App\Models;

class SubDistrict extends Model
{
  public $table = 'sub_districts';
  protected $fillable = ['district_id','name','name_en','description','zip_code'];
  public $timestamps  = false;

  public function __construct() {  
    parent::__construct();
  }
}
