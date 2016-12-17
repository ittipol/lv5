<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\library\token;
use Session;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $header = true;
    protected $footer = true;
    protected $data = array();
    protected $pageToken;

    public function __construct(array $attributes = []) { 
        $this->pageToken = Token::generateFormToken(Session::get('Person.id'));
    }

    protected function view($view) {

    	// Control layouts
    	$this->data['header'] = $this->header;
		$this->data['footer'] = $this->footer;   
        $this->data['__token'] = $this->pageToken;

    	return view($view,$this->data);
    }

}
