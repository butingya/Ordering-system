<?php

namespace App\Http\Controllers\Shop;

use App\Models\Info;
use App\Models\ShopCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class InfoController extends BaseController
{
    //商铺添加
      public function info(Request $request){
          if (Auth::user()->info) {
              return back()->with("danger","你已经有店铺了");
          }


          //判断post提交
          if ($request->isMethod("post")) {
              //接收数据,数据入库
                $data = $request->post();
                $data['on_time']=$request->has('on_time')?'1':'0';
                $data['brand']=$request->has('brand')?'1':'0';
                $data['fengniao']=$request->has('fengniao')?'1':'0';
                $data['bao']=$request->has('bao')?'1':'0';
                $data['piao']=$request->has('piao')?'1':'0';
                $data['zhun']=$request->has('zhun')?'1':'0';

                $data['user_id']=Auth::user()->id;
//                dd($data);
                $data['shop_img']=$request->file("shop_img")->store("images","image");


                Info::create($data);
              //跳转视图
                session()->flash('success', '申请成功等待平台管理员审核');
                return redirect()->route("shop.user.home_page");
//              session()->flash('success', '申请成功等待平台管理员审核');
          }else{
              //显示视图
                $results = ShopCategory::where("status",1)->get();
                return view("shop.info.index",compact("results"));
          }
      }
}
