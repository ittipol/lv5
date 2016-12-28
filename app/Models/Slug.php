<?php

namespace App\Models;

use App\Models\Model;
use App\library\token;

class Slug extends Model
{
  public $table = 'slugs';
  protected $fillable = ['model','model_id','name'];
  public $timestamps  = false;

  public function __saveRelatedData($model) {
    $includeToken = false;

    do {
        $slug = $this->generateSlug($model,$includeToken); 
        $includeToken = true;
    } while ($this->checkDataExistBySlug($slug));

    $this->_save($model->includeModelAndModelId(array('name' => $slug)));
  }

  private function generateSlug($model,$includeToken = false) {

    if(empty($model->allowedSlug['field'])){
      return false;
    }

    $field = $model->allowedSlug['field'];

    if(empty($model->{$field})) {
      return false;
    }

    $slug = str_replace(' ', '-', $model->{$field});

    if($includeToken) {
      $slug .= '-'.Token::generateNumber(10);
    }

    return $slug;

  }

  public function checkDataExistBySlug($slug) {
    return $this->where('name','like',$slug)->exists();
  }

}
