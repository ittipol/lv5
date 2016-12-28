<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Models\Profile;
use App\Models\Person;
use App\Models\PersonInterest;
use App\Models\Word;
use App\library\date;
use App\library\Token;
use App\library\message;
use Auth;
use Session;
use Redirect;
// use Hash;

class UserController extends Controller
{
  public function account(){


  }

  public function profile(){
      
  }

  public function login() {

    $this->footer = false;

    if(Auth::check()){
      return redirect('home');
    }else{
      return $this->view('pages.user.login');
    }

  }

  public function auth(LoginRequest $request) { 

    $data = [
        'email' =>  $request->input('email'),
        'password'  =>  $request->input('password')
    ];

    if(Auth::attempt($data)){
      // Store data
      $person = Person::find(Auth::user()->id);
      Session::put('Person.id',$person->id);
      Session::put('Person.Profile.name',$person->profile->name);

      $message = new Message;
      $message->loginSuccess();
      return Redirect::intended('home');
    }else{
      $message = new Message;
      $message->loginFail();
      // return Redirect::back()->withErrors(['อีเมล  หรือ รหัสผ่านไม่ถูก']);
      return Redirect::back();
    }

  }

  public function registerForm() {

    if(Auth::check()){
      return redirect('/');
    }

    $dateModel = new Date;

  	$thaiLatestYear = date('Y') + 543;
  	
  	$day = array();
  	$month = array();
  	$year = array();

  	for ($i=1; $i <= 31; $i++) { 
  		$day[$i] = $i;
  	}

  	for ($i=1; $i <= 12; $i++) { 
  		$month[$i] = $dateModel->getMonthName($i);
  	}

  	for ($i=2500; $i <= $thaiLatestYear; $i++) { 
  		$year[$i] = $i;
  	}

  	$this->data = array(
  		'day' => $day,
  		'month' => $month,
  		'year' => $year
  	);

    return $this->view('pages.user.register');

  }

  public function registerAdd(RegisterRequest $request) {   

    $user = new User;
  	$user->fill($request->all());
    $user->api_token = Token::generate();

    if($user->save()){

      // create folder
      $user->createUserFolder();

      // add avatar
      $user->avatar($request->file('avatar'));

      // create profile
      $profile = new Profile;
      $profile->fill($request->all());
      $profile->save();

      // create person
      $person = new Person;
      $person->fill($request->all());
      $person->user_id = $user->id;
      $person->profile_id = $profile->id;
      $person->save();

      $tags = array();
      if(!empty($request->input('interests'))){
        $word = new Word;
        $words = $word->saveSpecial($request->input('interests'));
      }

      foreach ($words as $wordId => $word) {
        $personInterest = new PersonInterest;
        $personInterest->checkAndSave($person->id,$wordId);
      }

    }

    $message = new Message;
    $message->registerSuccess();

    return Redirect::to('login');
  }
  
}
