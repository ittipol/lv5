<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Slug;
use App\library\token;
use App\library\service;
use Session;
use Route;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // protected $header = true;
    // protected $footer = true;
    protected $slug;
    protected $slugModel;
    protected $model;
    protected $modelAlias;
    protected $pagePermission = array(
      'add' => true,
      'edit' => true,
      'delete' => true,
    );
    protected $actionBarText;
    protected $data = array();
    protected $formData = array();
    protected $ident;
    protected $formToken;
    protected $param;

    public function __construct(array $attributes = []) { 
      // Get Param Form URL
      $this->param = Route::current()->parameters();

      // $this->ident = Token::generatePageIdentity(Session::get('Person.id'));
      // $this->formToken = Token::generateformToken(Session::get('Person.id'));

      // Get slug and then get model and then check permission
      // check person if in this entity
      // PersonHasEntity::where([
      //   ['model'],
      //   ['model_id'],
      //   ['model']
      // ]);
      // $company->checkRelatedDataExist('PersonHasEntity',[['person_id','=',$personId]])

      if(!empty($this->param['slug'])) {
        $_model = service::loadModel(service::generateModelByModelAlias($this->param['slug']));

        // Check slug is model
        if(!$_model) {
          $slug = Slug::where('name','like',$this->param['slug'])->first();
          $this->slug = $slug->name;
          $this->slugModel = service::loadModel($slug->model)->find($slug->model_id);
        }else{
          $this->pagePermission = false;
        }
      }

      if(!empty($this->param['modelAlias'])) {
        $this->modelAlias = $this->param['modelAlias'];
        $this->model = service::loadModel(service::generateModelByModelAlias($this->param['modelAlias']));
      }

    }

    protected function view($view) {
    	// Control layouts
    // 	$this->data['header'] = $this->header;
		  // $this->data['footer'] = $this->footer;   
      $this->data['actionBarText'] = $this->actionBarText;   
      $this->data['pagePermission'] = $this->pagePermission;  
      $this->data['__token'] = $this->formToken;

      $this->data = array_merge($this->data,$this->formData);

    	return view($view,$this->data);
    }

}
