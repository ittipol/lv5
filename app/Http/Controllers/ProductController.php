<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class ProductController extends Controller
{
  public function formAdd() {
    // dd('xxxx');

    Session::put($this->formToken,1);

    return $this->view('pages.product.form.add');
  }

  public function add() {

  }
}
