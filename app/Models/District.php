<?php

namespace App\Models;

use App\Models\Model;

class District extends Model
{
  protected $table = 'districts';

  public function __construct() {  
    parent::__construct();
  }
}
