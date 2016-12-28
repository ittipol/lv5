<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShopRequest;
use Illuminate\Http\Request;
use Session;

class ShopController extends Controller
{
  public function formAdd() {
    // set form token
    Session::put($this->formToken,1);

    return $this->view('pages.shop.form.add');
  }

  public function add(ShopRequest $request) {
    dd($request->all());
  }
}
