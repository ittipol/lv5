<?php

namespace App\Models;

use App\Models\Model;

class PersonInterest extends Model
{
  protected $table = 'person_interests';
  protected $fillable = ['person_id','word_id'];
  public $timestamps  = false;

  public function __construct() {  
    parent::__construct();
  }

  public function checkRecordExist($personId,$tagId) {
    return $this->where([
      ['person_id','=',$personId],
      ['tag_id','=',$tagId]
    ])->count() ? true : false;
  }

  public function checkAndSave($personId,$tagId) {
    if(!$this->checkRecordExist($personId,$tagId)) {
      $this->person_id = $personId;
      $this->tag_id = $tagId;
      $this->save();
    }
  }

}
