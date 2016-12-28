<?php

namespace App\Models;

use App\Models\Model;

class OnlineShop extends Model
{
  public $table = 'online_shops';
  protected $fillable = ['name','description'];
  public $timestamps  = false;

  // Allowed Data
  public $allowedRelatedModel = array('Tagging','Contact');
  public $allowedDir = array(
    'dir_names' => array('logo','cover','images')
  );
  public $allowedImage = true;
  public $allowedLookup = array(
    'format' =>  array(
      'keyword' => '{{name}}',
      // 'keyword_1' => 'Class.Field|@getRalatedDataByModelName',
      'description' => '{{description}}',
    )
  );
}
