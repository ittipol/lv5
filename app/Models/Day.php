<?php

namespace App\Models;

class Day extends Model
{
  public $table = 'days';
  protected $fillable = ['name'];
  public $timestamps  = false;
}
