<?php

namespace App\Models;

use App\Models\Model;

class BusinessEntity extends Model
{
  public $table = 'business_entities';
  protected $fillable = ['name','description'];
  public $timestamps  = false;
}
