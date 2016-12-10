<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;
use App\Models\Image;
use Auth;
use Response;
use File;
use Storage;

class StaticFileController extends Controller
{
    private $noImage = 'images/no-img.png';

    public function serveImages($file){
      $image = Image::where('name','=',$file)->first();

      $path = null;
      if(!empty($image)){
        // $class = 'App\Models\\'.$image->model;
        // $model = new $class;
        // $path = storage_path($model->imageDirPath.$image->model_id.'/images/'.$image->name);
        $imageDirPath = 'app/public/'.strtolower($image->model).'/';
        $path = storage_path($imageDirPath.$image->model_id.'/images/'.$image->name);
      }

      if(!File::exists($path)){
        $path = $this->noImage;
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
      $avatarPath = storage_path($user->imageDirPath.Auth::user()->id.'/avatar/avatar.jpg');

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
