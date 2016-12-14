<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

      // app('view')->composer('layouts.master', function ($view) {
      //   $action = app('request')->route()->getAction();

      //   $controller = class_basename($action['controller']);

      //   list($controller, $action) = explode('@', $controller);

      //   $view->with(compact('controller', 'action'));
      // });

      $root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http');

      if(!empty($_SERVER['HTTP_HOST'])){
          $root .= '://' . $_SERVER['HTTP_HOST'] . '/';
      }

      view()->share('root',$root);

      // Update your AppServiceProvider by adding a view composer to the boot method and using '*' to share it with all views
      view()->composer('*', function($view){
          $viewName = str_replace('.', '/', $view->getName());
          view()->share('cssPath', 'css/'.$viewName.'.css'); 
          view()->share('jsPath', 'js/'.$viewName.'.js'); 
      });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
      //
    }
}
