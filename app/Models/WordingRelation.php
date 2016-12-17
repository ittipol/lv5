<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WordingRelation extends Model
{
  public $table = 'data_relations';
  protected $fillable = ['model','model_id','tag_id','word','relate_to_word'];
  public $timestamps  = false;

  // public function checkRecordExist($model,$tagId) {
  //   return $this->where([
  //     ['model','=',$model->modelName],
  //     ['model_id','=',$model->id],
  //   ])->count() ? true : false;
  // }

  public function checkAndSave($word,$relateToWord) {

  }
}
