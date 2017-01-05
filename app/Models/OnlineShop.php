<?php

namespace App\Models;

class OnlineShop extends Model
{
  public $table = 'online_shops';
  protected $fillable = ['name','description'];
  public $timestamps  = false;

  // Allowed Data
  public $allowedRelatedModel = array('Tagging','Contact');
  public $allowedDir = array(
    'dirNames' => array('logo','cover','images')
  );
  public $allowedImage = true;
  public $allowedLookup = array(
    'format' =>  array(
      'keyword' => '{{name}}',
      'keyword_1' => '{{Word.word|@getRalatedDataByModelName=>Tagging,Tagging.word_id=>Word.id}}',
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

    OnlineShop::saved(function($onlineShop){

      // if($onlineShop->state == 'create') {
      // }

      $lookup = new Lookup;
      $lookup->setFormToken($onlineShop->formToken)->__saveRelatedData($onlineShop);

    });
  }
}
