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

  public function __saveSpecial($departmentId,$personId,$role) {

    $role = new Role;

    if(empty($personId)) {
      $personId = Session::get('Person.id');
    }

    if(!$this->checkPersonInDepartment($departmentId,$personId)) {
      $this->_save($departmentId,$personId,$role->getIdByalias('admin'));
    }

  }

  public function _save($departmentId,$personId,$roleId) {
    $personHasDepartment = new PersonHasDepartment;
    $personHasDepartment->department_id = $departmentId;
    $personHasDepartment->person_id = $personId;
    $personHasDepartment->role_id = $roleId;  
    $personHasDepartment->save();
  }

  public function checkPersonInDepartment($departmentId,$personId) {
    return $this->where([
      ['person_id','=',$personId],
      ['department_id','=',$departmentId]
    ])->exists();
  }

}
