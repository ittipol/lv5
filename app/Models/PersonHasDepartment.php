<?php

namespace App\Models;

use App\Models\Model;

class PersonHasDepartment extends Model
{
  public $table = 'person_has_departments';
  protected $fillable = ['person_id','department_id','role_id'];
  public $timestamps  = false;

  public function __construct() {  
    parent::__construct();
  }

  public function department() {
    return $this->hasOne('App\Models\Department','id','department_id');
  }

  public function saveSpecial($departmentId,$personId,$role) {

    $role = new Role;

    if(empty($personId)) {
      $personId = Session::get('Person.id');
    }

    if(!$this->checkPersonInDepartment($departmentId,$personId)) {

      $value = array(
        'person_id' => $personId,
        'department_id' => $departmentId,
        'role_id' => $role->getIdByalias('admin')
      );

      $this->_save($value);
    }

  }

  public function checkPersonInDepartment($departmentId,$personId) {
    return $this->where([
      ['person_id','=',$personId],
      ['department_id','=',$departmentId]
    ])->exists();
  }

}
