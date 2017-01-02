<?php

namespace App\Models;

use App\Models\Model;
use App\Models\Role;

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

  public function __saveRelatedData($model,$personId,$roleAlias) {

    $role = new Role;

    if(!$model->checkRelatedDataExist($this->modelName,[['person_id','=',$personId]])){

      $value = array(
        'person_id' => $personId,
        'role_id' => $role->getIdByalias($roleAlias)
      );

      return $this->_save($model->includeModelAndModelId($value));

    }

    return true;

  }
}
