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
    protected $pagePermission = false;
    protected $actionBarText;
    protected $data = array();
    protected $formData = array();
    protected $ident;
    protected $formToken;
    protected $param;

    public function __construct(array $attributes = []) { 

      $this->middleware(function ($request, $next) {

        $this->ident = Token::generatePageIdentity(session()->get('Person.id'));
        $this->formToken = Token::generateformToken(session()->get('Person.id'));

        // Get Param Form URL
        $this->param = Route::current()->parameters();

        if(!empty($this->param['slug'])) {

          $slug = Slug::where('name','like',$this->param['slug'])->first();

          if(empty($slug)) {
            return response()->view('messages.message');
          }

          $this->slug = $slug->name;
          $this->slugModel = service::loadModel($slug->model)->find($slug->model_id);

          if($this->slugModel->checkRelatedDataExist('PersonHasEntity',[['person_id','=',session()->get('Person.id')]])) {
            $pagePermission = $this->slugModel->getRalatedDataByModelName('PersonHasEntity',true,[['person_id','=',session()->get('Person.id')]])->role;

            $this->pagePermission = array(
              'add' => $pagePermission['adding_permission'],
              'edit' => $pagePermission['editing_permission'],
              'delete' => $pagePermission['deleting_permission'],
            );
          }

        }

        if(!empty($this->param['modelAlias'])) {

          $model = service::loadModel(service::generateModelByModelAlias($this->param['modelAlias']));

          if(empty($model)) {
            return response()->view('messages.message');
          }

          $this->modelAlias = $this->param['modelAlias'];
          $this->model = $model;
        }

        return $next($request);
      });

    }

    protected function view($view) {

    // 	$this->data['header'] = $this->header;
		  // $this->data['footer'] = $this->footer;   
      $this->data['actionBarText'] = $this->actionBarText;   
      $this->data['pagePermission'] = $this->pagePermission;  
      $this->data['__token'] = $this->formToken;

      $this->data = array_merge($this->data,$this->formData);

    	return view($view,$this->data);
    }

}
