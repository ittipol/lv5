<?php

namespace App\Models;

use App\Models\Model;

class CompanyHasBusinessType extends Model
{
  public $table = 'company_has_business_types';
  protected $fillable = ['company_id','business_type_id'];
  public $timestamps  = false;

  public function __construct() {  
    parent::__construct();
  }
}
