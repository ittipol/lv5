<?php

namespace App\Http\Controllers;

use App\Models\Slug;
use Route;
use Redirect;
use Session;

class PageController extends Controller
{
  private $slug;
  private $pageModel;
  private $pageModelId;

  public function __construct(array $attributes = []) { 
    $param = Route::current()->parameters();
    $slug = Slug::where('name','like',$param['slug'])->first();

    // check don't have permission in this page

    $this->slug = $slug['name'];
    $this->pageModel = $slug['model'];
    $this->pageModelId = $slug['model_id'];
  }

  // public function checkSlug($slug) {
  //   if(empty($slug)) {
  //     // \View::make("messages.message")->with("name", 'xxx');
  //     // return $this->view('messages.message');
  //     // return Redirect::to('company/list')->send();
  //   }
  // }

  public function home() {
    dd($this->slug);
  } 
}
