<?php

namespace App\Models;

use App\Models\Model;

class Department extends Model
{
  public $table = 'departments';
  protected $fillable = ['name','description','phone_number','email','website','facebook','line','company_address','created_by'];
  public $timestamps  = false;

  public $lookupFormat = array(
    'keyword' => '{{name}}',
    'keyword_1' => '{{_companyName|Company:name}}',
    'keyword_2' => '{{_businessType|Company:business_type}',
    'description' => '{{description}}',
  );

  public function __construct() {  
    parent::__construct();
  }

}
