<?php

namespace App\Models;

use App\Models\Model;
use App\Models\Tag;

class Tagging extends Model
{
  public $table = 'taggings';
  protected $fillable = ['model','model_id','tag_id'];
  public $timestamps  = false;

  public function __construct() {  
    parent::__construct();
  }

  public function tag() {
    return $this->hasOne('App\Models\Tag','id','tag_id');
  }

  public function __saveRelatedData($model,$value) {
    
    $tag = new Tag;
    $tag->setFormToken($this->formToken);
    $tagIds = $tag->saveSpecial($value);

    return $this->clearAndSaves($model,$tagIds);
    
  }

  public function clearAndSaves($model,$tagIds) {
    // clear old record
    $this->deleteByModelNameAndModelId($model->modelName,$model->id);

    foreach ($tagIds as $tagId) {
      $this->_save($model->includeModelAndModelId(array('tag_id' => $tagId)));
    }

    return true;
  }

}
