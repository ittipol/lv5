<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\library\token;
use App\library\service;
use Session;
use Route;
use Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // protected $primaryModel;
    // protected $secondaryModel;
    protected $slugName;
    protected $slugModel;
    protected $model;
    // protected $modelAlias;
    protected $pagePermission = false;
    // protected $actionBarText;
    // protected $hasError = false;
    protected $data = array();
    protected $formData = array();
    protected $ident;
    protected $formToken;
    protected $param;
    protected $query;

    public function __construct(array $attributes = []) { 

      $this->middleware(function ($request, $next) {

        // Get Param Form URL
        $this->param = Route::current()->parameters();

        if(!empty($this->param['slug'])) {

          // $slug = service::loadModel('Slug')->where('name','like',$this->param['slug'])->first();
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

          $this->slugName = $slug->name;
          $this->slugModel = service::loadModel($slug->model)->find($slug->model_id);
          // $this->primaryModel = $this->slugModel;

          // Get parson has entity
          $personhasEntity = $this->slugModel->getRalatedDataByModelName('PersonHasEntity',
            array(
              'first' => true,
              'conditions' => [['person_id','=',session()->get('Person.id')]]
            )
          );

          if(!empty($personhasEntity)) {
            $pagePermission = $personhasEntity->role;

            $this->pagePermission = array(
              'add' => $personhasEntity->role->adding_permission,
              'edit' => $personhasEntity->role->editing_permission,
              'delete' => $personhasEntity->role->deleting_permission,
            );
          }

        }

        if(!empty($this->param['modelAlias'])) {

          $model = service::loadModel(service::generateModelNameByModelAlias($this->param['modelAlias']));

          if(empty($model)) {
            // Go to display error page
            return response()->view('messages.message');
          }

          // $this->modelAlias = $this->param['modelAlias'];
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

      // $this->data['actionBarText'] = $this->actionBarText;   
      $this->data['slugName'] = $this->slugName;
      $this->data['pagePermission'] = $this->pagePermission;  
      $this->data['__token'] = $this->formToken;

      if(!empty($this->formData)){
        $this->data = array_merge($this->data,$this->formData);
      }

    	return view($view,$this->data);
    }

}
