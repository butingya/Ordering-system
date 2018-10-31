<?php

namespace App\Http\Controllers\Admin;

use App\Models\Info;
use App\Models\ShopCategory;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    //显示所有商户
      public function index(){
          //显示全部数据，视图
            $users = User::all();
            return view("admin.user.index",compact("users"));
      }
    //添加商户
      public function add(Request $request){
          //判断提交方式
            if ($request->isMethod("post")) {
              //接收数据，数据入库，显示视图
                $data = $request->post();
              //验证
                $this->validate($request, [
                    "name" => "required|unique:users",
                    "password" => "required",
                    "email" => "required|unique:users"
                ]);
              //密码加密
                $data['password'] = bcrypt($data['password']);
                if (User::create($data)) {
                    return redirect()->route("admin.user.index")->with("success","商家添加成功");
                }
            }else{
                //显示视图
                return view("admin.user.add");
            }
        }
    //编辑商家资料
    public function edit(Request $request,$id){
        //通过id找对象
        $user = User::find($id);
        //是不是post提交
        if ($request->isMethod("post")) {
            $data = $request->post();
            //验证
            $this->validate($request, [
                "name" => "required|unique:users",
                "email" => "required|unique:users"
            ]);
            //数据入库
            if ($user->update($data)) {
                //页面跳转
                return redirect()->route("admin.user.index")->with("success","修改成功");
            }
        }  else{
            //显示视图
            return view("admin.user.edit",compact("user"));
        }
    }
    //删除商家信息
    public function del($id){
        DB::transaction(function () use ($id) {
            //删除用户
            $user = User::find($id)->delete();
            //删除店铺
            $info = Info::where("user_id", $id)->delete();
        });
        return redirect()->route("admin.user.index")->with("success","删除成功");
    }





//    //给商家添加店铺
//    public function shopAdd(Request $request){
//        //判断post提交
//        if ($request->isMethod("post")) {
//            //接收数据,数据入库
//            $data = $request->post();
//            $data['on_time']=$request->has('on_time')?'1':'0';
//            $data['brand']=$request->has('brand')?'1':'0';
//            $data['fengniao']=$request->has('fengniao')?'1':'0';
//            $data['bao']=$request->has('bao')?'1':'0';
//            $data['piao']=$request->has('piao')?'1':'0';
//            $data['zhun']=$request->has('zhun')?'1':'0';
//
//            //设置店铺的状态为0 未审核
//            $data['status'] = 1;
////            $data['user_id']=Auth::user()->id;
//
//            Info::create($data);
//            //跳转视图
//            return redirect()->route("admin.user.index")->with("success","店铺添加成功");
//        }else{
//            //显示视图
//            $results = ShopCategory::where("status",1)->get();
//            return view("admin.info.shop_add",compact("results"));
//        }
//    }
//    //图片上传
//    public function upload(Request $request)
//    {
//        //处理上传
//        //dd($request->file("file"));
//        $file=$request->file("file");
//
//        if ($file){
//            //上传
//            $url=$file->store("menu_cate");
//            /// var_dump($url);
//            //得到真实地址  加 http的址
////            $url=Storage::url($url);
//            $data['url']=$url;
//            return $data;
//        }
//
//    }
}
