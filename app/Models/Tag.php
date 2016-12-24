<?php

namespace App\Models;

use App\Models\Model;

class Tag extends Model
{
  public $table = 'tags';
  protected $fillable = ['name','description'];
  public $timestamps  = false;

  public function __construct() {  
    parent::__construct();
  }

  public function saveSpecial($value) {
    $tagIds = array();
    foreach ($value as $tagName) {
      $this->checkAndSave($tagName);
      $tagIds[] = $this->getTagByTagName($tagName)->id;
    }
    return $tagIds;
  }

  public function checkAndSave($tagName) {
    if(!$this->checkRecordExistByTagName($tagName)) {
      return $this->_save(array('name' => $tagName));
    }

    return true;
  }

  public function checkRecordExistByTagName($tagName) {
    return $this->where('name','like',$tagName)->exists();
  }

  public function getTagByTagName($tagName) {
    return $this->where('name','like',$tagName)->first();
  }

}
