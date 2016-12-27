<?php

namespace App\Models;

use App\Models\Model;

class PersonHasDepartment extends Model
{
  public $table = 'person_has_departments';
  protected $fillable = ['person_has_company_id','person_id','department_id','role_id'];
  public $timestamps  = false;

  public function __construct() {  
    parent::__construct();
  }

  public function department() {
    return $this->hasOne('App\Models\Department','id','department_id');
  }

  public function saveSpecial($personHasCompanyId,$departmentId,$personId,$role) {

    $role = new Role;

    if(!$this->checkPersonInDepartment($personHasCompanyId,$personId,$departmentId)) {

      $value = array(
        'person_has_company_id' => $personHasCompanyId,
        'person_id' => $personId,
        'department_id' => $departmentId,
        'role_id' => $role->getIdByalias('admin')
      );

      return $this->_save($value);
    }

    return true;

  }

  public function checkPersonInDepartment($personHasCompanyId,$personId,$departmentId) {
    return $this->where([
      ['person_has_company_id','=',$personHasCompanyId],
      ['person_id','=',$personId],
      ['department_id','=',$departmentId]
    ])->exists();
  }

}
