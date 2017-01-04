<?php

namespace App\Models;

class Story extends Model
{
  protected $table = 'stories';
  protected $fillable = ['description','place_name','created_by'];
  public $timestamps  = false;

  public $lookupFormat = array(
    'keyword' => '{{description}} {{place_name}}',
    'keyword_1' => '{{place_name}}'
  );

  public function __construct() {  
    parent::__construct();
  }
}
