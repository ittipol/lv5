<?php

namespace App\Models;

use Hash;

class User extends Model
{
    protected $table = 'users';
    protected $fillable = ['email','password'];
    protected $hidden = ['password','remember_token'];
    public $timestamps  = false;

    public $allowedDir = array(
      'dir_names' => array('avatar','images')
    );
    public $allowedImage = array(
      'type' => array('avatar','images')
    );

    public function __construct() {  
      parent::__construct();
    }

    public static function boot()
    {
    	// parent::boot();

    	User::saving(function($user){
        $user->attributes['password'] = Hash::make($user->attributes['password']);
      });

    }

    public function createUserFolder() {

      $avatarFolder = storage_path($this->profileDirPath).$this->attributes['id'].'/avatar';
      $imageFolder = storage_path($this->profileDirPath).$this->attributes['id'].'/images';
      // $storyFolder = storage_path($this->profileDirPath).'/'.$this->attributes['id'].'/story';

      if(!is_dir($avatarFolder)){
        mkdir($avatarFolder,0777,true);
      }

      if(!is_dir($imageFolder)){
        mkdir($imageFolder,0777,true);
      }

      // if(!is_dir($storyFolder)){
      //   mkdir($storyFolder,0777,true);
      // }
      
    }

    public function avatar($avatar) {

      if(!empty($avatar)){  

        $img = $avatar->getRealPath();

        if (($img_info = getimagesize($img)) === false) {
          return false;
        }
        
        $width = $img_info[0];
        $height = $img_info[1];

        switch ($img_info[2]) {
          case IMAGETYPE_GIF  : $src = imagecreatefromgif($img);  break;
          case IMAGETYPE_JPEG : $src = imagecreatefromjpeg($img); break;
          case IMAGETYPE_PNG  : $src = imagecreatefrompng($img);  break;
          default : die("Unknown filetype");
        }

        $tmp = imagecreatetruecolor($width, $height);
        imagecopyresampled($tmp, $src, 0, 0, 0, 0, $width, $height, $width, $height);
        imagejpeg($tmp, storage_path($this->profileDirPath).$this->attributes['id'].'/avatar/avatar.jpg',100);
        imagedestroy($tmp);
        
      }
    }
}
