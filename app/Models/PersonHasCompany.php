<?php

namespace App\Models;

use App\Models\Model;

class PersonHasCompany extends Model
{
  public $table = 'person_has_companies';
  protected $fillable = ['person_id','company_id'];
  public $timestamps  = false;

  public function __construct() {  
    parent::__construct();
  }

  public function checkPersonInCompany($personId,$companyId) {
    return $this->where([
      ['person_id','=',$personId],
      ['company_id','=',$companyId]
    ])->count() ? true : false;
  }

  public function company() {
    return $this->hasOne('App\Models\Company','id','company_id');
  }

}