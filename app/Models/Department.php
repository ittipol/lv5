<?php

namespace App\Models;

use App\Models\Model;
use App\Models\CompanyHasDepartment;
use App\Models\PersonHasDepartment;
use App\Models\Lookup;
use Session;

class Department extends Model
{
  public $table = 'departments';
  protected $fillable = ['name','description','phone_number','email','website','facebook','line','company_address','created_by'];
  public $timestamps  = false;
  public $createLookup = true;
  public $lookupFormat = array(
    'keyword' => '{{name}}',
    'keyword_1' => '{{Company.name|Department.id=>CompanyHasDepartment.department_id,CompanyHasDepartment.company_id=>Company.id}}',
    'keyword_2' => '{{Company.business_type|Department.id=>CompanyHasDepartment.department_id,CompanyHasDepartment.company_id=>Company.id}}',
    'description' => '{{description}}',
  );
  public $createDir = true;
  public $dirNames = array('logo','cover','images');
  public $wikiFormat = array(
    'subject' => '{{name}}',
    'description' => '{{description}}',
  );
  public $temporaryData = array('company_id');

  public function __construct() {  
    parent::__construct();
  }

  public static function boot() {

    parent::boot();

    Department::saved(function($department){

      // get company id
      $companyId = $department->temporaryData['company_id'];

      if($department->state == 'create') {

        $companyHasDepartment = new CompanyHasDepartment;
        $companyHasDepartment->__saveSpecial($companyId,$department->id);

        $personHasDepartment = new PersonHasDepartment;
        $personHasDepartment->__saveSpecial($department->id,Session::get('Person.id'),'admin');

      }

      $lookup = new Lookup;
      $lookup->saveSpecial($department);

    });
  }

  public function fill(array $attributes) {
 
    if(!empty($attributes['company_address'])) {
      unset($attributes['Address']);
    }

    return parent::fill($attributes);

  }

}
