<?php

namespace App\Models;

use App\Models\Model;

class OfficeHour extends Model
{
  public $table = 'office_hours';
  protected $fillable = ['company_id','day','start_time','end_time','closed'];
  public $timestamps  = false;
}
