<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;
use App\Models\Image;
use App\library\service;
use Auth;
use Response;
use File;
use Storage;

class StaticFileController extends Controller
{
  public function serveImages($file){
    $image = Image::where('name','=',$file)->first();

    $path = null;
    if(!empty($image)){
      $model = Service::loadModel($image->model);
      $path = storage_path($model->dirPath.$image->model_id.'/'.$image->type.'/'.$image->name);
      // $dirPath = $image->storagePath.strtolower($image->model).'/';
      // $path = storage_path($dirPath.$image->model_id.'/images/'.$image->name);
    }

    if(!File::exists($path)){
      $path = $image->noImagePath;
    }

    return response()->download($path, null, [], null);

    // $headers = array(
    //   'Cache-Control' => 'no-cache, must-revalidate',
    //   // 'Cache-Control' => 'no-store, no-cache, must-revalidate',
    //   // 'Cache-Control' => 'pre-check=0, post-check=0, max-age=0',
    //   // 'Pragma' => 'no-cache',
    //   'Content-Type' => mime_content_type($path),
    //   // 'Content-Disposition' => 'inline; filename="'.$image->name.'"',
    //   // 'Content-Transfer-Encoding' => 'binary',
    //   'Content-length' => filesize($path),
    // );

    // return Response::make(file_get_contents($path), 200, $headers);

  }

  public function avatar(){

    $user = new User;
    $avatarPath = storage_path($user->dirPath.Auth::user()->id.'/avatar/avatar.jpg');

    if(!File::exists($avatarPath)){
      $avatarPath = 'images/default-avatar.png';
    }

    return response()->download($avatarPath, null, [], null);

    // $headers = array(
    //     'Content-Type' => mime_content_type($avatarPath),
    //     'Content-Disposition' => 'inline; filename="avatar.jpg"'
    // );
    // return Response::make(file_get_contents($avatarPath), 200, $headers);

  }
}
