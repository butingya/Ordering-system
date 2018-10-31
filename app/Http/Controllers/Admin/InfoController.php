<?php

namespace App\Http\Controllers\Admin;

use App\Models\Info;
use App\Models\ShopCategory;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class InfoController extends BaseController
{
    //显示店铺申请列表
    public function list()
    {
        //显示所有数据和视图
        $info = Info::all();
        //显示商家全部信息
        return view('admin.info.list', compact("info"));
    }

    //店铺审核
    public function check($id)
    {
        $info = Info::find($id);
        $info->status = 1;
        $info->save();
        return back()->with("success", "审核通过");
    }

    //店铺禁用
    public function ban($id)
    {
        $info = Info::find($id);
        $info->status = -1;
        $info->save();
        return back()->with("success", "禁用成功");
    }

//    //编辑店铺资料
    public function edit(Request $request,$id){
        //通过id找对象
        $info = Info::find($id);
        $pic = $info['shop_img'];
        //是不是post提交
        if ($request->isMethod("post")) {
            //接收数据
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

            //图片判断
            if($request->file("shop_img")!==null){
                $data['shop_img']=$request->file("shop_img")->store("images");
            }else{
                $data['shop_img']=$info->img;
            }
            //数据入库
            if ($info->update($data)) {
                \Storage::delete($pic);
                //页面跳转
                return redirect()->route("admin.info.list")->with("success","商家店铺资料修改成功");
            }
        }  else{
            //显示视图
            $results = ShopCategory::where("status",1)->get();
            return view("admin.info.edit",compact("info","results"));
        }
    }

    //删除店铺列表
    public function del($id)
    {
        //通过id找到他
        $info = Info::find($id);
        $pic = $info['shop_img'];
        //删除
        if ($info->delete()) {
           @unlink($pic);
            return redirect()->route('admin.info.list')->with("success", "删除成功");
        }
    }

    //图片自动上传
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



    //    //给商家添加店铺
    public function shopAdd(Request $request,$id){
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

            //设置店铺的状态为0 未审核
            $data['status'] = 1;
            $data['user_id'] = $id;
            Info::create($data);
            //跳转视图
            return redirect()->route("admin.user.index")->with("success","店铺添加成功");
        }
        //显示视图
        $results = ShopCategory::where("status",1)->get();
        return view("admin.info.shop_add",compact("results"));

    }

}

