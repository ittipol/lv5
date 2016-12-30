<?php

namespace App\Http\Controllers;

use App\Models\Slug;
use App\library\service;
use App\library\string;
use Route;
use Redirect;
use Session;

class EntityController extends Controller
{
  private $slug;
  private $model;
  // private $require = array(
  //   'name',
  //   'description' => array(
  //     'description',
  //     'short_description' => 'String:subString|description,120'
  //   )
  // )

  public function __construct(array $attributes = []) { 
    $param = Route::current()->parameters();
    $slug = Slug::where('name','like',$param['slug'])->first();

    // check don't have permission in this page

    $this->slug = $slug['name'];
    $this->model = service::loadModel($slug['model'])->find($slug['model_id']);
  }

  // public function checkSlug($slug) {
  //   if(empty($slug)) {
  //     // \View::make("messages.message")->with("name", 'xxx');
  //     // return $this->view('messages.message');
  //     // return Redirect::to('company/list')->send();
  //   }
  // }

  public function home() {

    $logo = $this->model->getRalatedDataByModelName('Image',true,[['type','=','logo']])->getImageUrl();

    $this->data = array(
      'name' => $this->model->name,
      'description' => $this->model->description,
      'short_description' => String::subString($this->model->description,800),
      'logo' => $logo,
      // 'cover' =< ,
      // 'entity' => $this->model->getAttributes()
    );

    return $this->view('pages.entity.index');

  } 
}
