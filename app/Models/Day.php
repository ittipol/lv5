<?php

namespace App\Models;

use App\Models\Model;

class Day extends Model
{
  public $table = 'days';
  protected $fillable = ['name'];
  public $timestamps  = false;
}
