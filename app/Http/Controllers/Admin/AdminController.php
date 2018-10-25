<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends BaseController
{

    //管理员登录
      public function login(Request $request){
        //判断是否post提交
          if ($request->isMethod("post")) {
              //验证
              $data = $this->validate($request,[
                  "name" => "required",
                  "password" => "required",
              ]);
          //判定账号密码是否有误
             if (Auth::guard("admin")->attempt($data,$request->has("remember"))) {

                //成功
                 return redirect()->intended(route("admin.admin.index"))->with("success","登录成功");
               }else{
                  return redirect()->back()->withInput()->with("danger","账号密码错误");
              }
          }
          //显示视图
            return view("admin.admin.login");
      }
    //退出
      public function logout(){
          Auth::guard("admin")->logout();
          return redirect()->route("admin.admin.login")->with("success","退出成功");
      }

    //修改密码
      public function editPassword(Request $request){
//            $id = Auth::id();
//            $users = Admin::all();
          $admin = Auth::guard('admin')->user();
          //判断接收方法
          if ($request->isMethod("post")) {

          }
      }
    //显示管理员
    public function index(){
        //显示全部数据，视图
        $admins = Admin::all();
        return view("admin.admin.index",compact("admins"));
    }

    //管理员添加
    public function add(Request $request){
        //判断提交方式
        if ($request->isMethod("post")) {
            //接收数据，数据入库，显示视图
            $data = $request->post();
            //密码加密
            $data['password'] = bcrypt($data['password']);
            if (Admin::create($data)) {
                return redirect()->route("admin.user.index")->with("success","管理员加成功");
            }
        }else{
            //显示视图
            return view("admin.user.add");
        }
    }
    //编辑管理员资料
    public function edit(Request $request,$id){
        //通过id找对象
        $admin = Admin::find($id);
        //是不是post提交
        if ($request->isMethod("post")) {
            $data = $request->post();
            //数据入库
            if ($admin->update($data)) {
                //页面跳转
                return redirect()->route("admin.admin.index")->with("success","修改成功");
            }
        }  else{
            //显示视图
            return view("admin.admin.edit",compact("admin"));
        }
    }
    //删除管理员
    public function del($id){
        //通过id找到他
        $admin = Admin::find($id);
        //删除
        if ($admin->delete()) {
            return redirect()->route('admin.admin.index')->with("success","删除成功");
        }
    }

}
