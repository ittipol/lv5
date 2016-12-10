<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $header = true;
    protected $footer = true;
    protected $data = array();

    protected function view($view) {

    	// Control layouts
    	$this->data['header'] = $this->header;
		$this->data['footer'] = $this->footer;   

    	return view($view,$this->data);
    }

}
