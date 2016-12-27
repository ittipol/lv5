<?php

namespace App\Models;

use App\Models\Model;

class EmploymentType extends Model
{
  public $table = 'employment_types';
  protected $fillable = ['name','description'];
  public $timestamps  = false;

  public function __construct() {  
    parent::__construct();
  }
}
