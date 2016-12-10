<?php

namespace App\Http\Controllers;

use App\Models\Village;
use Auth;
use Session;


class HomeController extends Controller
{
    public function index() {
      return $this->view('pages.home.index');
    }

    public function landing() {
      return $this->view('landing');
    }

}
