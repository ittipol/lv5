<?php

namespace App\Models;

class Category extends Model
{
  protected $table = 'categories';
  // protected $fillable = ['name','description'];
  public $timestamps  = false;

  public function __construct() {  
    parent::__construct();
  }
}
