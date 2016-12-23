<?php

namespace App\Models;

use App\Models\Model;
use App\Models\PersonHasCompany;
use App\Models\BusinessType;
use App\Models\WordingRelation;
use Session;

class Company extends Model
{
  public $table = 'companies';
  protected $fillable = ['name','description','business_type','phone_number','email','website','facebook','instagram','line','office_hour_same_time','ip_address','created_by'];
  public $timestamps  = false;
  public $lookupFormat = array(
    'keyword' => '{{name}}',
    'keyword_1' => '{{business_type}}',
    'description' => '{{description}}',
  );
  public $createDir = true;
  public $dirNames = array('logo','cover','images');
  public $wikiFormat = array(
    'subject' => '{{name}}',
    'description' => '{{description}}',
  );

  public function __construct() {  
    parent::__construct();
  }

  public static function boot() {

    parent::boot();

    Company::saved(function($company){

      if($company->state == 'create') {
        $personHasCompany = new PersonHasCompany;
        $personHasCompany->__saveSpecial($company->id,Session::get('Person.id'),'admin');
      }

      $companyHasBusinessType = new CompanyHasBusinessType;
      $companyHasBusinessType->__saveSpecial($company,$company->business_type);

      foreach ($company->companyHasBusinessType as $value) {
        $wordingRelation = new WordingRelation;
        $wordingRelation->__saveSpecial($company,$value->businessType,$value->businessType->name);
      } 

      $lookup = new Lookup;
      $lookup->saveSpecial($company);

    });
  }

  public function companyHasDepartments() {
    return $this->hasMany('App\Models\CompanyHasDepartment','company_id','id');
  }

  public function companyHasPeople() {
    return $this->hasMany('App\Models\PersonHasCompany','company_id','id');
  }

  public function companyHasBusinessType() {
    return $this->hasMany('App\Models\CompanyHasBusinessType','company_id','id');
  }

  public function checkExistById($companyId) {
    return $this->find($companyId)->exists();
  }

}
