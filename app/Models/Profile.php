<?php

namespace App\Models;

class Profile extends Model
{
  protected $table = 'profiles';
  protected $fillable = ['name','gender','birth_date'];
  public $timestamps  = false;

  public function __construct() {  
    parent::__construct();
  }
}
