<?php

namespace App\Models;

use App\Models\Model;
use App\Models\Role;

class PersonHasCompany extends Model
{
  public $table = 'person_has_companies';
  protected $fillable = ['person_id','company_id'];
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
    return $this->hasMany('App\Models\PersonHasDepartment','person_id','person_id');
  }

  public function __saveSpecial($companyId,$personId,$role) {

    $role = new Role;

    if(empty($personId)) {
      $personId = Session::get('Person.id');
    }

    if(!$this->checkPersonInCompany($companyId,$personId)) {
      $this->_save($companyId,$personId,$role->getIdByalias('admin'));
    }

  }

  public function _save($companyId,$personId,$roleId) {
    $personHasCompany = new PersonHasCompany;
    $personHasCompany->company_id = $companyId;
    $personHasCompany->person_id = $personId;
    $personHasCompany->role_id = $roleId;  
    $personHasCompany->save();
  }

  public function checkPersonInCompany($companyId,$personId) {
    return $this->where([
      ['person_id','=',$personId],
      ['company_id','=',$companyId]
    ])->exists();
  }

}