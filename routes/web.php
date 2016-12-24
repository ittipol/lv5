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

// Story
Route::group(['middleware' => 'auth'], function () {
  Route::get('story/add','StoryController@formAdd');
  Route::post('story/add','StoryController@add');
});


// Advertising
Route::group(['middleware' => 'auth'], function () {
  Route::get('ad/add','AdvertisingController@formAdd');
  Route::post('ad/add','AdvertisingController@add');
});


// shopping
Route::group(['middleware' => 'auth'], function () {
  Route::get('shopping/add','ShoppingController@formAdd');
  Route::post('shopping/add','ShoppingController@add');
});


// Job
Route::group(['middleware' => 'auth'], function () {
  Route::get('job/add','JobController@formAdd');
  Route::post('job/add','JobController@add');
});


// Company
Route::group(['middleware' => 'auth'], function () {
  Route::get('company/list','CompanyController@listView');

  Route::get('company/add','CompanyController@formAdd');;
  Route::post('company/add','CompanyController@add');

  Route::get('company/edit/{company_id}','CompanyController@formEdit');
  Route::patch('company/edit/{company_id}',[
    'as' => 'company.edit',
    'uses' => 'CompanyController@edit'
  ]);
});


// Department
Route::group(['middleware' => 'auth'], function () {
  Route::get('department/list/{company_id}','DepartmentController@listView');
  Route::get('department/add/{company_id}','DepartmentController@formAdd');
  Route::post('department/add/{company_id}','DepartmentController@add');

  Route::get('department/edit/{department_id}','DepartmentController@formEdit');
  Route::patch('department/edit/{department_id}',[
    'as' => 'department.edit',
    'uses' => 'DepartmentController@edit'
  ]);
});

// Matches /api/{route} URL
Route::group(['prefix' => 'api', 'middleware' => 'auth'], function () {
  Route::get('get_sub_district/{districtId}', 'ApiController@GetSubDistrict');
});

Route::group(['middleware' => 'auth'], function () {
  Route::post('upload_image', 'ApiController@uploadTempImage');
  Route::post('delete_image', 'ApiController@deleteTempImage');
});

