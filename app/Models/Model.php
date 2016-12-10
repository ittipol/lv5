<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as _Model;
use App\Models\Image;
use App\Models\Address;
use Auth;
use Session;

class Model extends _Model
{
  public $modelName;
  public $alias;
  public $disk;
  public $imageDirPath;

  public function __construct(array $attributes = []) { 
    parent::__construct($attributes);
    
    $this->modelName = class_basename(get_class($this));
    $this->alias = $this->disk = strtolower($this->modelName);
    $this->imageDirPath = 'app/public/'.$this->disk.'/';
  }

  public function address() {
    if(!empty($this->id)){
      return Address::where([
        ['model','=',$this->modelName],
        ['model_id','=',$this->id]
      ])->first();
    }
    return false;
  }

  public function image() {
    if(!empty($this->id)){
      return Image::where([
        ['model','=',$this->modelName],
        ['model_id','=',$this->id]
      ])->first();
    }
    return false;
  }

  public function images() {
    if(!empty($this->id)){
      return Image::where([
        ['model','=',$this->modelName],
        ['model_id','=',$this->id]
      ])->get();
    }
    return false;
  }

}
