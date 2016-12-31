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
      // Get Param Form URL
      $this->param = Route::current()->parameters();

      $this->middleware(function ($request, $next) {

        if(!empty($this->param['slug'])) {
          $_model = service::loadModel(service::generateModelByModelAlias($this->param['slug']));

          // Check slug is model
          if(!$_model) {
            $slug = Slug::where('name','like',$this->param['slug'])->first();
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

          }else{
            $this->pagePermission = false;
          }
        }

        if(!empty($this->param['modelAlias'])) {
          $this->modelAlias = $this->param['modelAlias'];
          $this->model = service::loadModel(service::generateModelByModelAlias($this->param['modelAlias']));
        }

        return $next($request);
      });

      // $this->ident = Token::generatePageIdentity($this->personId);
      // $this->formToken = Token::generateformToken($this->personId);

      // if(!empty($this->param['slug'])) {
      //   $_model = service::loadModel(service::generateModelByModelAlias($this->param['slug']));

      //   // Check slug is model
      //   if(!$_model) {
      //     $slug = Slug::where('name','like',$this->param['slug'])->first();
      //     $this->slug = $slug->name;
      //     $this->slugModel = service::loadModel($slug->model)->find($slug->model_id);

      //     // dd($this->slugModel->checkRelatedDataExist('PersonHasEntity',[['person_id','=',Session::get('Person.id')]]));

      //   }else{
      //     $this->pagePermission = false;
      //   }
      // }

      // if(!empty($this->param['modelAlias'])) {
      //   $this->modelAlias = $this->param['modelAlias'];
      //   $this->model = service::loadModel(service::generateModelByModelAlias($this->param['modelAlias']));
      // }

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
