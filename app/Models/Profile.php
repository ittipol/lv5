<?php

namespace App\Models;

use App\Models\Model;

class Profile extends Model
{
  protected $table = 'profiles';
  protected $fillable = ['name','gender','birth_date'];
  public $timestamps  = false;

  public function __construct() {  
    parent::__construct();
  }
}
