<?php

namespace App\Models;

use App\Models\Model;


class Person extends Model
{
  protected $table = 'people';
  protected $fillable = ['user_id','profile_id'];
  public $timestamps  = false;

  public function __construct() {  
    parent::__construct();
  }

  public function profile() {
    return $this->hasOne('App\Models\Profile','id');
  }

}
