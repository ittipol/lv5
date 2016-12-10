<?php

namespace App\Models;

use App\Models\Model;

class Wiki extends Model
{
  protected $table = 'wikis';
  protected $fillable = ['model','model_id','subject','description'];
  public $timestamps  = false;

  public function __construct() {  
    parent::__construct();
  }
}
