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

  public function checkAndSave($tagName) {
    if(!$this->checkRecordExistByTagName($tagName)) {
      return $this->_save($tagName);
    }

    return true;
  }

  private function _save($value) { 
    $tag = new Tag;
    $tag->name = $value;
    return $tag->save();
  }

  public function checkRecordExistByTagName($tagName) {
    return $this->where('name','like',$tagName)->count() ? true : false;
  }

  // public function saveTags($tagNames = array()) { 

  //   $tags = array();

  //   foreach ($tagNames as $tagName) {
  //     $tag = new Tag;
  //     if($tag->checkRecordExistByTagName($tagName)){
  //       $tag = $tag->getTagByTagName($tagName);
  //     }else{
  //       $tag->name = $tagName;
  //       $tag->save();
  //     }

  //     $tags[$tag->id] = $tagName;
  //   }

  //   return $tags;
  // }

  public function getTagByTagName($tagName) {
    return $this->where('name','like',$tagName)->first();
  }

}
