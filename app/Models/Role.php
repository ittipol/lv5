<?php

namespace App\Models;

class Role extends Model
{
  protected $table = 'roles';

  // public function __construct() {  
  //   parent::__construct();
  // }

  public function getIdByalias($alias) {
    $record = $this->where('alias','=',$alias)->first();
    return $record['attributes']['id'];
  }

}
