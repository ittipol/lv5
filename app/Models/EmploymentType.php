<?php

namespace App\Models;

class EmploymentType extends Model
{
  public $table = 'employment_types';
  protected $fillable = ['name','description'];
  public $timestamps  = false;

  public function __construct() {  
    parent::__construct();
  }
}
