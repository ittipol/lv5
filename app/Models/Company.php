<?php

namespace App\Models;

use App\Models\Model;
use App\Models\PersonHasCompany;
use App\Models\BusinessType;
use App\Models\Role;
use App\Models\WordingRelation;
use Session;

class Company extends Model
{
  public $table = 'companies';
  protected $fillable = ['name','description','business_type','phone_number','email','website','facebook','instagram','line','ip_address','created_by'];
  public $timestamps  = false;
  public $lookupFormat = array(
    'keyword' => '{{name}}',
    'keyword_1' => '{{business_type}}',
    'description' => '{{description}}',
  );
  public $createDir = true;
  public $dirNames = array('logo','cover','images');

  public function __construct() {  
    parent::__construct();
  }

  public static function boot() {

    parent::boot();

    Company::saved(function($company){

      // Add person to company
      $personHasCompany = new PersonHasCompany;

      $exist = $personHasCompany->where([
        ['company_id','=',$company->id],
        ['person_id','=',Session::get('Person.id')]
      ])->exists();

      if(!$exist){
        $personHasCompany->company_id = $company->id;
        $personHasCompany->person_id = Session::get('Person.id');
        $role = new Role;
        $personHasCompany->role_id = $role->getIdByalias('admin');  
        $personHasCompany->save();
      }

      $companyHasBusinessType = new CompanyHasBusinessType;
      $companyHasBusinessType->__saveSpecial($company,$company->business_type);

      $wordingRelation = new WordingRelation;
      foreach ($company->companyHasBusinessType as $value) {
        $wordingRelation->__saveSpecial($company,$value->businessType,$value->businessType->name);
      } 

      // Add to Lookup table
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
    return $this->where('id','=',$companyId)->count() ? true : false;
  }

}
