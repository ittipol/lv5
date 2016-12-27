<?php

namespace App\Models;

use App\Models\Model;
use App\Models\Role;

class PersonHasCompany extends Model
{
  public $table = 'person_has_companies';
  protected $fillable = ['person_id','company_id','role_id'];
  public $timestamps  = false;

  public function __construct() {  
    parent::__construct();
  }

  public function company() {
    return $this->hasOne('App\Models\Company','id','company_id');
  }

  public function person() {
    return $this->hasOne('App\Models\Person','id','person_id');
  }

  public function personHasDepartments() {
    return $this->hasMany('App\Models\PersonHasDepartment','person_has_company_id','id');
  }

  public function saveSpecial($companyId,$personId,$role) {

    $role = new Role;

    if(empty($personId)) {
      $personId = Session::get('Person.id');
    }

    if(!$this->checkPersonInCompany($companyId,$personId)) {

      $value = array(
        'company_id' => $companyId,
        'person_id' => $personId,
        'role_id' => $role->getIdByalias('admin')
      );

      return $this->_save($value);
    }

    return true;

  }

  public function checkPersonInCompany($companyId,$personId) {
    return $this->where([
      ['company_id','=',$companyId],
      ['person_id','=',$personId]
    ])->exists();
  }

  public function checkPersonHasCompany($personId) {
    return $this->where([
      ['person_id','=',$personId]
    ])->count() ? true : false;
  }

}