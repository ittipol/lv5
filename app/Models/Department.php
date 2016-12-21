<?php

namespace App\Models;

use App\Models\Model;

class Department extends Model
{
  public $table = 'departments';
  protected $fillable = ['name','description','phone_number','email','website','facebook','line','company_address','created_by'];
  public $timestamps  = false;
  public $createLookup = true;
  public $lookupFormat = array(
    'keyword' => '{{name}}',
    'keyword_1' => '{{_companyName|Company:name}}',
    'keyword_2' => '{{_businessType|Company:business_type}',
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

      $role = new Role;
      $personHasCompany = new PersonHasCompany;

      if($company->state == 'create') {
        // Add person to company
        $exist = $personHasCompany->where([
          ['company_id','=',$company->id],
          ['person_id','=',Session::get('Person.id')]
        ])->exists();

        if(!$exist){
          $personHasCompany->company_id = $company->id;
          $personHasCompany->person_id = Session::get('Person.id');
          $personHasCompany->role_id = $role->getIdByalias('admin');  
          $personHasCompany->save();
        }

      }

      $companyHasBusinessType->__saveSpecial($company,$company->business_type);

      foreach ($company->companyHasBusinessType as $value) {
        $wordingRelation->__saveSpecial($company,$value->businessType,$value->businessType->name);
      } 

    });
  }

  public function fill(array $attributes) {

    if(!empty($attributes['company_address'])) {
      unset($attributes['Address']);
    }

    return parent::fill($attributes);

  }

}
