<?php

namespace App\Http\Controllers;

use App\Models\Slug;
use App\library\service;
use App\library\string;
use Redirect;
use Session;

class EntityController extends Controller
{
  public function __construct(array $attributes = []) { 
    parent::__construct($attributes);

    // check don't have permission in this page
  }

  public function home() {
// dd($this->slugModel);
    $logo = '';
    if(!empty($this->slugModel->getRalatedDataByModelName('Image',true,[['type','=','logo']]))) {
      $logo = $this->slugModel->getRalatedDataByModelName('Image',true,[['type','=','logo']])->getImageUrl();
    }

    $this->data = array(
      'name' => $this->slugModel->name,
      'description' => $this->slugModel->description,
      'short_description' => String::subString($this->slugModel->description,800),
      'logo' => $logo,
      // 'cover' =< ,
      // 'entity' => $this->slugModel->getAttributes()
    );

    return $this->view('pages.entity.index');

  } 
}
