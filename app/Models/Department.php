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
  public $createImage = true;
  public $allowedRelatedModel = array('Address');

  public function __construct() {  
    parent::__construct();
  }

  public function companyHasDepartment() {
    return $this->hasOne('App\Models\CompanyHasDepartment','department_id','id');
  }

  public static function boot() {

    parent::boot();

    Department::saved(function($department){

      if($department->state == 'create') {

        // get company id
        $companyId = $department->temporaryData['company_id'];

        $companyHasDepartment = new CompanyHasDepartment;
        $companyHasDepartment->setFormToken($department->formToken);
        $companyHasDepartment->saveSpecial($companyId,$department->id);

        $personHasDepartment = new PersonHasDepartment;
        $personHasDepartment->setFormToken($department->formToken);
        $personHasDepartment->saveSpecial($department->id,Session::get('Person.id'),'admin');

      }

      $lookup = new Lookup;
      $lookup->setFormToken($department->formToken)->__saveRelatedData($department);

    });
  }

  public function fill(array $attributes) {

    if(!empty($attributes['company_address'])) {
      unset($attributes['Address']);
    }else{
      if(!empty($this->company_address) && ($this->company_address == 1)) {
        $attributes['company_address'] = 0;
      }
    }

    return parent::fill($attributes);

  }

}
