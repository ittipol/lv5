<?php

namespace App\Http\Controllers;

use App\Http\Requests\OnlineShopRequest;
use App\Models\OnlineShop;
use App\library\message;
use Session;
use Redirect;

class OnlineShopController extends Controller
{
  public function formAdd() {
    // set form token
    Session::put($this->formToken,1);

    return $this->view('pages.shop.form.add');
  }

  public function add(OnlineShopRequest $request) {

    $onlineShop = new OnlineShop;
    $onlineShop->fill($request->all());

    if($onlineShop->save()){
      // delete temp dir & records
      $onlineShop->deleteTempData();
      // reomove form token
      Session::forget($onlineShop->formToken);

      $message = new Message;
      $message->addingSuccess('ร้านค้า');
    }else{
      $message = new Message;
      $message->error('ไม่สามารถเพิ่มร้านค้า กรุณาลองใหม่อีกครั้ง');
      return Redirect::to('online-shop/add');
    }

    return Redirect::to('online-shop/list');
  }
}
