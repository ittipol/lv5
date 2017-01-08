<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\library\token;
use App\library\service;
use App\library\entity;
use Session;
use Route;
use Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $ident;
    protected $formToken;
    // protected $slugName;
    // protected $slugModel;
    protected $model;
    protected $pagePermission = false;
    protected $data = array();
    protected $formData = array();
    protected $param;
    protected $query;
    protected $entity;

    public function __construct(array $attributes = []) { 

      $this->middleware(function ($request, $next) {

        // Get Param Form URL
        $this->param = Route::current()->parameters();

        if(!empty($this->param['slug'])) {

          $slug = service::loadModel('Slug')->getData(array(
            'conditions' => array(
              array('name','like',$this->param['slug'])
            ),
            'first' => true,
            'fields' => array('name','model','model_id')
          ));

          if(empty($slug)) {
            return response()->view('messages.message');
          }

          $entity = new Entity($slug);
          $this->entity = $entity->buildData();

        }

        if(!empty($this->param['modelAlias'])) {

          $model = service::loadModel(service::generateModelNameByModelAlias($this->param['modelAlias']));

          if(empty($model)) {
            // Go to display error page
            return response()->view('messages.message');
          }

          $this->model = $model;
        }

        return $next($request);
      });

    }

    protected function view($view = null) {

      // if(empty($view)) {
      //   $message = new Message;
      //   $message->error('ไม่พบหน้านี้');
      //   return \Redirect::back()->withErrors(['ไม่พบหน้านี้']);
      // }

      $this->data['entity'] = $this->entity;
      $this->data['__token'] = $this->formToken;

      if(!empty($this->formData)){
        $this->data = array_merge($this->data,$this->formData);
      }

    	return view($view,$this->data);
    }

}
