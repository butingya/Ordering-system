<?php

namespace App\Http\Controllers\Admin;

use App\Models\Info;
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
}
