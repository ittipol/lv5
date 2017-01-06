<?php

namespace App\Models;

use App\library\token;

class Slug extends Model
{
  public $table = 'slugs';
  protected $fillable = ['model','model_id','name'];
  public $timestamps  = false;

  // ** reserved word **
  // company
  // online-shop
  // job
  // ad
  // product

  public function __construct() {  
    parent::__construct();
  }

  public function __saveRelatedData($model,$options = array()) {

    if(empty($model->allowed['Slug']['fields'])) {
      return false;
    }

    $options = array(
      'fields' => $model->allowed['Slug']['fields']
    );

    $save = true;

    do {
      $slug = $this->generateSlug($model,$options); 

      if(empty($slug)){
        $save = false;
      }

    } while ($this->checkDataExistBySlug($slug));

    if($save) {
      return $this->_save($model->includeModelAndModelId(array('name' => $slug)));
    }

    // return $save;

  }

  private function generateSlug($model,$options = array()) {

    // $includeToken = false;

    if(empty($options['fields']) || empty($model->{$options['fields']})){
      return false;
    }

    $slug = str_replace(' ', '-', trim($model->{$options['fields']}));

    // if(strlen($slug) <= 16) {
    //   $includeToken = true;
    // }

    // if($includeToken) {
    //   $slug .= '-'.Token::generateNumber(10);
    // }

    $slug .= '-'.Token::generateNumber(10);

    return $slug;

  }

  public function checkDataExistBySlug($slug) {
    return $this->where('name','like',$slug)->exists();
  }

}
