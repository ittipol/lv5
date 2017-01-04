<?php

namespace App\Models;

class Village extends Model
{
    protected $table = 'Villages';
    protected $fillable = ['district_id','sub_district_id','name','name_en','description'];
    public $timestamps  = false;

    public function __construct() {  
      parent::__construct();
    }
}
