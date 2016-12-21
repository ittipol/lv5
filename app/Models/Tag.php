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

  private function _save($value) { 
    $tag = new Tag;
    $tag->name = $value;
    return $tag->save();
  }

  public function checkAndSave($tagName) {
    if(!$this->checkRecordExistByTagName($tagName)) {
      return $this->_save($tagName);
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
