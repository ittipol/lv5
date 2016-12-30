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
    protected $entityPermission = false; // permission edit, delete, manage page
    protected $actionBarText;
    protected $data = array();
    protected $ident;
    protected $formToken;

    public function __construct(array $attributes = []) { 
        $this->ident = Token::generatePageIdentity(Session::get('Person.id'));
        $this->formToken = Token::generateformToken(Session::get('Person.id'));
    }

    protected function view($view) {
    	// Control layouts
    	$this->data['header'] = $this->header;
		$this->data['footer'] = $this->footer;   
        $this->data['__token'] = $this->formToken;

    	return view($view,$this->data);
    }

}
