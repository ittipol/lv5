<?php

namespace App\Models;

use Session;

class Company extends Model
{
  public $table = 'companies';
  protected $fillable = ['name','description','brand_story','business_entity_id','business_type','ip_address','created_by'];
  public $timestamps  = false;

  public $formTemplate = array(
    'form' => array(
      'add' => array(
        'header' => array(
          'text' => 'เพิ่มบริษัทหรือร้านค้าของคุณ'
        ),
        'footer' => array(
          'textButton' => 'เพิ่ม'
        ),
        'components' => array(

        )
      ),
      'edit' => array(
        'header' => array(
          'text' => 'แก้ไขบริษัทหรือร้านค้าของคุณ'
        ),
        'footer' => array(
          'textButton' => 'แก้ไข'
        ),
        'components' => array(

        )
      )
    )
  );

  // Validation rules
  public $validation = array(
    'rules' => array(
      'name' => 'required|max:255',
      'Contact.phone_number' => 'max:255',
      'Contact.website' => 'max:255',
      'Contact.email' => 'email|unique:contacts,email|max:255',
      'Contact.facebook' => 'max:255',
      'Contact.instagram' => 'max:255',
      'Contact.line' => 'max:255'
    ),
    'messages' => array(
      'name.required' => 'กรุณากรอกชื่อบริษัทหรือร้านค้าของคุณ',
      'Contact.email.email' => 'อีเมลไม่ถูกต้อง',
      'Contact.email.unique' => 'อีเมลถูกใช้งานแล้ว',
    )
  );

  // sorting
  public $sortingFields = array('name','created');

  // Allowed Data
  public $allowedRelatedModel = array('Address','Tagging','OfficeHour','Contact');
  public $allowedDir = array(
    'dirNames' => array('logo','cover','images')
  );
  // public $allowedImage = array(
  //   'type' => array('logo','cover','images')
  // );
  public $allowedLookup = array(
    'format' =>  array(
      'keyword' => '{{name}}',
      'keyword_1' => '{{business_type}}',
      'description' => '{{description}}',
    )
  );
  public $allowedWiki = array(
    'format' =>  array(
      'subject' => '{{name}}',
      'description' => '{{description}}',
    )
  );
  public $allowedSlug = array(
    'field' => 'name'
  );

  public function __construct() {  
    parent::__construct();
  }

  public static function boot() {

    parent::boot();

    Company::saved(function($company){

      // if($company->state == 'create') {}

      $companyHasBusinessType = new CompanyHasBusinessType;
      $companyHasBusinessType->setFormToken($company->formToken);
      $companyHasBusinessType->saveSpecial($company,$company->business_type);

      $wordingRelation = new WordingRelation;
      $wordingRelation->setFormToken($company->formToken);
      foreach ($company->companyHasBusinessType as $value) {
        $wordingRelation->saveSpecial($company,$value->businessType,$value->businessType->name);
      } 

      $lookup = new Lookup;
      $lookup->setFormToken($company->formToken)->__saveRelatedData($company);

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
  
}
