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
                //验证
                $this->validate($request, [
                  "shop_category_id" => "required",
                  "shop_name" => "required|unique:infos",
                  "shop_img" => "required",
                  "notice" => "required",
                  "discount" => "required",
                  "status" => "required",
                  "start_send" => "required",
                  "send_cost" => "required",
                ]);

              //设置店铺的状态为0 未审核
                $data['status'] = 0;
                $data['user_id']=Auth::user()->id;

                Info::create($data);
              //跳转视图
                session()->flash('success', '申请成功等待平台管理员审核');
                return redirect()->route("shop.user.home_page");
          }else{
              //显示视图
                $results = ShopCategory::where("status",1)->get();
                return view("shop.info.index",compact("results"));
          }
      }
   //图片上传
    public function upload(Request $request)
    {
        //处理上传
        //dd($request->file("file"));
        $file=$request->file("file");

        if ($file){
            //上传
            $url=$file->store("menu_cate");
            /// var_dump($url);
            //得到真实地址  加 http的址
//            $url=Storage::url($url);
            $data['url']=$url;
            return $data;
        }

    }
}
