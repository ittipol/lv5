<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('logout',function(){
  Auth::logout();
  Session::flush();
  return redirect('/');
});

Route::group(['middleware' => 'auth'], function () {
  Route::get('safe_image/{file}', 'StaticFileController@serveImages');
  Route::get('avatar', 'StaticFileController@avatar');
});

Route::get('/','HomeController@landing');
Route::get('home','HomeController@index');
Route::get('session','HomeController@session');

// Account
Route::get('account','UserController@account');


// Login
Route::get('login','UserController@login');
Route::post('login','UserController@auth');


// Register
Route::get('register','UserController@registerForm')->middleware('guest');
Route::post('register','UserController@registerAdd')->middleware('guest');

// Page
Route::group(['middleware' => 'auth'], function () {
  Route::get('entity/{slug}','EntityController@home');
  Route::get('entity/{slug}/{action}','EntityController@home');
});

// Model Controller
Route::group(['middleware' => 'auth'], function () {
  // Route::get('{modelAlias}/add','FormController@formAdd');
  // Route::post('{modelAlias}/add','FormController@add');

  // Route::get('{modelAlias}/add/{param}','FormController@formAdd');
  // Route::post('{modelAlias}/add/{param}','FormController@add');
});

// Shop
Route::group(['middleware' => 'auth'], function () {
  // Route::get('online-shop/list','OnlineShopController@listView');

  // Route::get('online-shop/add','OnlineShopController@formAdd');
  // Route::post('online-shop/add','OnlineShopController@add');
});

// Product
Route::group(['middleware' => 'auth'], function () {
  // Route::get('product/list/{company_id}','ProductController@listView');

  // Route::get('product/add/{company_id}','ProductController@formAdd');
  // Route::post('product/add/{company_id}','ProductController@add');
});

// Job
Route::group(['middleware' => 'auth'], function () {
  // Route::get('job/list/{company_id}','JobController@listView');

  // Route::get('job/add/{company_id}','JobController@formAdd');;
  // Route::post('job/add/{company_id}','JobController@add');
});

// Company
Route::group(['middleware' => 'auth'], function () {
  // Route::get('company/list','CompanyController@listView');

  Route::get('company/add','CompanyController@formAdd');;
  Route::post('company/add','CompanyController@add');

  // Route::get('{slug}/edit','CompanyController@formEdit');
  // Route::patch('{slug}/edit',[
  //   'as' => '{slug}.edit',
  //   'uses' => 'CompanyController@edit'
  // ]);

});


// Department
Route::group(['middleware' => 'auth'], function () {
  // Route::get('department/list/{company_id}','DepartmentController@listView');
  // Route::get('department/add/{company_id}','DepartmentController@formAdd');
  // Route::post('department/add/{company_id}','DepartmentController@add');
});

// Matches /api/{route} URL
Route::group(['prefix' => 'api', 'middleware' => 'auth'], function () {
  Route::get('get_sub_district/{districtId}', 'ApiController@GetSubDistrict');
});

Route::group(['middleware' => 'auth'], function () {
  Route::post('upload_image', 'ApiController@uploadTempImage');
  Route::post('delete_image', 'ApiController@deleteTempImage');
});

