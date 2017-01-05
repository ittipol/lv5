<?php

namespace App\Models;

use Session;

class Department extends Model
{
  public $table = 'departments';
  protected $fillable = ['name','description','phone_number','email','website','facebook','line','company_address','created_by'];
  public $timestamps  = false;
  public $temporaryData = array('company_id');

  // allowed Data
  public $allowedRelatedModel = array('Address');
  public $allowedDir = array(
    'dirNames' => array('logo','cover','images')
  );
  public $allowedImage = true;
  public $allowedLookup = array(
    'format' =>  array(
      'keyword' => '{{name}}',
      'keyword_1' => '{{Company.name|Department.id=>CompanyHasDepartment.department_id,CompanyHasDepartment.company_id=>Company.id}}',
      'keyword_2' => '{{Company.business_type|Department.id=>CompanyHasDepartment.department_id,CompanyHasDepartment.company_id=>Company.id}}',
      'description' => '{{description}}'
    )
  );
  public $allowedWiki = array(
    'format' =>  array(
      'subject' => '{{name}}',
      'description' => '{{description}}',
    )
  );

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
