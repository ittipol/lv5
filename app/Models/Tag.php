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

  public function checkRecordExist($field, $data) {
    return $this->where($field,'like',$data)->count() ? true : false;
  }

  public function saveTags($tagNames = array()) { 

    $tags = array();

    foreach ($tagNames as $tagName) {
      $tag = new Tag;
      if($tag->checkRecordExist('name',$tagName)){
        $tag = $tag->where('name','like',$tagName)->first();
      }else{
        $tag->name = $tagName;
        $tag->save();
      }

      $tags[$tag->id] = $tagName;
    }

    return $tags;
  }

}
