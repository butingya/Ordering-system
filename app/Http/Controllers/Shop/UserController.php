<?php

namespace App\Http\Controllers\Shop;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends BaseController
{
    //商户注册
      public function reg(Request $request){
          //判定post提交方式
          if ($request->isMethod("post")) {
              //接收数据
                $data = $request->post();
              //验证
                $data = $this->validate($request, [
                  "name" => "required|unique:users",
                  "password" => "required",
                  "email" => "required|unique:users"
                ]);
              //密码加密
                $data['password'] = bcrypt($data['password']);
              //入库添加
                User::create($data);
              //跳转
                return redirect()->route("shop.user.login")->with("success","注册成功");
          }else{
              //显示视图
                return view('shop.user.reg');
          }
      }

      //登录
        public function login(Request $request){
          //判断post提交
            if ($request->isMethod("post")) {
                $data = $this->validate($request, [
                    "name" => "required",
                    "password" => "required",
                ]);
                if (Auth::attempt($data,$request->has("remember"))){
                    //登录成功
                    return redirect()->intended(route("shop.user.home_page"))->with("success","登录成功");
                }else{
                    //登录失败
                    //session()->flash("danger","账号或密码错误");
                    return redirect()->back()->withInput()->with("danger","账号或密码错误");
                }
            }
            return view("shop.user.login");
        }
      //注销
        public function logout(){
            Auth::guard("web")->logout();
            return redirect()->route("shop.user.login")->with("success","退出成功");
        }

}
