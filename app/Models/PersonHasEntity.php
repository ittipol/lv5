<?php

namespace App\Models;

class PersonHasEntity extends Model
{
  public $table = 'person_has_entities';
  protected $fillable = ['person_id','model','model_id','role_id'];
  public $timestamps  = false;

  public function __construct() {  
    parent::__construct();
  }

  public function role() {
    return $this->hasOne('App\Models\Role','id','role_id');
  }

  public function companies() {
    return $this->hasOne('App\Models\Company','id','model_id');
  }

  public function onlineShops() {
    return $this->hasOne('App\Models\OnlineShop','id','model_id');
  }

  public function __saveRelatedData($model,$options = array()) {

    $role = new Role;

    $personHasEntity = $model->getRalatedDataByModelName($this->modelName,
      array(
        'conditions' => [['person_id','=',$options['person_id']]]
      )
    );

    if(empty($personHasEntity)){

      $value = array(
        'person_id' => $options['person_id'],
        'role_id' => $role->getIdByalias($options['role_alias'])
      );

      return $this->_save($model->includeModelAndModelId($value));

    }

    return true;

  }
}
