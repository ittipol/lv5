<?php

namespace App\Models;

use App\Models\Model;

class PersonHasDepartment extends Model
{
  public $table = 'person_has_departments';
  protected $fillable = ['person_id','department_id'];
  public $timestamps  = false;

  public function __construct() {  
    parent::__construct();
  }

  public function department() {
    return $this->hasOne('App\Models\Department','id','department_id');
  }

}
