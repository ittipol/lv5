<?php

namespace App\Models;

class District extends Model
{
  protected $table = 'districts';
  protected $fillable = ['name','name_en','description'];
  public $timestamps  = false;

  public function __construct() {  
    parent::__construct();
  }
}
