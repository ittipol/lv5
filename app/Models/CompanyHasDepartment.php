<?php

namespace App\Models;

use App\Models\Model;

class CompanyHasDepartment extends Model
{
  public $table = 'company_has_departments';
  protected $fillable = ['company_id','department_id'];
  public $timestamps  = false;

  public function __construct() {  
    parent::__construct();
  }
  
  public function department() {
    return $this->hasOne('App\Models\Department','id');
  }
}
