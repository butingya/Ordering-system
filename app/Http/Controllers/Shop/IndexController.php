<?php

namespace App\Http\Controllers\Shop;

use App\Models\Info;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class IndexController extends BaseController
{
    //首页视图
      public function home_page(){

          if (Auth::user()->info===null) {
              return redirect()->route("shop.info.index")->with("danger","你还没有商铺快点加入我们吧");
          }
          return view("shop.user.home_page");
      }
}
